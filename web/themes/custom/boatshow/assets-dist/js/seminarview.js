'use strict';

(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.boatshowSeminarView = {
    attach: function attach(context, settings) {
      $('.view-seminarreference .view-content .grouping-row').once('boatshowSeminarView').text(function (index, oldText) {
        return oldText.replace(/^\s+|\s+$/g, '');
      });
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=seminarview.js.map
