(function($, Drupal) {
  'use strict';

  Drupal.behaviors.boatshowGlobalFooter = {
    attach: function attach(context, settings) {

      // Footer events.
      if ($('.footer .has-bg').length) {
        var bg = $('.has-bg').css("background-image");
        bg = bg.replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
        if ($('.footer .four-columns').length) {
          $('.footer .four-columns').css('background-image', 'url(' + bg + ')');
          $('.has-bg').removeAttr('style');
        }
      }
    }
  };
})(jQuery, Drupal);
