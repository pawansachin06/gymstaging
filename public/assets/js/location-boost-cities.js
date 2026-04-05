document.addEventListener('alpine:init', function () {
    var myMap = null;
    var sessionToken = null;
    var postcodeLayer = null;
    var autocompleteService = null;
    var resolution = 8;
    var coveragePolygon = null;

    var postcodeDistricts = new Set();
    var loadedAreas = new Set();

    var myMapCenter = { lat: lat, lng: lng };
    var myMapContainer = document.getElementById('my-map-container');

    function clearCoverage() {
        if (coveragePolygon) {
            coveragePolygon.setMap(null);
            coveragePolygon = null;
        }
    }

    function getCoverageCells(slots) {
        let cells = new Set();
        slots.forEach(slot => {
            const center = h3.latLngToCell(
                slot.latitude,
                slot.longitude,
                resolution
            );
            // slight expansion
            h3.gridDisk(center, 1).forEach(c => cells.add(c));
        });
        return Array.from(cells);
    }

    function hexUnionBoundary(cells) {
        let edges = new Map();
        cells.forEach(cell => {
            const boundary = h3.cellToBoundary(cell);
            for (let i = 0; i < boundary.length; i++) {
                const a = boundary[i];
                const b = boundary[(i + 1) % boundary.length];
                const key1 = a[0] + "," + a[1] + "|" + b[0] + "," + b[1];
                const key2 = b[0] + "," + b[1] + "|" + a[0] + "," + a[1];
                if (edges.has(key2)) {
                    edges.delete(key2); // internal edge
                } else {
                    edges.set(key1, [a, b]);
                }
            }
        });
        let points = [];
        edges.forEach(edge => {
            points.push({
                lat: edge[0][0],
                lng: edge[0][1]
            });
        });
        return points;
    }

    function sortPolygon(points) {
        const center = points.reduce((acc, p) => {
            acc.lat += p.lat;
            acc.lng += p.lng;
            return acc;
        }, { lat: 0, lng: 0 });
        center.lat /= points.length;
        center.lng /= points.length;
        points.sort((a, b) => {
            const angleA = Math.atan2(a.lat - center.lat, a.lng - center.lng);
            const angleB = Math.atan2(b.lat - center.lat, b.lng - center.lng);
            return angleA - angleB;
        });
        return points;
    }

    function convexHull(points) {
        points.sort((a, b) => a.lng === b.lng ? a.lat - b.lat : a.lng - b.lng);
        function cross(o, a, b) {
            return (a.lng - o.lng) * (b.lat - o.lat) -
                (a.lat - o.lat) * (b.lng - o.lng);
        }
        const lower = [];
        for (const p of points) {
            while (lower.length >= 2 &&
                cross(lower[lower.length - 2], lower[lower.length - 1], p) <= 0) {
                lower.pop();
            }
            lower.push(p);
        }
        const upper = [];
        for (let i = points.length - 1; i >= 0; i--) {
            const p = points[i];
            while (upper.length >= 2 &&
                cross(upper[upper.length - 2], upper[upper.length - 1], p) <= 0) {
                upper.pop();
            }
            upper.push(p);
        }
        upper.pop();
        lower.pop();
        return lower.concat(upper);
    }

    function drawPostcodeCoverage(slots) {
        clearCoverage();
        const resolution = 7;
        let cells = new Set();
        slots.forEach(slot => {
            const center = h3.latLngToCell(slot.latitude, slot.longitude, resolution);
            // small expansion to fill gaps
            h3.gridDisk(center, 0).forEach(c => cells.add(c));
        });
        let boundaryPoints = [];
        cells.forEach(cell => {
            const boundary = h3.cellToBoundary(cell);
            boundary.forEach(coord => {
                boundaryPoints.push({
                    lat: coord[0],
                    lng: coord[1]
                });
            });
        });
        const hull = convexHull(boundaryPoints);
        coveragePolygon = new google.maps.Polygon({
            paths: hull,
            strokeColor: "#FF0000",
            strokeOpacity: 0.9,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.2,
            map: myMap
        });
    }

    function drawPostcodeCoverage2(slots) {
        clearCoverage();
        const cells = getCoverageCells(slots);
        let boundary = hexUnionBoundary(cells);
        boundary = sortPolygon(boundary);
        coveragePolygon = new google.maps.Polygon({
            paths: boundary,
            strokeColor: "#FF0000",
            strokeOpacity: 0.9,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.2,
            map: myMap
        });
    }

    function drawPostcodeArea(slots) {
        // clear previous polygons
        myMap.data.forEach(function (feature) {
            myMap.data.remove(feature);
        });
        loadedAreas.clear();
        postcodeDistricts.clear();
        // collect postcode districts (PR1, M1 etc.)
        slots.forEach(function (slot) {
            const code = slot.postcode; // PR1
            postcodeDistricts.add(code);
        });
        // load required GeoJSON files
        postcodeDistricts.forEach(function (code) {
            const area = code.replace(/[0-9].*/, ''); // PR1 -> PR
            if (!loadedAreas.has(area)) {
                myMap.data.loadGeoJson(
                    '/storage/app/public/geojson/gb/' + area + '.geojson'
                );
                loadedAreas.add(area);
            }
        });

        // style only the districts we need
        myMap.data.setStyle(function (feature) {
            const code =
                feature.getProperty('name') ||
                feature.getProperty('Name') ||
                feature.getProperty('postcode');
            if (postcodeDistricts.has(code)) {
                return {
                    fillColor: "#FF0000",
                    strokeColor: "#FF0000",
                    strokeWeight: 2,
                    fillOpacity: 0.25
                };
            }
            return { visible: false };
        });
    }

    window.addEventListener('google-maps-loaded', function () {
        if (!myMapContainer) return;

        google.maps.importLibrary('places').then(function (places) {
            autocompleteService = places.AutocompleteSuggestion;
            sessionToken = new google.maps.places.AutocompleteSessionToken();
            autocompleteRequest = {
                includedRegionCodes: ['gb'], // United Kingdom only
                sessionToken: sessionToken
            };
        });

        google.maps.importLibrary('maps').then(function (maps) {
            myMap = new maps.Map(myMapContainer, {
                zoom: 10, zoomControl: true,
                center: myMapCenter,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
                mapId: myMapContainer.getAttribute('data-id'),
            });
            google.maps.event.addListenerOnce(myMap, 'idle', function () {
                postcodeLayer = myMap.getFeatureLayer('POSTAL_CODE');
                if (!postcodeLayer) {
                    console.warn('POSTAL_CODE layer not available');
                }
                postcodeLayer.addListener('style', (options) => {
                    console.warn('STYLE EVENT FIRED:', options.feature.displayName);
                });
                postcodeLayer.addListener('addfeature', (event) => {
                    console.warn('FEATURE ADDED:', event.feature.displayName);
                });
                window.dispatchEvent(new Event('google-maps-ready'));
            });
        });
    });


    Alpine.data('page', function () {
        return {
            keyword: '',
            editing: false,
            activeTab: 'map',
            placeSuggestions: [],

            slots: [],
            slotsLoading: false,

            drafts: [],
            markers: {},
            businessId: 0,
            isCheckingOut: false,
            hasActiveSlots: false,

            cancelSlot: null,

            keywordChange(el) {
                var self = this;
                var keyword = el.value;
                if (keyword.length < 2) {
                    self.placeSuggestions = [];
                    return;
                }
                autocompleteService?.fetchAutocompleteSuggestions({
                    input: keyword,
                    sessionToken: sessionToken,
                    includedRegionCodes: ['gb'],
                }).then(function (response) {
                    const suggestions = response.suggestions;
                    self.placeSuggestions = [];
                    if (suggestions && suggestions.length > 0) {
                        suggestions.forEach(function (suggestion) {
                            var mainText = `${suggestion.placePrediction.mainText.text}, ${suggestion.placePrediction.secondaryText?.text}`;
                            var placeId = suggestion.placePrediction.placeId;
                            self.placeSuggestions.push({ id: placeId, name: mainText });
                        });
                        self.activeTab = 'list';
                    }
                }).catch(function (err) {
                    console.error(err);
                    self.placeSuggestions = [];
                    toast.error('Error fetching autocomplete suggestions');
                });
            },

            handlePlaceSuggestionClick(placeSuggestion) {
                var self = this;
                if (self.slotsLoading) return;
                self.slotsLoading = true;
                jQuery.ajax({
                    cache: false,
                    method: 'GET',
                    dataType: 'json',
                    url: AVAILABLE_SLOTS_URL,
                    data: { 'place-id': placeSuggestion.id, ajax: 1 },
                }).done(function (res) {
                    self.keyword = '';
                    self.slots = res.slots;
                    self.placeSuggestions = [];
                    if (res.zoom) {
                        myMap.setZoom(res.zoom);
                    }
                    myMap.setCenter({ lat: res.slots[0].latitude, lng: res.slots[0].longitude });
                    var postcodesToHighlight = res.data.map(function (slot) {
                        return slot.postcode.code.split(' ')[0];
                    });
                    console.log(postcodesToHighlight);
                    drawPostcodeCoverage(res.slots);
                    // drawPostcodeArea(res.slots);
                }).fail(function (err) {
                    toast.error(getErrorMessage(err));
                }).always(function () {
                    self.slotsLoading = false;
                });
            },

            isPlaceAdded(val) {
                var self = this;
                for (var i = self.drafts.length - 1; i >= 0; i--) {
                    if (val.id == self.drafts[i].id) {
                        return true;
                    }
                }
            },

            buildMapMarker() {
                var div = document.createElement('div');
                var img = document.createElement('img');
                img.src = MARKER_IMAGE_URL;
                img.setAttribute('width', 54);
                img.setAttribute('height', 54);
                div.appendChild(img);
                return div;
            },

            handlePlaceClick(btn, slot) {
                var self = this;
                btn.disabled = true;
                var found = false;
                for (var i = self.drafts.length - 1; i >= 0; i--) {
                    if (self.drafts[i].place_id == slot.id) {
                        found = true;
                        break;
                    }
                }
                if (found) {
                    toast.success('Already selected slot');
                    btn.disabled = false;
                    return;
                }

                var draft = slot;
                draft.place_id = slot.id;
                myMap.setCenter({ lat: slot.latitude, lng: slot.longitude });
                var marker = new google.maps.marker.AdvancedMarkerElement({
                    map: myMap,
                    position: { lat: slot.latitude, lng: slot.longitude },
                    title: slot.postcode,
                    content: self.buildMapMarker(),
                });
                self.markers[draft.id] = marker;
                self.drafts.push(draft);
                toast.success('Added featured spot');
                setTimeout(function () {
                    var draftsContainer = document.querySelector('[data-js="drafts"]');
                    draftsContainer?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    btn.disabled = false;
                }, 500);
            },

            handleDraftRemove(btn, draft) {
                var self = this;
                btn.disabled = true;
                if (self.markers[draft.id]) {
                    self.markers[draft.id].map = null;
                }
                self.drafts = self.drafts.filter(function (item) {
                    return item.id != draft.id;
                });
                var formData = new FormData();
                formData.append('id', draft.id);
                jQuery.ajax({
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    url: DRAFTS_REMOVE_URL,
                    processData: false,
                    contentType: false,
                }).done(function (res) {
                    toast.success(res.message);
                }).fail(function (err) {
                    toast.error(getErrorMessage(err));
                    btn.disabled = true;
                });
            },

            handleDraftAdd() {
                var self = this;
                self.isCheckingOut = true;
                jQuery.ajax({
                    method: 'POST',
                    dataType: 'json',
                    url: DRAFTS_ADD_URL,
                    contentType: 'application/json; charset=utf-8',
                    data: JSON.stringify({ drafts: self.drafts }),
                }).done(function (res) {
                    toast.show(res.message);
                    if (res.redirect) {
                        window.location.href = res.redirect;
                        setTimeout(function () {
                            self.isCheckingOut = false;
                        }, 2000);
                    }
                }).fail(function (err) {
                    self.isCheckingOut = false;
                    toast.error(getErrorMessage(err));
                });
            },

            handleBoostReset() {
                var self = this;
                self.keyword = '';
                self.hasActiveSlots = false;
                var keywordInput = document.querySelector('[data-js="keyword-input"]');
                var keywordInputMobile = document.querySelector('[data-js="keyword-input-mobile"]');
                keywordInputMobile?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // keywordInput?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(function () {
                    keywordInput?.focus();
                }, 1000);
            },

            getTotal() {
                var self = this;
                var total = 0;
                for (var i = self.drafts.length - 1; i >= 0; i--) {
                    total += self.drafts[i].amount;
                }
                return total;
            },

            getName(val) {
                if (val?.address?.length) {
                    return val.address;
                }
                if (val?.city?.length) {
                    return val.city;
                }
                if (val?.country?.length) {
                    return val.country;
                }
                if (val?.country?.name?.length) {
                    return val.country.name;
                }
                if (val?.postal_town?.name?.length) {
                    return val.postal_town.name;
                }
                return val?.postcode;
            },

            getSearchQuery(val) {
                var businessId = this.businessId;
                var q = '/search?b=' + businessId + '&pos=' + val.latitude + ',' + val.longitude + '&s=' + val.postcode + '&r=50';
                return q;
            },

            toPrice(val) {
                if (!val) return '0.00';
                const num = typeof val === 'number' ? val : parseFloat(val);
                if (isNaN(num)) {
                    return `${val}`;
                }
                return num.toFixed(2);
            },

            goToCenter(item) {
                myMap.setZoom(8);
                this.activeTab = 'map';
                myMap.setCenter({ lat: item.latitude, lng: item.longitude });
                setTimeout(function () {
                    myMap.setZoom(12);
                }, 750);
            },

            handleCancelSlotClick(val) {
                var self = this;
                self.cancelSlot = val;
                self.cancelSlot.deleting = false;
                self.cancelSlot.loading = true;
                self.cancelSlot.message = '';
                jQuery('#cancelBoostModal').modal('show');
                jQuery.ajax({
                    method: 'GET',
                    dataType: 'json',
                    data: { ajax: 1 },
                    url: '/location-boost-cities/' + val.id + '/show',
                }).done(function (res) {
                    if (res.item) {
                        self.cancelSlot = res.item;
                        if (res.ends_at?.length) {
                            var endsAt = new Date(res.ends_at);
                            var endsAtFormatted = endsAt.toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });
                            self.cancelSlot.ends_at = endsAtFormatted;
                        }
                        self.cancelSlot.loading = false;
                        self.cancelSlot.message = res.message;
                        self.cancelSlot.canceled = res.canceled;
                    }
                }).fail(function (err) {
                    self.cancelSlot = null;
                    toast.error(getErrorMessage(err));
                    jQuery('#cancelBoostModal').modal('hide');
                });
            },

            handleCancelSlot() {
                var self = this;
                if (!self.cancelSlot) return;
                self.cancelSlot.deleting = true;
                jQuery.ajax({
                    method: 'POST',
                    dataType: 'json',
                    data: { _method: 'DELETE' },
                    url: '/location-boost-cities/' + self.cancelSlot.id + '/delete',
                }).done(function (res) {
                    window.location.reload();
                    toast.success(res.message);
                }).fail(function (err) {
                    self.cancelSlot.deleting = false;
                    toast.error(getErrorMessage(err));
                    jQuery('#cancelBoostModal').modal('hide');
                });
            },

            getDrafts() {
                var self = this;
                jQuery.ajax({
                    method: 'GET',
                    dataType: 'json',
                    data: { ajax: 1 },
                }).done(function (res) {
                    self.total = res.total;
                    self.businessId = res.business_id;
                    self.slots = res.slots.map(function (slot) {
                        var marker = new google.maps.marker.AdvancedMarkerElement({
                            map: myMap,
                            title: slot.postcode,
                            position: { lat: slot.latitude, lng: slot.longitude },
                            content: self.buildMapMarker(),
                        });
                        self.markers[slot.id] = marker;
                        return slot;
                    });
                    self.drafts = res.drafts.map(function (draft) {
                        var marker = new google.maps.marker.AdvancedMarkerElement({
                            map: myMap,
                            title: draft.postcode,
                            position: { lat: draft.latitude, lng: draft.longitude },
                            content: self.buildMapMarker(),
                        });
                        self.markers[draft.id] = marker;
                        return draft;
                    });
                    if (res.slots?.length) {
                        self.editing = true;
                        self.hasActiveSlots = true;
                        myMap.setCenter({ lat: res.slots[0].latitude, lng: res.slots[0].longitude });
                    } else if (res.drafts?.length) {
                        myMap.setCenter({ lat: res.drafts[0].latitude, lng: res.drafts[0].longitude });
                    }
                }).fail(function (err) {
                    console.log(getErrorMessage(err));
                });
            },

            init() {
                var self = this;
                window.addEventListener('google-maps-ready', function () {
                    self.getDrafts();
                });
            },
        }
    });
});


function _init_popOver() {
    jQuery("[data-toggle=popover]").popover({
        html: true,
        trigger: 'click focus',
        container: 'body',
        offset: 125,
        content: function() {
            var content = jQuery(this).attr("data-popover-content");
            return jQuery(content).children(".popover-body").html();
        },
        template: '<div class="popover list-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
    });
}
_init_popOver();
jQuery('body').on('click', '[data-toggle=popover]', function() {
    _init_popOver();
    jQuery('[data-toggle=popover]').not(this).popover('hide');
});
jQuery('body').on('focus', '[data-toggle=popover]', function() {
    _init_popOver();
    jQuery('[data-toggle=popover]').not(this).popover('hide');
});
jQuery('body').on('click', '.popover-close', function() {
    jQuery(this).closest('.list-popover').popover('hide');
});