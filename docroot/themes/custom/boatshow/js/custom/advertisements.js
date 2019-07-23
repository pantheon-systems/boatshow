'use strict';

(function($, Drupal) {

  // Example of Drupal behavior loaded.
  Drupal.behaviors.boatshowAdvertisements = {
    attach: function attach(context, settings) {

      $('.pencil-ad')
        .find('.field > div')
        .append('<div class="pencil-ad-close icon-db-close"></div>')
        .on('click', function() {
          $('.pencil-ad').hide();
        });
    }
  };
})(jQuery, Drupal);
