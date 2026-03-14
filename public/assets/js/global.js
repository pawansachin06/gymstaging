try {
    jQuery.views.settings.delimiters("[%", "%]");
    jQuery.views.helpers("UUID", function () {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    });
} catch (e) {
    console.log(e.message);    
}

const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
jQuery.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': csrfToken }
});

if (typeof Swal !== 'undefined') {
    window.swal = function () { return Swal.fire(...arguments); };
}

window.initMap = function () {
    window.google = google;
    window.dispatchEvent(new Event('google-maps-loaded'));
}

window.toast = (function () {
    if (typeof Swal !== 'function') {
        return function () {};
    }

    var Toast = Swal.mixin({
        toast: true,
        timer: 5000,
        position: 'top',
        timerProgressBar: true,
        showConfirmButton: false,
        didOpen: function (el) {
            el.onmouseenter = Swal.stopTimer;
            el.onmouseleave = Swal.resumeTimer;
        }
    });

    function mergeOptions(base, extra) {
        var result = {};
        var key;
        for (key in base) {
            if (base.hasOwnProperty(key)) {
                result[key] = base[key];
            }
        }
        if (extra) {
            for (key in extra) {
                if (extra.hasOwnProperty(key)) {
                    result[key] = extra[key];
                }
            }
        }
        return result;
    }

    function show(message, options, icon) {
        if (!message) return;
        options = options || {};
        var config = mergeOptions({
            title: message,
            icon: icon
        }, options);
        Toast.fire(config);
    }

    function instance(message, options) {
        show(message, options, 'success');
    }
    instance.show = function (message, options) {
        show(message, options);
    };
    instance.success = function (message, options) {
        show(message, options, 'success');
    };
    instance.error = function (message, options) {
        show(message, options, 'error');
    };
    instance.warning = function (message, options) {
        show(message, options, 'warning');
    };
    instance.info = function (message, options) {
        show(message, options, 'info');
    };
    return instance;
})();


window.getErrorMessage = function (err, fallback = 'Something went wrong') {
    if (!err) return fallback;
    // Axios error
    if (err.response) {
        var data = err.response.data;
        if (typeof data === 'string') return data;
        if (data?.message) return data.message;
        if (data?.error) return data.error;
        if (data?.errors) {
            var firstKey = Object.keys(data.errors)[0];
            if (firstKey) return data.errors[firstKey][0];
        }
        return `Request failed (${err.response.status})`;
    }
    // jQuery / raw XHR
    if (err.responseJSON?.message) {
        return err.responseJSON.message;
    }
    if (err.responseText) {
        try {
            const json = JSON.parse(err.responseText);
            if (json?.message) return json.message;
        } catch {}
    }
    // fetch-style Response error
    if (err.status && err.statusText) {
        return `Request failed (${err.status})`;
    }
    // native Error
    if (err instanceof Error && err.message) {
        return err.message;
    }
    // string
    if (typeof err === 'string') return err;
    // network / timeout custom
    if (err.message) return err.message;
    return fallback;
};
