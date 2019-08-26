window.BoatShows = window.BoatShows || {};

(function($, Drupal, BoatShows) {
  'use strict';

  var Header = function() {
    var $thisBody,
      $preHeader,
      $siteHeader,
      $headerBar,
      $menu,
      $mobileMenuOpen,
      $regionHeader,
      $contentRegion,
      headerOffset,
      $thisContext,
      $thisWindow,
      $adminBarTop,
      $adminBarBottom;

    var desktopBreakpoint = 992;
    var menuOpenClass = 'open';

    function updateState() {
      $preHeader = $thisContext.find('.pre-header-wrapper');
      $siteHeader = $thisContext.find('.site-header');
      $headerBar = $siteHeader.find('.header-bar');
      $contentRegion = $thisContext.find('.region.region-content');
      $menu = $siteHeader.find('.mega-menu');
      $mobileMenuOpen = $siteHeader.find('.mobile-trigger');
      $regionHeader = $siteHeader.find('.region-header');
      headerOffset = $preHeader.outerHeight();
      $adminBarTop = $thisContext.find('nav#toolbar-bar');
      // $adminBarBottom = $thisContext.find('#toolbar-item-administration-tray');
    }

    Drupal.behaviors.boatShowHeader = {
      attach: function (context, settings) {
        $thisContext = $(context);
        $thisContext.find('.site-header').once('boatshow-nav').each(function() {
          updateState();
          $thisWindow = $(window);
          $thisBody = $thisContext.find('body');

          // Fixed header stuff
          if ($thisWindow.scrollTop() >= headerOffset) {
            toggleFixedHeaderDesktop(true);
          }

          $thisWindow.scroll(function() {
            if ($thisWindow.scrollTop() >= headerOffset && !$siteHeader.hasClass('fixed-header')) {
              toggleFixedHeaderDesktop(true);
            }
            else if ($thisWindow.scrollTop() < headerOffset && $siteHeader.hasClass('fixed-header')) {
              toggleFixedHeaderDesktop(false);
            }
          });

          // mobile menu submenu dropdown
          $menu.find('.parent-item').each(function() {
            var $thisMenuItem = $(this);
            var $thisSubMenu = $thisMenuItem.find('.menu-dropdown');
            var timer;
            // Main nav triggers.
            $thisMenuItem.hover(function() {
              $menu.find('.parent-item > .menu-dropdown, .parent-item > a').removeClass(menuOpenClass);

              // mouse in
              if ($thisWindow.width() > desktopBreakpoint) {
                clearTimeout(timer);
                openSubmenu($thisSubMenu);
              }
            }, function() {
              // mouseout
              if ($thisWindow.width() > desktopBreakpoint) {
                timer = setTimeout(function() {
                  closeSubmenu($thisSubMenu);
                }, 200);
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

        // Mobile menu item click events
        $menu.find('.parent-item > a').each(function() {
          var $thisMenuLink = $(this);
          var $submenu = $thisMenuLink.siblings('.menu-dropdown');

          // Remove remove analytics click listeners if mobile menu dropdown toggles
          if ($thisWindow.width() <= desktopBreakpoint && $submenu.length) {
            $thisMenuLink.off('click');
          }

          $thisMenuLink.click(function(event) {
            if ($submenu.length) {
              event.preventDefault();
            }

            if ($thisWindow.width() <= desktopBreakpoint) {
              if ($submenu.hasClass(menuOpenClass)) {
                $submenu.removeClass(menuOpenClass);
              }
              else {
                $submenu.addClass(menuOpenClass);
              }
            }
          });
        });
      }
    };

    function resizeWindowCloseMobileMenu() {
      $thisWindow.resize(function() {
        var $thisWindow = $(this);

        if ($thisWindow.width() > desktopBreakpoint) {
          toggleMobileMenu(false);
          $thisWindow.off('resize');
        }
      });
    }

    /**
     * Toggles mobile menu open or closed
     * bool active: true toggles open, false toggles closed
     */
    function toggleMobileMenu(active) {
      // Open
      if (active) {
        $mobileMenuOpen.addClass('mobile-menu-active');

        if (!$siteHeader.hasClass('fixed-header')) {
          $siteHeader.css('top', $siteHeader.offset().top - $thisWindow.scrollTop());
        }
        $thisBody.css('top', `-${window.scrollY}px`);
        $thisBody.addClass('mobile-open');
        $regionHeader.css('padding-top', $headerBar.outerHeight());
        $contentRegion.css('margin-top', $headerBar.outerHeight());
        resizeWindowCloseMobileMenu();
      }
      // Close
      else {
        var scrollY = $thisBody.css('top');
        $mobileMenuOpen.removeClass('mobile-menu-active');
        $thisBody.removeClass('mobile-open');
        $siteHeader.css('top', 0);
        $regionHeader.css('padding-top', 0);
        $contentRegion.css('margin-top', 0);

        $thisBody.css('position', '');
        $thisBody.css('top', '');
        $thisWindow.scrollTop(parseInt(scrollY || '0') * -1);

        resetContentPadding();
      }

      updateState();
    }

    /**
     * Toggles fixed header state
     * bool active: true toggles fixed, false toggles static
     */
    function toggleFixedHeaderDesktop(active) {
      if (active) {
        $siteHeader.addClass('fixed-header');
        $siteHeader.css('top', $adminBarTop.outerHeight());
        $contentRegion.css('margin-top', $siteHeader.outerHeight());
      }
      else {
        $siteHeader.removeClass('fixed-header');
        $siteHeader.css('top', 0);
        $contentRegion.css('margin-top', 0);
      }
    }

    function setStateFixed() {
      updateState();
      $siteHeader.css('top', 0);
      toggleFixedHeaderDesktop(true);
      $thisWindow.off('scroll');
    }

    function resetContentPadding() {
      updateState();

      if ($siteHeader.hasClass('fixed-header')) {
        $contentRegion.css('margin-top', $siteHeader.outerHeight());
      }
    }

    function openSubmenu($selector) {
      $selector.siblings('a').addClass(menuOpenClass);
      $selector.addClass(menuOpenClass);
    }

    function closeSubmenu($selector) {
      $selector.siblings('a').removeClass(menuOpenClass);
      $selector.removeClass(menuOpenClass);
    }

    return {
      setStateFixed: setStateFixed,
      resetContentPadding: resetContentPadding
    };
  };

  BoatShows.Header = new Header();

})(jQuery, Drupal, BoatShows);
