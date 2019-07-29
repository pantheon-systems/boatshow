window.BoatShows = window.BoatShows || {};

(function($, Drupal, BoatShows) {
  'use strict';

  var Header = function() {
    var $preHeader, $header, $headerBar, $contentRegion, headerOffset, $thisContext, $window;

    Drupal.behaviors.boatShowHeader = {
      attach: function (context, settings) {
        $thisContext = $(context);
        updateState();
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

    function updateState() {
      $preHeader = $thisContext.find('.pre-header-wrapper');
      $header = $thisContext.find('header.header');
      $headerBar = $header.find('.header-bar');
      $contentRegion = $thisContext.find('.region.region-content');
      headerOffset = $header.offset().top;
      console.log(headerOffset);
    }

    function setStateFixed() {
      updateState();
      $header.addClass('fixed-header');
      $contentRegion.css('margin-top', $header.outerHeight());
      $window.off();
    }

    function resetContentPadding() {
      updateState();
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
      },
      getHeaderBarHeight: function() {
        updateState();
        return $headerBar.outerHeight();
      },
      getHeaderOffset: function() {
        updateState();
        return headerOffset;
      }
    };
  };

  BoatShows.Header = new Header();

})(jQuery, Drupal, BoatShows);
