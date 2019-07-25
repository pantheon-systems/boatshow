(function($, Drupal) {
  'use strict';

  Drupal.behaviors.boatshowSiteNavigation = {
    attach: function(context, settings) {

      $(context).find('header.header').once('boatshow-nav').each(function() {
        var $header = $(this);
        var $menu = $header.find('.mega-menu');
        var $mobileMenuTrigger = $header.find('.mobile-trigger');

        $menu.find('.parent-item').each(function() {
          var $thisMenuItem = $(this);
          var $thisSubMenu = $thisMenuItem.find('.menu-dropdown');

          // Main nav triggers.
          // var timer;
          if ($(window).width() > 992) {
            $thisMenuItem.hover(function() {
              // mouse in
              // clearTimeout(timer);
              openSubmenu($thisSubMenu);
            }, function() {
              // mouseout
              // NOTE: This timer doesn't actually work, but it's also not hurting
              // anything, so I'm leaving it here for now.
              // timer = setTimeout(closeSubmenu($(this).find('.menu-dropdown')), 1000);
              closeSubmenu($thisSubMenu);
            });
          }
        });

        $mobileMenuTrigger.click(function(event) {
          event.preventDefault();

          var $thisBtn = $(this);
          // var $menu = $('#block-mainnavigationboatshow .mega-menu');

          if ($thisBtn.hasClass('mobile-menu-active')) {
            $thisBtn.removeClass('mobile-menu-active');
            $menu.removeClass('mobile-open');
          }
          else {
            $thisBtn.addClass('mobile-menu-active');
            $menu.addClass('mobile-open');
          }
        });
      });

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
})(jQuery, Drupal);
