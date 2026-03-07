jQuery(document).ready(function () {
    if (jQuery(window).width() > 560 && jQuery(window).width() < 991) {
        jQuery('body').addClass('ipad-custom-bp');
    }

    jQuery('.notifications-toggle').on('click', function (e) {
        e.preventDefault();
        jQuery('.tr-dropdown').toggleClass('d-none');
        return false;
    });
    jQuery('#userMenuDropDown').on('hidden.bs.dropdown', function () {
        if (!jQuery('.notification-dropdown').hasClass('d-none')) {
            jQuery('.tr-dropdown').toggleClass('d-none');
        }
    });

});

(function () {
    var pageLoader = document.getElementById('page-loader');
    if (pageLoader) {
        jQuery(window).on('load', function () {
            jQuery('#page-loader').fadeOut(1);
        });
    }



})();
