/**
 * script.js
 *
 * Custom crystal JS inits etc.
 */

(function ($) {
    "use strict";
    $(document).ready(function () {
        //Copyright Year
        var currentYear = (new Date).getFullYear();
        $("#copyright-year").text(currentYear);

        // Init single image popup
        //$('.image-popup').magnificPopup({type: 'image'});

        //$('.format-image a img').parent().magnificPopup({type: 'image'});
        $('.image-popup').magnificPopup({type: 'image'});

    });
})(jQuery);
