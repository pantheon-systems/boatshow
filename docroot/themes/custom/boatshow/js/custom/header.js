window.BoatShows = window.BoatShows || {};

(function($, Drupal, BoatShows) {
  'use strict';

  var Header = function() {
    var $header, $contentRegion, headerOffset, thisContext, $window;

    Drupal.behaviors.boatShowHeader = {
      attach: function (context, settings) {
        thisContext = context
        $header = $('header.header', context);
        $contentRegion = $('.region.region-content', context);
        headerOffset = $header.offset().top;
        $window = $(window, context);

        if ($window.scrollTop() >= headerOffset) {
          $header.addClass('fixed-header');
          $contentRegion.css('margin-top', $header.outerHeight());
        }
        else {
          $window.scroll(function() {
            var $thisWindow = $(this);

            if ($thisWindow.scrollTop() >= headerOffset && !$header.hasClass('fixed-header')) {
              $header.addClass('fixed-header');
              $contentRegion.css('margin-top', $header.outerHeight());
            }
            else if ($thisWindow.scrollTop() < headerOffset && $header.hasClass('fixed-header')) {
              $header.removeClass('fixed-header');
              $contentRegion.css('margin-top', '0');
            }
          });
        }
      }
    };

    function setStateFixed() {
      $header = $('header.header', thisContext);
      $header.addClass('fixed-header');
      $contentRegion.css('margin-top', $header.outerHeight());
      $window.off();
    }

    function resetContentPadding() {
      $header = $('header.header', thisContext);
      if ($header.hasClass('fixed-header')) {
        $contentRegion.css('margin-top', $header.outerHeight());
      }
    }

    return {
      setStateFixed: function() {
        setStateFixed();
      },
      resetContentPadding: function() {
        resetContentPadding();
      }
    };
  };

  BoatShows.Header = new Header();

})(jQuery, Drupal, BoatShows);
