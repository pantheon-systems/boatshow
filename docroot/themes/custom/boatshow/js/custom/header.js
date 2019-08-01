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
      $thisContext,
      $adminBarTop,
      $adminBarBottom;

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

          // Fixed header stuff
          if ($(window).scrollTop() >= headerOffset) {
            toggleFixedHeaderDesktop(true);
          }

          $(window).scroll(function() {
            if ($(window).scrollTop() >= headerOffset && !$siteHeader.hasClass('fixed-header')) {
              toggleFixedHeaderDesktop(true);
            }
            else if ($(window).scrollTop() < headerOffset && $siteHeader.hasClass('fixed-header')) {
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
              $menu.find('.parent-item > .menu-dropdown, .parent-item > a').removeClass('open');

              // mouse in
              if ($(window).width() > 992) {
                clearTimeout(timer);
                openSubmenu($thisSubMenu);
              }

            }, function() {
              // mouseout
              if ($(window).width() > 992) {
                // timer = setTimeout(closeSubmenu($thisSubMenu), 1000);


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
      // Open
      if (active) {
        $mobileMenuOpen.addClass('mobile-menu-active');

        if (!$siteHeader.hasClass('fixed-header')) {
          $siteHeader.css('top', $siteHeader.offset().top - $(window).scrollTop());
        }

        $('body').addClass('mobile-open');
        $regionHeader.css('padding-top', $headerBar.outerHeight());
        $contentRegion.css('margin-top', $headerBar.outerHeight());
        resizeWindowCloseMobileMenu();
      }
      // Close
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
