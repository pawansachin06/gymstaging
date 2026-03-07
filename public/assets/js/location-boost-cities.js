document.addEventListener('alpine:init', function () {
    var myMap = null;
    var sessionToken = null;
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
                zoom: 10, zoomControl: true,
                center: myMapCenter,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
            });
        });
    });


    Alpine.data('page', function () {
        return {
            keyword: '',
            placeSuggestions: [],

            slots: [],
            slotsLoading: false,

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
                    method: 'get',
                    dataType: 'json',
                    url: AVAILABLE_SLOTS_URL,
                    data: { 'place-id': placeSuggestion.id },
                }).done(function (res) {
                    console.log(res);
                    self.slots = res.data.slots;
                }).fail(function (err) {
                    toast.error(getErrorMessage(err));
                }).always(function () {
                    self.slotsLoading = false;
                });
            },

            init() {
                console.log('init');
            }
        }
    });
});
