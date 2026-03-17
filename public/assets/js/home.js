class SearchWidget {

    constructor(root) {
        this.root = root;
        
        this.sessionToken = null;
        this.autocompleteRequest = null;
        this.autocompleteService = null;

        this.serviceInput = root.querySelector("#serviceInput");
        this.locationInput = root.querySelector("#locationInput");

        this.serviceSuggestions = root.querySelector("#serviceSuggestions");
        this.locationSuggestions = root.querySelector("#locationSuggestions");

        this.serviceInputBox = root.querySelector("#serviceInputBox");
        this.locationInputBox = root.querySelector("#locationInputBox");

        this.searchBtn = root.querySelector("#searchBtn");
        this.detectLocation = root.querySelector("#detectLocation");

        this.service = null;
        this.location = null;

        this.activeIndex = -1;
        this.currentList = null;

        this.bindEvents();
    }

    bindEvents() {
        var self = this;

        this.serviceInput.addEventListener("input",
            this.debounce(this.onServiceInput.bind(this),300));

        this.locationInput.addEventListener("input",
            this.debounce(this.onLocationInput.bind(this),300));

        this.serviceInput.addEventListener("keydown",
            this.onKeyDown.bind(this));

        this.locationInput.addEventListener("keydown",
            this.onKeyDown.bind(this));

        this.serviceSuggestions.addEventListener("click",
            this.onServiceClick.bind(this));

        this.locationSuggestions.addEventListener("click",
            this.onLocationClick.bind(this));

        document.addEventListener("click",
            this.onOutsideClick.bind(this));

        this.detectLocation.addEventListener("click",
            this.detectUserLocation.bind(this));

        this.searchBtn.addEventListener("click",
            this.performSearch.bind(this));

        window.addEventListener('google-maps-loaded', function() {
            google.maps.importLibrary('places').then(function (places) {
                self.autocompleteService = places.AutocompleteSuggestion;
                self.sessionToken = new google.maps.places.AutocompleteSessionToken();
                self.autocompleteRequest = {
                    includedRegionCodes: ['gb'], // United Kingdom only
                    sessionToken: self.sessionToken,
                };
            });
        });
    }

    debounce(fn, delay=300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer=setTimeout(() => fn(...args),delay);
        }
    }

    /* SERVICE SEARCH */

    onServiceInput(e){
        var self = this;
        const query = e.target.value.trim();
        if(!query){
            this.serviceInput.parentElement.classList.remove('active');
            this.serviceInput.classList.remove('active');
            this.hide(this.serviceSuggestions);
            return;
        }
        axios.get('', { params: {
            ajax: 1, q: encodeURIComponent(query),
        } }).then(function(res){
            self.renderServiceSuggestions(res.data.items, query);
        });
    }

    renderServiceSuggestions(items, query){
        if(!items.length){
            this.serviceInput.parentElement.classList.remove('active');
            this.serviceInput.classList.remove('active');
            this.hide(this.serviceSuggestions);
            return;
        }
        this.serviceSuggestions.replaceChildren();
        for(var j = items.length - 1; j >= 0; j--) {
            var item = items[j];
            var container = document.createElement('div');
            var img = document.createElement('img');
            img.src = item.image_url;
            img.setAttribute('width', 36);
            img.setAttribute('height', 36);
            img.classList.add('rounded-circle', 'shadow-sm', 'flex-shrink-0');
            container.appendChild(img);
            container.classList.add('suggestion-item', 'px-2.5', 'py-2', 'd-flex', 'gap-2', 'border-top');
            container.setAttribute('data-value', item.name);
            container.setAttribute('data-name', item.name);
            container.setAttribute('data-permalink', item.permalink);
            var textBox = document.createElement('div');
            var title = document.createElement('div');
            title.appendChild(this.highlightText(item.name, query));
            title.classList.add('text-truncate', 'fw-medium');
            textBox.appendChild(title);
            textBox.classList.add('flex-grow-1', 'lh-sm', 'text-truncate');
            container.appendChild(textBox);
            this.serviceSuggestions.appendChild(container);
        }

        this.currentList = this.serviceSuggestions;
        this.activeIndex = -1;

        this.show(this.serviceSuggestions);
        this.serviceInputBox.classList.add('active');
        this.serviceInput.classList.add('active');

        var height = this.serviceSuggestions.scrollHeight + this.serviceInput.offsetHeight + 4;
        this.serviceInputBox.style.setProperty('--height', height + 'px');
    }

    onServiceClick(e){
        const item = e.target.closest(".suggestion-item");
        if(!item) return;
        
        if (item.dataset.permalink?.length) {
            window.location.href = item.dataset.permalink;
            return;
        }

        this.service = item.dataset.value;
        this.serviceInput.value = this.service;

        this.serviceInputBox.classList.remove('active');
        this.serviceInput.classList.remove('active');
        this.hide(this.serviceSuggestions);
        this.show(this.locationInputBox);

        this.locationInput.focus();
    }

    /* LOCATION SEARCH */

    async onLocationInput(e){
        var self = this;
        const query = e.target.value.trim();
        if(query.length < 2) return;
        self.autocompleteService?.fetchAutocompleteSuggestions({
            input: query,
            sessionToken: self.sessionToken,
            includedRegionCodes: ['gb'],
        }).then(function(response){
            self.renderLocationSuggestions(response.suggestions, query);
        }).catch(function(err) {
            toast.error(getErrorMessage(err));
        });
    }

    highlightText(text, query) {
        const fragment = document.createDocumentFragment();
        if (!query) {
            fragment.appendChild(document.createTextNode(text));
            return fragment;
        }
        const tokens = query.toLowerCase().trim().split(/\s+/).filter(Boolean);
        let i = 0;
        while (i < text.length) {
            let matched = false;
            for (const token of tokens) {
                const len = token.length;
                const substr = text.substr(i, len);
                const prevChar = text[i - 1];
                const isWordStart = i === 0 || /\s|,/.test(prevChar);
                if (
                     substr.toLowerCase() === token &&
                    (isWordStart || token.length > 2) // allow mid-word only for longer tokens
                ) {
                    const span = document.createElement('span');
                    span.classList.add('fw-bold');
                    span.textContent = substr;
                    fragment.appendChild(span);
                    i += len;
                    matched = true;
                    break;
                }
            }
            if (!matched) {
                fragment.appendChild(document.createTextNode(text[i]));
                i++;
            }
        }
        return fragment;
    }

    renderLocationSuggestions(items, query){
        this.locationSuggestions.replaceChildren();
        for(var j = items.length - 1; j >= 0; j--) {
            var item = items[j].placePrediction;
            var mainText = `${item.mainText.text}, ${item.secondaryText?.text || ''}`;
            var div = document.createElement('div');
            div.setAttribute('data-name', mainText);
            div.setAttribute('data-id', item.placeId);
            div.classList.add('suggestion-item', 'px-2.5', 'py-1', 'lh-sm', 'small', 'border-top');
            div.appendChild(this.highlightText(mainText, query));
            this.locationSuggestions.appendChild(div);
        }
        this.currentList = this.locationSuggestions;
        this.activeIndex = -1;
        this.show(this.locationSuggestions);
        if (items.length) {
            this.locationInput.classList.add('active');
            this.locationInputBox.classList.add('active');
        }
        var height = this.locationSuggestions.scrollHeight + this.locationInput.offsetHeight + 4;
        this.locationInputBox.style.setProperty('--height', height + 'px');
    }

    onLocationClick(e){
        var self = this;
        const item = e.target.closest('.suggestion-item');
        if(!item) return;
        var placeId = item.dataset.id;
        self.location = {
            name: item.dataset.name,
            lat: item.dataset.lat,
            lng: item.dataset.lng,
            id: item.dataset.id,
        }
        this.locationInput.value = this.location.name;
        this.locationInput.classList.remove('active');
        this.locationInputBox.classList.remove('active');
        this.hide(this.locationSuggestions);
        self.searchBtn.classList.remove('d-none');
        axios.get('/api/v1/google/places', {
            params: {'place-id': placeId}
        }).then(function(res) {
            if(res.data.item) {
                self.location.lat = res.data.item.latitude;
                self.location.lng = res.data.item.longitude;
            }
        });
    }

    /* KEYBOARD NAVIGATION */

    onKeyDown(e){
        if(!this.currentList) return;

        const items = this.currentList.querySelectorAll(".suggestion-item");

        if(!items.length) return;

        if(e.key==="ArrowDown"){
            e.preventDefault();
            this.activeIndex =
                (this.activeIndex + 1) % items.length;
        }

        else if(e.key==="ArrowUp"){
            e.preventDefault();
            this.activeIndex =
                (this.activeIndex - 1 + items.length) % items.length;
        }
        else if(e.key==="Enter"){
            e.preventDefault();
            if(this.activeIndex>=0){
                items[this.activeIndex].click();
            }
        }
        else if(e.key==="Escape"){
            this.hide(this.currentList);
        }
        items.forEach(i=>i.classList.remove("active"));
        if(this.activeIndex>=0){
            items[this.activeIndex].classList.add("active");
        }
    }

    /* GEOLOCATION */

    detectUserLocation(){
        if(!navigator.geolocation) return;
        var self = this;
        navigator.geolocation.getCurrentPosition(function(pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            axios.get('/api/v1/google/maps', {
                params: { position: `${lat},${lng}` }
            }).then(function(res) {
                if (res.data.items?.length) {
                    self.locationInputBox.classList.remove('active');
                    self.locationInput.classList.remove('active');
                    self.locationSuggestions.replaceChildren();
                    self.location = {
                        name: res.data.items[0].address,
                        lat, lng
                    }
                    self.locationInput.value = res.data.items[0].address;
                    self.searchBtn.classList.remove('d-none');
                } else {
                    toast.error('Address not found');
                }
            }).catch(function(err) {
                toast.error(getErrorMessage(err));
            });
        }, function(err){
            toast.error(getErrorMessage(err));
        });
    }

    /* SEARCH ACTION */

    performSearch(){
        if(!this.service || !this.location) return;
        var pos = this.location.lat + ',' + this.location.lng;
        const params = new URLSearchParams({
            b: 1,
            pos: pos,
            s: this.location.name,
            service: this.service,
            r: 200,
        });
        window.location.href = `/search?${params}`;
    }

    /* UTILITIES */

    show(el){
        el.classList.add("show");
        el.classList.remove("d-none");
        el.style.maxHeight = el.scrollHeight + "px";
    }

    hide(el){
        el.classList.remove("show");
        el.style.maxHeight = "0px"
    }

    onOutsideClick(e){
        if(!this.root.contains(e.target)){
            this.locationInputBox.classList.remove('active');
            this.locationInput.classList.remove('active');
            this.serviceInputBox.classList.remove('active');
            this.serviceInput.classList.remove('active');
            this.hide(this.locationSuggestions);
            this.hide(this.serviceSuggestions);
        }
    }

}

document.addEventListener("DOMContentLoaded",()=>{
    new SearchWidget(document.getElementById("searchWidget"))
});