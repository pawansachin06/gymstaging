document.addEventListener('alpine:init', function(){
    var self = null;
    var stripe = null;
    var elements = null;

    Alpine.data('joinService', function(){
        return {
            url: '',
            step: 1,
            total: 0,
            stepWidth: 33.33,

            name: '',
            email: '',
            password: '',
            newsletter: false,
            passwordConfirmation: '',
            registering: false,

            currencies: [],
            currencyRate: 1,
            currencyCode: 'GBP',
            isCurrenciesOpen: false,

            memberships: [],
            myMembership: null,
            duration: 'monthly',

            stripeReady: false,

            goToStep(val) {
                this.step = val;
                this.stepWidth = val == 3 ? 66.67 : val == 2 ? 66.67 : 33.33;
            },
            handleRegister(){
                if (!self.memberships.length) {
                    self.getMemberships();
                }
                self.registering = true;
                axios.post(self.url, {
                    ajax: 1,
                    name: self.name,
                    email: self.email,
                    action: 'register',
                    password: self.password,
                    newsletter: self.newsletter,
                    password_confirmation: self.passwordConfirmation,
                }).then(function(res) {
                    var msg = res.data.message;
                    self.getMemberships();
                    self.getCurrencies();
                    self.goToStep(2);
                    toast.show(msg);
                }).catch(function(err) {
                    var msg = getErrorMessage(err);
                    toast.error(msg);
                }).finally(function() {
                    self.registering = false;
                });
            },
            getMemberships() {
                axios.get(self.url, {
                    params: {action: 'get-memberships', ajax: 1}
                }).then(function(res) {
                    self.memberships = res.data.items;
                }).catch(function(err) {
                    var msg = getErrorMessage(err);
                    toast.error(msg);
                });
            },
            getMembershipOrderClasses(val) {
                switch (val.sequence) {
                    case 1:
                    case 4:
                        return 'order-2 order-md-1'; // second on mobile, first on desktop
                    case 2:
                    case 5:
                        return 'order-1 order-md-2'; // first on mobile, center on desktop
                    case 3:
                    case 6:
                        return 'order-3 order-md-3'; // last everywhere
                    default:
                        return '';
                }
            },
            handleMembership(val) {
                // or an API request will be made to get total price from server
                self.total = val.price * self.currencyRate;
                self.myMembership = val;
                self.initStripe();
                self.goToStep(3);
            },
            getPrice(val) {
                return toPrice(val.price * self.currencyRate, self.currencyCode);
            },
            getCurrencies() {
                axios.get(self.url, {
                    params: {action: 'get-currencies', ajax: 1}
                }).then(function(res) {
                    self.currencies = res.data.items;
                }).catch(function(err) {
                    var msg = getErrorMessage(err);
                    toast.error(msg);
                });
            },
            handleCurrency(val) {
                self.isCurrenciesOpen = false;
                setTimeout(function(){
                    self.currencyCode = val.code;
                    self.currencyRate = val.rate;
                }, 500);
            },
            getMembershipFeaturesTitle(val) {
                if (val.sequence == 2) {
                    return 'Everything in Basic, Plus:';
                } else if (val.sequence == 3) {
                    return 'Everything in Plus, Plus:';
                } else {
                    return 'Key features:';
                }
            },
            initStripe() {
                stripe = Stripe(STRIPE_KEY);
                elements = stripe.elements({
                    appearance: {
                        inputs: 'condensed',
                        variables: {
                            colorText: '#303238',
                            colorDanger: '#e5424d',
                            colorPrimary: '#00a4e2',
                            fontFamily: '"Montserrat", sans-serif'
                        }
                    },
                    fonts: [{
                        cssSrc: 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap'
                    }],
                    amount: self.total,
                    mode: 'subscription',
                    paymentMethodCreation: 'manual',
                    currency: self.currencyCode.toLowerCase(),
                });
                var paymentElement = elements.create('payment');
                paymentElement.mount('#payment-element');
                paymentElement.on('ready', function () {
                    self.stripeReady = true;
                });
            },
            init() {
                self = this;
                self.getMemberships();
            }
        };
    });
});