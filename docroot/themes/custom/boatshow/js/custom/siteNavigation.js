window.BoatShows = window.BoatShows || {};

(function($, Drupal, BoatShows) {
  'use strict';

  Drupal.behaviors.boatshowSiteNavigation = {
    attach: function(context, settings) {

      $(context).find('header.header').once('boatshow-nav').each(function() {
        var $header = $(this);
        var $menu = $header.find('.mega-menu');
        var $mobileMenuOpen = $header.find('.mobile-trigger');
        var $mobileMenuCloseBtn = $header.find('.mobile-menu-close');

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
              closeSubmenu($thisSubMenu);
            }
          });
        });

        $mobileMenuOpen.click(function(event) {
          event.preventDefault();
          $menu.addClass('mobile-open');
          $('body').addClass('mobile-open');
        });

        $mobileMenuCloseBtn.click(function() {
          $menu.removeClass('mobile-open');
          $('body').removeClass('mobile-open');
          if (BoatShows.hasOwnProperty('Header')) {
            BoatShows.Header.resetContentPadding();
          }
        });
      });

      // function getScrollbarWidth() {

      //   // Creating invisible container
      //   const outer = document.createElement('div');
      //   outer.style.visibility = 'hidden';
      //   outer.style.overflow = 'scroll'; // forcing scrollbar to appear
      //   outer.style.msOverflowStyle = 'scrollbar'; // needed for WinJS apps
      //   document.body.appendChild(outer);

      //   // Creating inner element and placing it in the container
      //   const inner = document.createElement('div');
      //   outer.appendChild(inner);

      //   // Calculating difference between container's full width and the child width
      //   const scrollbarWidth = (outer.offsetWidth - inner.offsetWidth);

      //   // Removing temporary elements from the DOM
      //   outer.parentNode.removeChild(outer);

      //   return scrollbarWidth;

      // }

      function openSubmenu($selector) {
        $selector.siblings('a').addClass('open');
        $selector.addClass('open');
      }

      function closeSubmenu($selector) {
        $selector.siblings('a').removeClass('open');
        $selector.removeClass('open');
      }

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
})(jQuery, Drupal, BoatShows);
