document.addEventListener('alpine:init', function(){
    var self = null;
    var stripe = null;
    var elements = null;
    var paymentElement = null;

    function initStripe() {
        if (!stripe) {
            stripe = Stripe(STRIPE_KEY);
        }
    }

    Alpine.data('joinService', function(){
        return {
            url: '',
            step: 1,
            total: 0,
            serviceId: '',
            redirectUrl: '',
            checkoutUrl: '',
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

            couponCode: '',
            refreshingCheckout: false,
            pricing: {subtotal:0, total:0, discount:0},

            memberships: [],
            myMembership: null,
            duration: 'monthly',

            isPaying: false,
            checkoutId: null,
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
                    console.log(msg);
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
                val.loading = true;
                self.myMembership = val;
                axios.get(self.url, {
                    params: {action: 'checkout', membership_id: val.id, ajax: 1}
                }).then(function(res) {
                    self.serviceId = res.data.service_id;
                    self.redirectUrl = res.data.redirect_url;
                    self.checkoutUrl = res.data.checkout_url;
                    self.goToStep(3);
                    setTimeout(function() {
                        self.refreshCheckout();
                    }, 500);
                }).catch(function(err) {
                    var msg = getErrorMessage(err);
                    toast.error(msg);
                }).finally(function(){
                    val.loading = false;
                });
            },
            getPrice(val) {
                if (val === null) return '';
                return toPrice(val.prices[self.currencyCode] ?? 0, self.currencyCode);
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
            removeCoupon() {
                self.couponCode = '';
                if (self.pricing.discount > 0) {
                    self.refreshCheckout();
                }
            },
            refreshCheckout() {
                self.refreshingCheckout = true;
                axios.post(self.checkoutUrl, {
                    name: self.name,
                    email: self.email,
                    password: self.password,
                    service_id: self.serviceId,
                    newsletter: self.newsletter,
                    coupon_code: self.couponCode,
                    checkout_id: self.checkoutId,
                    currency_code: self.currencyCode,
                    membership_id: self.myMembership.id,
                }).then(function(res) {
                    self.pricing = res.data.pricing;
                    self.checkoutId = res.data.checkout_id;
                    self.redirectUrl = res.data.redirect_url;
                    self.mountStripe(res.data.client_secret);
                    setTimeout(function(){
                        self.stripeReady = true;
                    }, 1000);
                    localStorage.setItem('checkout_id', res.data.checkout_id);
                }).catch(function(err) {
                    var msg = getErrorMessage(err);
                    toast.error(msg);
                }).finally(function(){
                    self.refreshingCheckout = false;
                });
            },
            handleCheckout() {
                if (self.isPaying) {
                    return;
                }
                self.isPaying = true;
                stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: self.redirectUrl,
                    }
                }).then(function(res) {
                    // will redirect
                }).catch(function(err){
                    var msg = getErrorMessage(err);
                    toast.error(msg);
                    self.isPaying = false;
                });
            },
            mountStripe(clientSecret) {
                initStripe();
                // destroy old
                if (paymentElement) {
                    paymentElement.unmount();
                    paymentElement = null;
                }
                elements = stripe.elements({
                    clientSecret: clientSecret,
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
                });
                paymentElement = elements.create('payment');
                paymentElement.mount('#payment-element');
                paymentElement.on('ready', function () {
                    self.stripeReady = true;
                });
            },
            init() {
                self = this;
                self.getMemberships();
                self.checkoutId = localStorage.getItem('checkout_id');
            }
        };
    });
});