var boatingMapUtil = {};

  boatingMapUtil.isMobile = function() {
    var _ua = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    var _resolution = Modernizr.mq('(max-width: 1024px)');
    return {
      ua: _ua,
      resolution: _resolution,
      checkAll: _ua && _resolution,
      checkAny: _ua || _resolution
    };
  }

    // TODO: Set language on page? This may be something Drupal needs to do, not sure how this is going to be hooked up yet.
    boatingMapUtil.lang = 'en-us';//window.NMMA_OPTIONS && window.NMMA_OPTIONS.lang
        //? window.NMMA_OPTIONS.lang.toLowerCase()
        //: 'en-us';

    boatingMapUtil.viewport = function() {
        var e = window, a = 'inner';
        if (!('innerWidth' in window)) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        return { width: e[a + 'Width'], height: e[a + 'Height'] };
    };

    (function($, sr) {

        var debounce = function(func, threshold, execAsap) {
            var timeout;

            return function debounced() {
                var obj = this,
                    args = arguments;

                function delayed() {
                    if (!execAsap)
                        func.apply(obj, args);
                    timeout = null;
                }

                if (timeout)
                    clearTimeout(timeout);
                else if (execAsap)
                    func.apply(obj, args);

                timeout = setTimeout(delayed, threshold || 100);
            };
        };

        jQuery.fn[sr] = function(fn) { return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

    })(jQuery, 'smartresize');

    // $.validator.addMethod('zip', function (value) {
    //     return /^\d{5}(-\d{4})?$|^([A-Z]\d[A-Z]\s\d[A-Z]\d)$/.test(value);
    // }, 'Please enter a valid zip code.');

    // $.validator.addMethod('optionalZip', function (value, element, options) {
    //     var valid = true;
    //
    //     if (options.required != true && value == "") {
    //         return valid;
    //     }
    //
    //     valid = /^\d{5}(-\d{4})?$|^([A-Z]\d[A-Z]\s\d[A-Z]\d)$/.test(value);
    //
    //     return valid;
    // }, 'Please enter a valid US or Canadian zip code.');

    // $.validator.addMethod('requiredIf', function (value, element, options) {
    //     var el = $(options.element);
    //
    //     if (el.length == 0  || el.val() == "") {
    //         return true;
    //     }
    //
    //     if (value != "") {
    //         return true;
    //     }
    //
    //     return false;
    // }, 'Please enter a valid radius.');


    // boatingMapUtil.bindValidation = function (element, customRules) {
    //     $(element).validate({
    //         errorElement: "span",
    //         errorClass: "input-validation-error",
    //         errorPlacement: function (error, el) {
    //             $('<span class="field-validation-error"></span>').append(error).insertAfter(el);
    //         },
    //         success: function (label) {
    //             label.parent().remove();
    //         },
    //         rules: customRules
    //     });
    // };
  // boatingMapUtil
