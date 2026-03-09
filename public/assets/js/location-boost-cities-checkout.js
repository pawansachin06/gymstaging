(function () {
    var stripe = null;
    var btnCheckout = document.getElementById('btn-checkout');

    function initStripe(stripe) {
        stripe = Stripe(STRIPE_KEY);
        var elements = stripe.elements({
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
            clientSecret: CLIENT_SECRET,
        });
        var paymentElement = elements.create('payment', {
            fields: {
                billingDetails: {
                    name: 'never',
                    phone: 'never',
                },
            },
        });
        paymentElement.mount('#payment-element');
        setTimeout(function () {
            btnCheckout.parentElement.classList.remove('d-none');
        }, 4000);
    }

    function handleSubmit() {
        btnCheckout.disabled = true;
        stripe.confirmPayment({
            elements: elements,
            confirmParams: { return_url: RETURN_URL }
        }).then(function (result) {
            if (result.error) {
                btnCheckout.disabled = false;
                toast.error(result.error.message);
            }
            // If no error, Stripe will redirect automatically
            // to return_url after authentication if required.
        });
    }

    btnCheckout.addEventListener('click', handleSubmit);

    initStripe();
})();