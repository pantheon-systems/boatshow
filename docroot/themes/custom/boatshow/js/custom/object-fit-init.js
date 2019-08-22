(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.objectFitInit = {
    attach: function (context, settings) {
      $(context).find('img').once('object-fit-init').each(function() {
        // Object fit polyfill for older browsers
        objectFitImages();
      });
    }
  };
})(jQuery, Drupal);
