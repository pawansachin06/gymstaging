window.addEventListener('google-maps-loaded', function () {
    var myMap = null;
    var myMapCenter = { lat: latitude, lng: longitude };
    var myMapContainer = document.getElementById('listing-map-container');

    if (!myMapContainer) return;

    function buildMapMarker() {
        var div = document.createElement('div');
        var img = document.createElement('img');
        img.src = MARKER_IMAGE_URL;
        img.setAttribute('width', 54);
        img.setAttribute('height', 54);
        div.appendChild(img);
        return div;
    }

    google.maps.importLibrary('maps').then(function (maps) {
        myMap = new maps.Map(myMapContainer, {
            zoom: 10, zoomControl: true,
            center: myMapCenter,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
            mapId: myMapContainer.getAttribute('data-id'),
        });
        google.maps.importLibrary('marker').then(function (markerLib) {
            new markerLib.AdvancedMarkerElement({
                map: myMap,
                position: myMapCenter,
                content: buildMapMarker(),
            });
        });
    });
});

document.addEventListener('alpine:init', function(){
    var self = this;
    Alpine.data('listing', function(){
        return {
            url: '',

            reviews: [],
            reviewsPage: 1,
            reviewsLast: 1,
            reviewsTotal: 0,
            reviewsPages: [],
            reviewsLoading: false,

            getReviews(page = null) {
                self.reviewsLoading = true;
                page = page ? page : self.reviewsPage;
                axios.get(self.url, {
                    params: { ajax: 1, page: page, model: 'listing-review' },
                }).then(function(res) {
                    self.reviews = res.data.items;
                    self.reviewsPage = res.data.page;
                    self.reviewsLast = res.data.last;
                    self.reviewsTotal = res.data.total;
                    self.reviewsPages = [];
                    var start = Math.max(1, self.reviewsPage - 2);
                    var end = Math.min(self.reviewsLast, self.reviewsPage + 2);
                    for (var i = start; i <= end; i++) {
                        self.reviewsPages.push(i);
                    }
                }).catch(function(err) {
                    var msg = getErrorMessage(err);
                    toast.error(msg);
                }).finally(function(){
                    self.reviewsLoading = false;
                });
            },

            truncate(text, length) {
                return text.length > length 
                    ? text.substring(0, length) + '...' 
                    : text;
            },

            init() {
                self = this;
                self.$nextTick(function () {
                    self.getReviews();
                });
            }
        }
    });
});