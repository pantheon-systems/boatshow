'use strict';

(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.seniorityPoints = {
    attach: function attach(context, settings) {
      $(context).find('.js-seniority-points-agreement').once('seniority-points-agreement').each(function () {
        var $element = $(this);
        $element.find("button").each(function () {
          $(this).click(function () {
            $element.hide();
            $(context).find('.seniority-points').each(function () {
              $(this).show();
            });
            $('html, body').animate({ scrollTop: 0 }, 0);
          });
        });
      });
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=seniority-points.js.map
