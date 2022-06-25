'use strict';

(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.boatshowCountdown = {
    attach: function attach(context, settings) {
      $(context).find('.brick--type--countdown').once('countdown').each(function () {
        var $countdownBrick = $(this);
        var $countdownElem = $countdownBrick.find('.jquery-countdown');
        var countdownDate = $countdownElem.data('countdown-date');

        $countdownElem.countdown({
          'date': countdownDate,
          'template': '' + '<div class="countdown-item"><span class="countdown-value">%m</span><span class="countdown-label">%tm</span></div>' + '<div class="countdown-item"><span class="countdown-value">%d</span><span class="countdown-label">%td</span></div>' + '<div class="countdown-item"><span class="countdown-value">%h</span><span class="countdown-label">%th</span></div>' + '<div class="countdown-item"><span class="countdown-value">%i</span><span class="countdown-label">%ti</span></div>',
          'yearsAndMonths': true,
          'updateTime': 30000
        });
      });
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=countdown.js.map
