'use strict';

window.BoatShows = window.BoatShows || {};

(function ($, Drupal, BoatShows) {
  'use strict';

  Drupal.behaviors.boatShowAds = {
    attach: function attach(context, settings) {
      $('.pencil-ad', context).once('ads').each(function () {
        var $pencilAd = $(this);
        var $adCloseBtn = $pencilAd.find('.field > div').append('<div class="pencil-ad-close icon-db-close"></div>');

        $adCloseBtn.click(function () {
          $pencilAd.hide();

          if (BoatShows.hasOwnProperty('Header')) {
            // Set state of header to be fixed if ad is closed
            BoatShows.Header.setStateFixed();
          }
        });
      });
    }
  };
})(jQuery, Drupal, BoatShows);
//# sourceMappingURL=advertisements.js.map
