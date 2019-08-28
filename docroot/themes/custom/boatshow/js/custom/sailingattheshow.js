'use strict';

(function ($, Drupal) {

  Drupal.behaviors.boatshowSailingShow = {
    attach: function attach(context, settings) {

          $('.view-id-booths .views-row .views-field-field-exhbtr-lctn-booth').text(function (index, oldText) {
            return oldText.replace(/^\s+|\s+$/g, '');
          })
     }
  };
})(jQuery, Drupal);
