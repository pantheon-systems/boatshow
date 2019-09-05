(function($, Drupal) {
  'use strict';

  // Example of Drupal behavior loaded.
  Drupal.behaviors.boatshowNewsletter = {
    attach: function attach(context, settings) {

      // Newsletter events.
      if ($('#newsletter-optin').length) {
        var checkbox = $('#newsletter-optin');
        var button = $('.newsletter-form input.form-submit');

        if (checkbox.is(':checked')) {
          button.removeAttr('disabled');
        } else {
          button.attr('disabled', 'disabled');
        }

        checkbox.on('change', function() {
          if (checkbox.is(':checked')) {
            button.removeAttr('disabled');
          } else {
            button.attr('disabled', 'disabled');
          }
        });
      }

    }
  }
})(jQuery, Drupal);
