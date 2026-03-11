(function () {
    var stripe = null;
    var elements = null;
    var btnCheckout = document.getElementById('btn-checkout');
    var btnCheckoutLoader = btnCheckout.querySelector('.spinner-border');

    function initStripe() {
        stripe = Stripe(STRIPE_KEY);
        elements = stripe.elements({
            appearance: {
                inputs: 'condensed',
                variables: {
                    colorPrimary: '#00a4e2',
                    colorText: '#303238',
                    colorDanger: '#e5424d',
                    fontFamily: '"Montserrat", sans-serif'
                }
            },
            fonts: [{
                cssSrc: 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap'
            }],
            amount: TOTAL,
            currency: 'usd',
            mode: 'subscription',
            paymentMethodCreation: 'manual',
        });
        var paymentElement = elements.create('payment', {
            fields: {
                billingDetails: {
                    email: 'auto',
                },
            },
        });
        paymentElement.mount('#payment-element');
        paymentElement.on('ready', function () {
            btnCheckout.parentElement.classList.remove('d-none');
        });
    }

    btnCheckout.addEventListener('click', function () {
        btnCheckout.disabled = true;
        btnCheckoutLoader.classList.remove('d-none');
        elements.submit().then(function (result) {
            if (result.error) {
                btnCheckoutLoader.classList.add('d-none');
                toast.error(result.error.message);
                btnCheckout.disabled = false;
                return;
            }
            stripe.createPaymentMethod({
                elements: elements,
                params: {
                    billing_details: {
                        email: USER_EMAIL
                    }
                }
            }).then(function (res) {
                if (res.error) {
                    btnCheckoutLoader.classList.add('d-none');
                    toast.error(res.error.message);
                    btnCheckout.disabled = false;
                    return;
                }
                var paymentMethod = res.paymentMethod;
                jQuery.ajax({
                    method: 'POST',
                    data: {
                        ajax: 1,
                        id: paymentMethod.id
                    },
                    dataType: 'json',
                }).done(function (res) {
                    if (res.redirect) {
                        window.location.href = res.redirect;
                    }
                }).fail(function (err) {
                    btnCheckout.disabled = false;
                    toast.error(getErrorMessage(err));
                    btnCheckoutLoader.classList.add('d-none');
                });
            });
        });
    });

    initStripe();
})();