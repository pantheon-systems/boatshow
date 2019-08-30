'use strict';

(function ($, Drupal) {

  Drupal.behaviors.boatshowSailingShow = {
    attach: function attach(context, settings) {

          $('.view.view-booths.view-id-booths .views-row .views-field.views-field-field-exhbtr-lctn-booth').text(function (index, oldText) {
            return oldText.replace(/^\s+|\s+$/g, '');
          })
          $('.view.view-booths.view-id-booths .views-row .views-field.views-field-field-exhbtr-lctn-booth').text(function (index, oldText) {
            return oldText.replace(/^\s+/, '');
          })
     }
  };
})(jQuery, Drupal);
