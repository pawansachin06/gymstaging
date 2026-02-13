
class MyToaster {
    constructor() {
        // This will allow `toast('message')` to directly call the `show` method.
        const instance = (message, options = {}) => {
            this.show(message, options);
        };
        instance.show = (message, options = {}) => {
            this.show(message, options);
        }
        // Attach all the methods to the instance
        instance.success = (message, options = {}) => {
            this.success(message, options);
        };
        instance.error = (message, options = {}) => {
            this.error(message, options);
        };
        return instance;
    }

    // Base toast function
    show(message, options = {}) {
        let defaultOptions = {
            text: message,
            duration: 5000, // 3 seconds
            close: false,
            gravity: "top", // top or bottom
            position: "center", // left, right or center
            style: {
                background: "linear-gradient(180deg, #3c3c3c, #565555)",
            },
            onClick: function () { } // Callback after click
        };
        options.style = {...options.style};
        options.style.left = "10px";
        options.style.right = "10px";
        options.style.padding = "8px 16px";
        options.style.borderRadius = "8px";
        let toastOptions = { ...defaultOptions, ...options };
        if (message && message.length) {
            Toastify(toastOptions).showToast();
        }
    }

    // Success toast
    success(message, options = {}) {
        options.style = { background: "#0fa15a", ...options.style };
        this.show(message, options);
    }

    // Error toast
    error(message, options = {}) {
        options.style = { background: "red", ...options.style };
        this.show(message, options);
    }
}
// Create a toast instance for easy use
if(typeof Toastify != 'undefined') {
    var toast = new MyToaster();
}


function debouncer(func, delay) {
    let debounceTimer;
    return function () {
        var context = this;
        var args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            func.apply(context, args);
        }, delay);
    };
}


function makeAddressSectionsBold(originalString, sections) {
    let sectionsToBold = sections.map(section => [section.offset, section.offset + section.length - 1]);

    sectionsToBold.sort((a, b) => a[0] - b[0]); // Sort sections based on start index
    let mergedSections = [sectionsToBold[0]];

    for (let i = 1; i < sectionsToBold.length; i++) {
        let currentSection = sectionsToBold[i];
        let lastMergedSection = mergedSections[mergedSections.length - 1];

        if (currentSection[0] <= lastMergedSection[1]) {
            lastMergedSection[1] = Math.max(lastMergedSection[1], currentSection[1]);
        } else {
            mergedSections.push(currentSection);
        }
    }

    let result = '';
    let lastIndex = 0;

    mergedSections.forEach(section => {
        let start = section[0];
        let end = section[1];

        result += originalString.substring(lastIndex, start);
        result += `<b>${originalString.substring(start, end + 1)}</b>`;
        lastIndex = end + 1;
    });

    if (lastIndex < originalString.length) {
        result += originalString.substring(lastIndex);
    }
    return result;
}


function getAddressComponentsValue(components = []){
    var country = '', city = '', postalCode = '', street = '';
    for (var i = 0; i < components.length; i++) {
        var component = components[i];
        var componentType = components[i].types[0];
        if(componentType == 'country'){
            country = component.long_name;
        } else if(componentType == 'postal_town') {
            city = component.long_name;
        } else if(componentType == 'locality') {
            city = city.length ? city : component.long_name;
        } else if(componentType == 'neighborhood') {
            city = city.length ? city : component.long_name;
        } else if(componentType == 'postal_code') {
            postalCode = component.long_name;
        } else if(componentType == 'administrative_area_level_1') {
            street = component.long_name;
        } else if(componentType == 'locality') {
            street = street.length ? street : component.long_name;
        } else if(componentType == 'political') {
            street = street.length ? street : component.long_name;
        } else if(componentType == 'route') {
            street = street.length ? street : component.long_name;
        }
    }
    console.log(components);
    return {
        country: country, city: city, postalCode: postalCode, street: street,
    };
}

