'use strict';

(function($, Drupal) {

  // Example of Drupal behavior loaded.
  Drupal.behaviors.boatShowJs = {
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

      // Footer events.
      if ($('.footer .has-bg').length) {
        var bg = $('.has-bg').css("background-image");
        bg = bg.replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
        if ($('.footer .four-columns').length) {
          $('.footer .four-columns').css('background-image', 'url(' + bg + ')');
          $('.has-bg').removeAttr('style');
        }
      }

      $('.js-nmma-carousel:not(.hero)', context).once('sliderBehavior').each(function() {
        $(this).slick({
          dots: true,
          arrows: false,
          mobileFirst: true,
          infinite: true,
          slidesToScroll: 1,
          // autoplay: true,
          customPaging: function(i) {
            return "<span class='slider-pager'></span>";
          }
        });
      });

      // Newsletter events.
      if ($('#newsletter-optin').length) {
        var checkbox = $('#newsletter-optin');
        var button = $('.newsletter-form input.form-submit');

        if (checkbox.is(':checked')) {
          button.removeAttr('disabled');
        } else {
          button.attr('disabled', 'disabled');
        }

        checkbox.on('change', function() {
          if (checkbox.is(':checked')) {
            button.removeAttr('disabled');
          } else {
            button.attr('disabled', 'disabled');
          }
        });
      }

      // Features filter.
      $('.features-filter .filter').on('click', function() {
        var class_name = $.grep(this.className.split(" "), function(v, i){
          return v.indexOf('filter-') === 0;
        }).join();
        // var allFilters = $('.features-filter .filter');
        // var allCards = $('.features-grid .filter');
        // allFilters.removeClass('filter-selected');
        // $(this).addClass('filter-selected');
        // allCards.closest('.column-item').hide();
        // allCards.filter('.' + class_name).closest('.column-item').show();
        //
        // $(this).toggleClass('filter-selected');
        // allCards.closest('.column-item').hide();
        // allCards.filter('.' + class_name).closest('.column-item').show();

        var $this = $(this);
        var isSelected = $this.hasClass('filter-selected');
        var selectedFilters = $('.features-filter .filter-selected');
        var isFirstSelection = !selectedFilters.length;
        var allCards = $('.features-grid .filter');

        if (isSelected) {
          $this.removeClass('filter-selected');
          selectedFilters = $('.features-filter .filter-selected');
          // If all filters are now unchecked, show all results.
          if (!selectedFilters.length) {
            allCards.closest('.column-item').show();
          } else {
            allCards.filter('.' + class_name).closest('.column-item').hide();
          }
        } else {
          $this.addClass('filter-selected');
          if (isFirstSelection) {
            allCards.closest('.column-item').hide();
            allCards.filter('.' + class_name).closest('.column-item').show();
          } else {
            allCards.filter('.' + class_name).closest('.column-item').show();
          }
        }
      });

      $('.pencil-ad')
        .find('.field > div')
        .append('<div class="pencil-ad-close icon-db-close"></div>')
        .on('click', function() {
          $('.pencil-ad').hide();
        });
    }
  };
})(jQuery, Drupal);
