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


(function(){
    if (typeof GLightbox !== 'undefined') {
        var lightbox = GLightbox({
            selector: '.glightbox',
        });
    }

    var forms = document.querySelectorAll('[data-js="form"]');
    for (var i = forms.length - 1; i >= 0; i--) {
        forms[i].addEventListener('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formMsg = form.querySelector('[data-js="form-msg"]');
            var formBtn = form.querySelector('[data-js="form-btn"]');
            var loader = formBtn.querySelector('[data-js="loader"]');
            
            formBtn.disabled = true;
            loader?.classList.remove('d-none');

            if (formMsg) {
                formMsg.textContent = 'Please wait...';
                formMsg.classList.add('alert', 'alert-primary');
                formMsg.classList.remove('d-none', 'alert-danger', 'alert-success');
            }

            var data = new FormData(form);
            var url = form.getAttribute('action');

            axios.post(url, data).then(function(res) {
                var msg = res.data.message;
                toast.success(msg);
                if (formMsg) {
                    formMsg.textContent = msg;
                    formMsg.classList.add('alert-success');
                    formMsg.classList.remove('alert-danger', 'alert-primary');
                }
                if (res.data.redirect) {
                    window.location.href = res.data.redirect;
                }
                if (res.data.reload) {
                    window.location.reload();
                }
            }).catch(function(err) {
                var msg = getErrorMessage(err);
                toast.error(msg);
                if (formMsg) {
                    formMsg.textContent = msg;
                    formMsg.classList.add('alert-danger');
                    formMsg.classList.remove('alert-success', 'alert-primary');
                }
            }).finally(function() {
                setTimeout(function(){
                    formBtn.disabled = false;
                }, 2000);
                loader?.classList.add('d-none');
            });
        });
    }

    var restoreBtns = document.querySelectorAll('[data-js="restore-btn"]');
    if (restoreBtns) {
        for (let i = 0; i < restoreBtns.length; i++) {
            restoreBtns[i]?.addEventListener('click', function (e) {
                e.preventDefault();
                var btn = this;
                btn.disabled = true;
                var url = btn.getAttribute('data-route');
                var rowId = btn.getAttribute('data-row-id');
                axios.post(url).then(function (res) {
                    toast.success(res.data.message ?? 'No response from server');
                    if (rowId) {
                        document.getElementById(rowId)?.remove();
                    }
                }).catch(function (err) {
                    btn.disabled = false;
                    toast.error(getErrorMessage(err));
                });
            });
        }
    }

    var deleteBtns = document.querySelectorAll('[data-js="delete-btn"]');
    if (deleteBtns) {
        for (let i = 0; i < deleteBtns.length; i++) {
            deleteBtns[i]?.addEventListener('click', function (e) {
                e.preventDefault();
                var btn = this;
                var deleteUrl = btn.getAttribute('data-route');
                var deleteItemName = btn.getAttribute('data-name');
                var deleteRowId = btn.getAttribute('data-row-id');
                var permanent = !!btn.getAttribute('data-permanent');
                var title = permanent ? 'Permanently delete?' : 'Move to bin?';
                var confirmButtonText = permanent ? 'Yes, Delete' : 'Yes, Trash';
                Swal.fire({
                    title: title,
                    text: deleteItemName,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: confirmButtonText,
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-label-secondary",
                    },
                    buttonsStyling: false,
                }).then(function (result) {
                    if (result.isConfirmed) {
                        btn.disabled = true;
                        axios.delete(deleteUrl, {
                            params: {permanent: permanent}
                        }).then(function (res) {
                            toast.success(res.data.message ?? 'No response from server');
                            if (deleteRowId) {
                                document.getElementById(deleteRowId)?.remove();
                            }
                        }).catch(function (err) {
                            toast.error(getErrorMessage(err));
                            btn.disabled = false;
                        });
                    }
                });
            });
        }
    }


    // ui-segmented start
    document.querySelectorAll(".ui-segmented").forEach(function (toggle) {
      var inputs = Array.from(toggle.querySelectorAll('input[type="radio"]'));
      var labels = Array.from(
        toggle.querySelectorAll(".ui-segmented-track label")
      );

      if (inputs.length !== labels.length) {
        console.warn("ui-segmented: inputs and labels mismatch", toggle);
      }

      // set count
      toggle.style.setProperty("--count", inputs.length);

      // assign index
      inputs.forEach(function (input, i) {
        input.dataset.index = i;
      });

      function update(activeInput = null) {
        var activeIndex = activeInput
          ? Number(activeInput.dataset.index)
          : inputs.findIndex((i) => i.checked);

        if (activeIndex < 0) return;

        toggle.style.setProperty("--index", activeIndex);

        labels.forEach(function (label, i) {
          label.classList.toggle("active", i === activeIndex);
        });

        toggle.dispatchEvent(
          new CustomEvent("ui-segmented:change", {
            detail: {
              value: inputs[activeIndex].value,
              index: activeIndex
            }
          })
        );
      }

      inputs.forEach(function(input) {
        input.addEventListener("change", function () {
          update(input);
        });
      });

      update();
    });
    // ui-segmented end

})();



