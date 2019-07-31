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

          // Fixed header stuff
          if ($(window).scrollTop() >= headerOffset) {
            toggleFixedHeaderDesktop(true);
          }

          if ($preHeader.outerHeight() > 0) {
            // Attach window scroll event listener
            $(window).scroll(function() {
              if ($(window).scrollTop() >= headerOffset && !$siteHeader.hasClass('fixed-header')) {
                toggleFixedHeaderDesktop(true);
              }
              else if ($(window).scrollTop() < headerOffset && $siteHeader.hasClass('fixed-header')) {
                toggleFixedHeaderDesktop(false);
              }
            });
          }

          // mobile menu submenu dropdown
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

          // Mobile menu button toggle
          $mobileMenuOpen.click(function(event) {
            event.preventDefault();

            if (!$(context).find('body').hasClass('mobile-open')) {
              toggleMobileMenu(true);
            }
            else {
              toggleMobileMenu(false);
            }
          });
        });

        // Desktop mega menu hover
        $menu.find('.parent-item > a').each(function() {
          var $thisMenuLink = $(this);
          var $submenu = $thisMenuLink.siblings('.menu-dropdown');

          if ($submenu.length) {
            $thisMenuLink.off('click');
          }

          $thisMenuLink.click(function(event) {
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
        });
      }
    };

    function resizeWindowCloseMobileMenu() {
      $(window).resize(function() {
        var $thisWindow = $(this);

        if ($thisWindow.width() > 992) {
          toggleMobileMenu(false);
          $thisWindow.off('resize');
        }
      });
    }

    function toggleMobileMenu(active) {
      if (active) {
        $mobileMenuOpen.addClass('mobile-menu-active');

        if (!$siteHeader.hasClass('fixed-header')) {
          $siteHeader.css('top', $siteHeader.offset().top + 'px');
        }

        $('body').addClass('mobile-open');
        $regionHeader.css('padding-top', $headerBar.outerHeight());
        $contentRegion.css('margin-top', $headerBar.outerHeight());
        resizeWindowCloseMobileMenu();
      }
      else {
        $mobileMenuOpen.removeClass('mobile-menu-active');
        $('body').removeClass('mobile-open');
        $siteHeader.css('top', 0);
        $regionHeader.css('padding-top', 0);
        $contentRegion.css('margin-top', 0);
        resetContentPadding();
      }

      updateState();
    }


    function toggleFixedHeaderDesktop(active) {
      if (active) {
        $siteHeader.addClass('fixed-header');
        $contentRegion.css('margin-top', $siteHeader.outerHeight());
      }
      else {
        $siteHeader.removeClass('fixed-header');
        $contentRegion.css('margin-top', 0);
      }
    }

    function setStateFixed() {
      updateState();
      $siteHeader.css('top', 0);
      toggleFixedHeaderDesktop(true);
      $(window).off('scroll');
    }

    function resetContentPadding() {
      updateState();

      if ($siteHeader.hasClass('fixed-header')) {
        $contentRegion.css('margin-top', $siteHeader.outerHeight());
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
