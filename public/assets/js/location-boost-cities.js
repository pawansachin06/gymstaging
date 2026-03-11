document.addEventListener('alpine:init', function () {
    var myMap = null;
    var sessionToken = null;
    var postcodeLayer = null;
    var autocompleteService = null;

    var myMapCenter = { lat: lat, lng: lng };
    var myMapContainer = document.getElementById('my-map-container');

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
                mapId: '3090fde3d7f90191d556c527',

            });
            google.maps.event.addListenerOnce(myMap, 'idle', function () {
                postcodeLayer = myMap.getFeatureLayer('POSTAL_CODE');
                if (!postcodeLayer) {
                    console.warn('POSTAL_CODE layer not available');
                }
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
                if (keyword.length < 3) {
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
                    myMap.setCenter({ lat: res.data[0].latitude, lng: res.data[0].longitude });
                    var postcodesToHighlight = res.data.map(function (slot) {
                        return slot.postcode.code.split(' ')[0];
                    });
                    console.log({ postcodesToHighlight });
                    postcodeLayer.style = (options) => {
                        console.log('MAP POSTCODE:', options.feature.displayName);
                        if (postcodesToHighlight.includes(options.feature.displayName)) {
                            return {
                                fillColor: '#8106ef',
                                fillOpacity: 0.1,
                                strokeColor: '#8106ef',
                                strokeWeight: 2,
                            };
                        }
                        return null;
                    };
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
