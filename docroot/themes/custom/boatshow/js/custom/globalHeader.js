'use strict';

(function($, Drupal) {

  Drupal.behaviors.boatshowGlobalHeader = {
    attach: function attach(context, settings) {
      // NOTE: Due to problems with the mobile-specific menu HTML, we've reverted
      // to using the desktop menu. We check the width of the window to determine
      // which event code to run.

      // Main nav triggers.
      var timer;
      $(".mega-menu .parent-item").on("mouseover", function() {
        if ($(window).width() > 992) {
          clearTimeout(timer);
          openSubmenu($(this).find('.menu-dropdown'));
        }
      }).on("mouseleave", function() {
        if ($(window).width() > 992) {
          // NOTE: This timer doesn't actually work, but it's also not hurting
          // anything, so I'm leaving it here for now.
          timer = setTimeout(closeSubmenu($(this).find('.menu-dropdown')), 1000);
        }
      });

      function openSubmenu($selector) {
        $selector.siblings('a').addClass('open');
        $selector.addClass("open");
      }

      function closeSubmenu($selector) {
        $selector.siblings('a').removeClass('open');
        $selector.removeClass("open");
      }

      $('.header .mobile-trigger').on('click', function(event) {
        event.preventDefault();
        var $this = $(this);
        var $menu = $('#block-mainnavigationboatshow .mega-menu');
        if ($this.hasClass('mobile-menu-active')) {
          $this.removeClass('mobile-menu-active');
          $menu.removeClass('mobile-open');
        } else {
          $this.addClass('mobile-menu-active');
          $menu.addClass('mobile-open');
        }
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
          } else {
            $submenu.addClass('open');
          }
        }
      });

    }
  };
})(jQuery, Drupal);
