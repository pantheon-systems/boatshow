window.BoatShows = window.BoatShows || {};

(function($, Drupal, BoatShows) {
  'use strict';

  var Header = function() {
    var $preHeader,
      $siteHeader,
      $headerBar,
      $menu,
      $mobileMenuOpen,
      $regionHeader,
      $contentRegion,
      headerOffset,
      $window,
      $thisContext;

    function updateState() {
      $preHeader = $thisContext.find('.pre-header-wrapper');
      $siteHeader = $thisContext.find('.site-header');
      $headerBar = $siteHeader.find('.header-bar');
      $contentRegion = $thisContext.find('.region.region-content');
      headerOffset = $siteHeader.offset().top;
      $menu = $siteHeader.find('.mega-menu');
      $mobileMenuOpen = $siteHeader.find('.mobile-trigger');
      $regionHeader = $siteHeader.find('.region-header');
    }

    Drupal.behaviors.boatShowHeader = {
      attach: function (context, settings) {
        $thisContext = $(context);
        $thisContext.find('.site-header').once('boatshow-nav').each(function() {
          updateState();

          if ($(window).scrollTop() >= headerOffset) {
            $siteHeader.addClass('fixed-header');
            $contentRegion.css('margin-top', $headerBar.outerHeight());
          }

          if ($preHeader.outerHeight() > 0) {
            // Attach window scroll event listener
            $(window).scroll(function() {
              if ($(window).scrollTop() >= headerOffset && !$siteHeader.hasClass('fixed-header')) {
                $siteHeader.addClass('fixed-header');
                $contentRegion.css('margin-top', $headerBar.outerHeight());
              }
              else if ($(window).scrollTop() < headerOffset && $siteHeader.hasClass('fixed-header')) {
                $siteHeader.removeClass('fixed-header');
                $contentRegion.css('margin-top', '0');
              }
            });
          }

          //
          $menu.find('.parent-item').each(function() {
            var $thisMenuItem = $(this);
            var $thisSubMenu = $thisMenuItem.find('.menu-dropdown');

            // Main nav triggers.
            // var timer;
            $thisMenuItem.hover(function() {
              // mouse in
              if ($(window).width() > 992) {
                // clearTimeout(timer);
                openSubmenu($thisSubMenu);
              }

            }, function() {
              // mouseout
              if ($(window).width() > 992) {
                // NOTE: This timer doesn't actually work, but it's also not hurting
                // anything, so I'm leaving it here for now.
                // timer = setTimeout(closeSubmenu($(this).find('.menu-dropdown')), 1000);
                // TODO: set timeout
                closeSubmenu($thisSubMenu);
              }
            });
          });

          $mobileMenuOpen.click(function(event) {
            event.preventDefault();

            $mobileMenuOpen.toggleClass('mobile-menu-active');

            if (!$(context).find('body').hasClass('mobile-open')) {
              if (!$siteHeader.hasClass('fixed-header')) {
                $siteHeader.css('top', $siteHeader.offset().top + 'px');
              }

              $('body').addClass('mobile-open');
              $regionHeader.css('padding-top', $headerBar.outerHeight());
            }
            else {
              $('body').removeClass('mobile-open');
              $siteHeader.css('top', 0);
              $regionHeader.css('padding-top', 0);

              if (BoatShows.hasOwnProperty('Header')) {
                resetContentPadding();
              }
            }
          });
        });

        $('#block-mainnavigationboatshow .mega-menu .parent-item > a').on('click', function(event) {
          // Sometimes links are links and sometimes they're menu headers, and
          // there's no way to tell them apart! As a workaround, disable preventDefault
          // when
          var $this = $(this);
          var $submenu = $this.siblings('.menu-dropdown');
          if ($submenu.length) {
            event.preventDefault();
          }

          if ($(window).width() <= 992) {
            if ($submenu.hasClass('open')) {
              $submenu.removeClass('open');
            }
            else {
              $submenu.addClass('open');
            }
          }
        });
      }
    };

    function setStateFixed() {
      updateState();
      $siteHeader.addClass('fixed-header');
      $siteHeader.css('top', 0);
      $contentRegion.css('margin-top', $headerBar.outerHeight());
      $(window).off();
    }

    function resetContentPadding() {
      updateState();
      if ($siteHeader.hasClass('fixed-header')) {
        $contentRegion.css('margin-top', $headerBar.outerHeight());
      }
    }

    function openSubmenu($selector) {
      $selector.siblings('a').addClass('open');
      $selector.addClass('open');
    }

    function closeSubmenu($selector) {
      $selector.siblings('a').removeClass('open');
      $selector.removeClass('open');
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
