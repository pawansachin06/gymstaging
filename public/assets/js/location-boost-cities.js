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
        });

        google.maps.importLibrary('maps').then(function (maps) {
            myMap = new maps.Map(myMapContainer, {
                zoom: 8, zoomControl: true,
                center: myMapCenter,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
                // mapId: 'DEMO_MAP_ID',
            });
            // postcodeLayer = myMap.getFeatureLayer('POSTAL_CODE');
        });
    });


    Alpine.data('page', function () {
        return {
            keyword: '',
            placeSuggestions: [],

            slots: [],
            slotsLoading: false,

            drafts: [],
            isCheckingOut: false,

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
                }).then(function (response) {
                    const suggestions = response.suggestions;
                    self.placeSuggestions = [];
                    if (suggestions && suggestions.length > 0) {
                        suggestions.forEach(function (suggestion) {
                            var mainText = `${suggestion.placePrediction.mainText.text}, ${suggestion.placePrediction.secondaryText?.text}`;
                            var placeId = suggestion.placePrediction.placeId;
                            self.placeSuggestions.push({ id: placeId, name: mainText });
                        });
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
                    data: { 'place-id': placeSuggestion.id },
                }).done(function (res) {
                    self.keyword = '';
                    self.slots = res.slots;
                    self.placeSuggestions = [];
                    myMap.setCenter({ lat: res.data[0].latitude, lng: res.data[0].longitude });

                    // var postcodesToHighlight = res.data.map(slot => slot.postcode.code);
                    // postcodeLayer.style = (options) => {
                    //     // 'options.feature.displayName' would be "PR1"
                    //     if (postcodesToHighlight.includes(options.feature.displayName)) {
                    //         return {
                    //             fillColor: '#8106ef', // Purple like your image
                    //             fillOpacity: 0.1,
                    //             strokeColor: '#8106ef',
                    //             strokeWeight: 2,
                    //         };
                    //     }
                    // };
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
                // var marker = new google.maps.marker.AdvancedMarkerElement({
                //     map: myMap,
                //     position: { lat: slot.latitude, lng: slot.longitude },
                //     title: slot.postcode,
                //     content: self.buildMapMarker(),
                // });
                // draft.marker = marker;
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
                var keywordInput = document.querySelector('[data-js="keyword-input"]');
                keywordInput?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(function() {
                    keywordInput?.focus();
                }, 1000);
            },

            getTotal() {
                var self = this;
                var total = 0;
                for (var i = self.drafts.length - 1; i >= 0; i--) {
                    total += self.drafts[i].price;
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
                return val.postcode;
            },

            toPrice(val) {
                if (!val) return '0.00';
                const num = typeof val === 'number' ? val : parseFloat(val);
                if (isNaN(num)) {
                    return `${val}`;
                }
                return num.toFixed(2);
            },

            getDrafts() {
                var self = this;
                jQuery.ajax({
                    method: 'GET',
                    dataType: 'json',
                }).done(function (res) {
                    self.total = res.total;
                    self.drafts = res.items;
                }).fail(function (err) {
                    console.log(getErrorMessage(err));
                });
            },

            init() {
                this.getDrafts();
            },
        }
    });
});
