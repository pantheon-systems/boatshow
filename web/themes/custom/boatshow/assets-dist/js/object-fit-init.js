'use strict';

(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.objectFitInit = {
    attach: function attach(context, settings) {
      $(context).find('img').once('object-fit-init').each(function () {
        // Object fit polyfill for older browsers
        objectFitImages();
      });
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=object-fit-init.js.map
