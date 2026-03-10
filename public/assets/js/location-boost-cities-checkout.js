(function () {
    var stripe = null;
    var elements = null;
    var btnCheckout = document.getElementById('btn-checkout');

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
            clientSecret: CLIENT_SECRET,
        });
        var paymentElement = elements.create('payment', {
            fields: {
                billingDetails: { },
            },
        });
        paymentElement.mount('#payment-element');
        setTimeout(function () {
            btnCheckout.parentElement.classList.remove('d-none');
        }, 5000);
    }

    btnCheckout.addEventListener('click', function(){
        btnCheckout.disabled = true;
        stripe.confirmPayment({
            elements: elements,
            redirect: 'always',
            confirmParams: { return_url: RETURN_URL }
        }).then(function (result) {
            if (result.error) {
                btnCheckout.disabled = false;
                toast.error(result.error.message);
            }
            // If no error, Stripe will redirect automatically
            // to return_url after authentication if required.
        });
    });

    initStripe();
})();