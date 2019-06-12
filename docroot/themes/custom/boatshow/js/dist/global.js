'use strict';

(function ($, Drupal) {

  // Example of Drupal behavior loaded.
  Drupal.behaviors.boatShowJs = {
    attach: function attach(context, settings) {
      // NOTE: Due to problems with the mobile-specific menu HTML, we've reverted
      // to using the desktop menu. We check the width of the window to determine
      // which event code to run.

      // Main nav triggers.
      var timer;
      $(".mega-menu .parent-item").on("mouseover", function () {
        if ($(window).width() > 992) {
          clearTimeout(timer);
          openSubmenu($(this).find('.menu-dropdown'));
        }
      }).on("mouseleave", function () {
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

      $('.header .mobile-trigger').on('click', function (event) {
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

      $('#block-mainnavigationboatshow .mega-menu .parent-item > a').on('click', function (event) {
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

      $('.js-nmma-carousel:not(.hero)', context).once('sliderBehavior').each(function () {
        $(this).slick({
          dots: true,
          arrows: false,
          mobileFirst: true,
          infinite: true,
          slidesToScroll: 1,
          // autoplay: true,
          customPaging: function customPaging(i) {
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

        checkbox.on('change', function () {
          if (checkbox.is(':checked')) {
            button.removeAttr('disabled');
          } else {
            button.attr('disabled', 'disabled');
          }
        });
      }

      // Features filter.
      $('.features-filter .filter').on('click', function () {
        var class_name = $.grep(this.className.split(" "), function (v, i) {
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

      $('.pencil-ad').find('.field > div').append('<div class="pencil-ad-close icon-db-close"></div>').on('click', function () {
        $('.pencil-ad').hide();
      });
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImdsb2JhbC5qcyJdLCJuYW1lcyI6WyIkIiwiRHJ1cGFsIiwiYmVoYXZpb3JzIiwiYm9hdFNob3dKcyIsImF0dGFjaCIsImNvbnRleHQiLCJzZXR0aW5ncyIsInRpbWVyIiwib24iLCJ3aW5kb3ciLCJ3aWR0aCIsImNsZWFyVGltZW91dCIsIm9wZW5TdWJtZW51IiwiZmluZCIsInNldFRpbWVvdXQiLCJjbG9zZVN1Ym1lbnUiLCIkc2VsZWN0b3IiLCJzaWJsaW5ncyIsImFkZENsYXNzIiwicmVtb3ZlQ2xhc3MiLCJldmVudCIsInByZXZlbnREZWZhdWx0IiwiJHRoaXMiLCIkbWVudSIsImhhc0NsYXNzIiwiJHN1Ym1lbnUiLCJsZW5ndGgiLCJiZyIsImNzcyIsInJlcGxhY2UiLCJyZW1vdmVBdHRyIiwib25jZSIsImVhY2giLCJzbGljayIsImRvdHMiLCJhcnJvd3MiLCJtb2JpbGVGaXJzdCIsImluZmluaXRlIiwic2xpZGVzVG9TY3JvbGwiLCJjdXN0b21QYWdpbmciLCJpIiwiY2hlY2tib3giLCJidXR0b24iLCJpcyIsImF0dHIiLCJjbGFzc19uYW1lIiwiZ3JlcCIsImNsYXNzTmFtZSIsInNwbGl0IiwidiIsImluZGV4T2YiLCJqb2luIiwiaXNTZWxlY3RlZCIsInNlbGVjdGVkRmlsdGVycyIsImlzRmlyc3RTZWxlY3Rpb24iLCJhbGxDYXJkcyIsImNsb3Nlc3QiLCJzaG93IiwiZmlsdGVyIiwiaGlkZSIsImFwcGVuZCIsImpRdWVyeSJdLCJtYXBwaW5ncyI6IkFBQUE7O0FBRUEsQ0FBQyxVQUFTQSxDQUFULEVBQVlDLE1BQVosRUFBb0I7O0FBRW5CO0FBQ0FBLFNBQU9DLFNBQVAsQ0FBaUJDLFVBQWpCLEdBQThCO0FBQzVCQyxZQUFRLFNBQVNBLE1BQVQsQ0FBZ0JDLE9BQWhCLEVBQXlCQyxRQUF6QixFQUFtQztBQUN6QztBQUNBO0FBQ0E7O0FBRUE7QUFDQSxVQUFJQyxLQUFKO0FBQ0FQLFFBQUUseUJBQUYsRUFBNkJRLEVBQTdCLENBQWdDLFdBQWhD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UixVQUFFLFlBQUYsRUFBZ0IyRCxJQUFoQjtBQUNELE9BTEg7QUFNRDtBQTFKMkIsR0FBOUI7QUE0SkQsQ0EvSkQsRUErSkdFLE1BL0pILEVBK0pXNUQsTUEvSlgiLCJmaWxlIjoiZ2xvYmFsLmpzIiwic291cmNlc0NvbnRlbnQiOlsiJ3VzZSBzdHJpY3QnO1xuXG4oZnVuY3Rpb24oJCwgRHJ1cGFsKSB7XG5cbiAgLy8gRXhhbXBsZSBvZiBEcnVwYWwgYmVoYXZpb3IgbG9hZGVkLlxuICBEcnVwYWwuYmVoYXZpb3JzLmJvYXRTaG93SnMgPSB7XG4gICAgYXR0YWNoOiBmdW5jdGlvbiBhdHRhY2goY29udGV4dCwgc2V0dGluZ3MpIHtcbiAgICAgIC8vIE5PVEU6IER1ZSB0byBwcm9ibGVtcyB3aXRoIHRoZSBtb2JpbGUtc3BlY2lmaWMgbWVudSBIVE1MLCB3ZSd2ZSByZXZlcnRlZFxuICAgICAgLy8gdG8gdXNpbmcgdGhlIGRlc2t0b3AgbWVudS4gV2UgY2hlY2sgdGhlIHdpZHRoIG9mIHRoZSB3aW5kb3cgdG8gZGV0ZXJtaW5lXG4gICAgICAvLyB3aGljaCBldmVudCBjb2RlIHRvIHJ1bi5cblxuICAgICAgLy8gTWFpbiBuYXYgdHJpZ2dlcnMuXG4gICAgICB2YXIgdGltZXI7XG4gICAgICAkKFwiLm1lZ2EtbWVudSAucGFyZW50LWl0ZW1cIikub24oXCJtb3VzZW92ZXJcIiwgZnVuY3Rpb24oKSB7XG4gICAgICAgIGlmICgkKHdpbmRvdykud2lkdGgoKSA+IDk5Mikge1xuICAgICAgICAgIGNsZWFyVGltZW91dCh0aW1lcik7XG4gICAgICAgICAgb3BlblN1Ym1lbnUoJCh0aGlzKS5maW5kKCcubWVudS1kcm9wZG93bicpKTtcbiAgICAgICAgfVxuICAgICAgfSkub24oXCJtb3VzZWxlYXZlXCIsIGZ1bmN0aW9uKCkge1xuICAgICAgICBpZiAoJCh3aW5kb3cpLndpZHRoKCkgPiA5OTIpIHtcbiAgICAgICAgICAvLyBOT1RFOiBUaGlzIHRpbWVyIGRvZXNuJ3QgYWN0dWFsbHkgd29yaywgYnV0IGl0J3MgYWxzbyBub3QgaHVydGluZ1xuICAgICAgICAgIC8vIGFueXRoaW5nLCBzbyBJJ20gbGVhdmluZyBpdCBoZXJlIGZvciBub3cuXG4gICAgICAgICAgdGltZXIgPSBzZXRUaW1lb3V0KGNsb3NlU3VibWVudSgkKHRoaXMpLmZpbmQoJy5tZW51LWRyb3Bkb3duJykpLCAxMDAwKTtcbiAgICAgICAgfVxuICAgICAgfSk7XG5cbiAgICAgIGZ1bmN0aW9uIG9wZW5TdWJtZW51KCRzZWxlY3Rvcikge1xuICAgICAgICAkc2VsZWN0b3Iuc2libGluZ3MoJ2EnKS5hZGRDbGFzcygnb3BlbicpO1xuICAgICAgICAkc2VsZWN0b3IuYWRkQ2xhc3MoXCJvcGVuXCIpO1xuICAgICAgfVxuXG4gICAgICBmdW5jdGlvbiBjbG9zZVN1Ym1lbnUoJHNlbGVjdG9yKSB7XG4gICAgICAgICRzZWxlY3Rvci5zaWJsaW5ncygnYScpLnJlbW92ZUNsYXNzKCdvcGVuJyk7XG4gICAgICAgICRzZWxlY3Rvci5yZW1vdmVDbGFzcyhcIm9wZW5cIik7XG4gICAgICB9XG5cbiAgICAgICQoJy5oZWFkZXIgLm1vYmlsZS10cmlnZ2VyJykub24oJ2NsaWNrJywgZnVuY3Rpb24oZXZlbnQpIHtcbiAgICAgICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcbiAgICAgICAgdmFyICRtZW51ID0gJCgnI2Jsb2NrLW1haW5uYXZpZ2F0aW9uYm9hdHNob3cgLm1lZ2EtbWVudScpO1xuICAgICAgICBpZiAoJHRoaXMuaGFzQ2xhc3MoJ21vYmlsZS1tZW51LWFjdGl2ZScpKSB7XG4gICAgICAgICAgJHRoaXMucmVtb3ZlQ2xhc3MoJ21vYmlsZS1tZW51LWFjdGl2ZScpO1xuICAgICAgICAgICRtZW51LnJlbW92ZUNsYXNzKCdtb2JpbGUtb3BlbicpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICR0aGlzLmFkZENsYXNzKCdtb2JpbGUtbWVudS1hY3RpdmUnKTtcbiAgICAgICAgICAkbWVudS5hZGRDbGFzcygnbW9iaWxlLW9wZW4nKTtcbiAgICAgICAgfVxuICAgICAgfSk7XG5cbiAgICAgICQoJyNibG9jay1tYWlubmF2aWdhdGlvbmJvYXRzaG93IC5tZWdhLW1lbnUgLnBhcmVudC1pdGVtID4gYScpLm9uKCdjbGljaycsIGZ1bmN0aW9uKGV2ZW50KSB7XG4gICAgICAgIC8vIFNvbWV0aW1lcyBsaW5rcyBhcmUgbGlua3MgYW5kIHNvbWV0aW1lcyB0aGV5J3JlIG1lbnUgaGVhZGVycywgYW5kXG4gICAgICAgIC8vIHRoZXJlJ3Mgbm8gd2F5IHRvIHRlbGwgdGhlbSBhcGFydCEgQXMgYSB3b3JrYXJvdW5kLCBkaXNhYmxlIHByZXZlbnREZWZhdWx0XG4gICAgICAgIC8vIHdoZW5cbiAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcbiAgICAgICAgdmFyICRzdWJtZW51ID0gJHRoaXMuc2libGluZ3MoJy5tZW51LWRyb3Bkb3duJyk7XG4gICAgICAgIGlmICgkc3VibWVudS5sZW5ndGgpIHtcbiAgICAgICAgICBldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB9XG4gICAgICAgIGlmICgkKHdpbmRvdykud2lkdGgoKSA8PSA5OTIpIHtcbiAgICAgICAgICBpZiAoJHN1Ym1lbnUuaGFzQ2xhc3MoJ29wZW4nKSkge1xuICAgICAgICAgICAgJHN1Ym1lbnUucmVtb3ZlQ2xhc3MoJ29wZW4nKTtcbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJHN1Ym1lbnUuYWRkQ2xhc3MoJ29wZW4nKTtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0pO1xuXG4gICAgICAvLyBGb290ZXIgZXZlbnRzLlxuICAgICAgaWYgKCQoJy5mb290ZXIgLmhhcy1iZycpLmxlbmd0aCkge1xuICAgICAgICB2YXIgYmcgPSAkKCcuaGFzLWJnJykuY3NzKFwiYmFja2dyb3VuZC1pbWFnZVwiKTtcbiAgICAgICAgYmcgPSBiZy5yZXBsYWNlKC8uKlxccz91cmxcXChbXFwnXFxcIl0/LywgJycpLnJlcGxhY2UoL1tcXCdcXFwiXT9cXCkuKi8sICcnKTtcbiAgICAgICAgaWYgKCQoJy5mb290ZXIgLmZvdXItY29sdW1ucycpLmxlbmd0aCkge1xuICAgICAgICAgICQoJy5mb290ZXIgLmZvdXItY29sdW1ucycpLmNzcygnYmFja2dyb3VuZC1pbWFnZScsICd1cmwoJyArIGJnICsgJyknKTtcbiAgICAgICAgICAkKCcuaGFzLWJnJykucmVtb3ZlQXR0cignc3R5bGUnKTtcbiAgICAgICAgfVxuICAgICAgfVxuXG4gICAgICAkKCcuanMtbm1tYS1jYXJvdXNlbDpub3QoLmhlcm8pJywgY29udGV4dCkub25jZSgnc2xpZGVyQmVoYXZpb3InKS5lYWNoKGZ1bmN0aW9uKCkge1xuICAgICAgICAkKHRoaXMpLnNsaWNrKHtcbiAgICAgICAgICBkb3RzOiB0cnVlLFxuICAgICAgICAgIGFycm93czogZmFsc2UsXG4gICAgICAgICAgbW9iaWxlRmlyc3Q6IHRydWUsXG4gICAgICAgICAgaW5maW5pdGU6IHRydWUsXG4gICAgICAgICAgc2xpZGVzVG9TY3JvbGw6IDEsXG4gICAgICAgICAgLy8gYXV0b3BsYXk6IHRydWUsXG4gICAgICAgICAgY3VzdG9tUGFnaW5nOiBmdW5jdGlvbihpKSB7XG4gICAgICAgICAgICByZXR1cm4gXCI8c3BhbiBjbGFzcz0nc2xpZGVyLXBhZ2VyJz48L3NwYW4+XCI7XG4gICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICAgIH0pO1xuXG4gICAgICAvLyBOZXdzbGV0dGVyIGV2ZW50cy5cbiAgICAgIGlmICgkKCcjbmV3c2xldHRlci1vcHRpbicpLmxlbmd0aCkge1xuICAgICAgICB2YXIgY2hlY2tib3ggPSAkKCcjbmV3c2xldHRlci1vcHRpbicpO1xuICAgICAgICB2YXIgYnV0dG9uID0gJCgnLm5ld3NsZXR0ZXItZm9ybSBpbnB1dC5mb3JtLXN1Ym1pdCcpO1xuXG4gICAgICAgIGlmIChjaGVja2JveC5pcygnOmNoZWNrZWQnKSkge1xuICAgICAgICAgIGJ1dHRvbi5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgIGJ1dHRvbi5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpO1xuICAgICAgICB9XG5cbiAgICAgICAgY2hlY2tib3gub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgIGlmIChjaGVja2JveC5pcygnOmNoZWNrZWQnKSkge1xuICAgICAgICAgICAgYnV0dG9uLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJyk7XG4gICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIGJ1dHRvbi5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpO1xuICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICB9XG5cbiAgICAgIC8vIEZlYXR1cmVzIGZpbHRlci5cbiAgICAgICQoJy5mZWF0dXJlcy1maWx0ZXIgLmZpbHRlcicpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICB2YXIgY2xhc3NfbmFtZSA9ICQuZ3JlcCh0aGlzLmNsYXNzTmFtZS5zcGxpdChcIiBcIiksIGZ1bmN0aW9uKHYsIGkpe1xuICAgICAgICAgIHJldHVybiB2LmluZGV4T2YoJ2ZpbHRlci0nKSA9PT0gMDtcbiAgICAgICAgfSkuam9pbigpO1xuICAgICAgICAvLyB2YXIgYWxsRmlsdGVycyA9ICQoJy5mZWF0dXJlcy1maWx0ZXIgLmZpbHRlcicpO1xuICAgICAgICAvLyB2YXIgYWxsQ2FyZHMgPSAkKCcuZmVhdHVyZXMtZ3JpZCAuZmlsdGVyJyk7XG4gICAgICAgIC8vIGFsbEZpbHRlcnMucmVtb3ZlQ2xhc3MoJ2ZpbHRlci1zZWxlY3RlZCcpO1xuICAgICAgICAvLyAkKHRoaXMpLmFkZENsYXNzKCdmaWx0ZXItc2VsZWN0ZWQnKTtcbiAgICAgICAgLy8gYWxsQ2FyZHMuY2xvc2VzdCgnLmNvbHVtbi1pdGVtJykuaGlkZSgpO1xuICAgICAgICAvLyBhbGxDYXJkcy5maWx0ZXIoJy4nICsgY2xhc3NfbmFtZSkuY2xvc2VzdCgnLmNvbHVtbi1pdGVtJykuc2hvdygpO1xuICAgICAgICAvL1xuICAgICAgICAvLyAkKHRoaXMpLnRvZ2dsZUNsYXNzKCdmaWx0ZXItc2VsZWN0ZWQnKTtcbiAgICAgICAgLy8gYWxsQ2FyZHMuY2xvc2VzdCgnLmNvbHVtbi1pdGVtJykuaGlkZSgpO1xuICAgICAgICAvLyBhbGxDYXJkcy5maWx0ZXIoJy4nICsgY2xhc3NfbmFtZSkuY2xvc2VzdCgnLmNvbHVtbi1pdGVtJykuc2hvdygpO1xuXG4gICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XG4gICAgICAgIHZhciBpc1NlbGVjdGVkID0gJHRoaXMuaGFzQ2xhc3MoJ2ZpbHRlci1zZWxlY3RlZCcpO1xuICAgICAgICB2YXIgc2VsZWN0ZWRGaWx0ZXJzID0gJCgnLmZlYXR1cmVzLWZpbHRlciAuZmlsdGVyLXNlbGVjdGVkJyk7XG4gICAgICAgIHZhciBpc0ZpcnN0U2VsZWN0aW9uID0gIXNlbGVjdGVkRmlsdGVycy5sZW5ndGg7XG4gICAgICAgIHZhciBhbGxDYXJkcyA9ICQoJy5mZWF0dXJlcy1ncmlkIC5maWx0ZXInKTtcblxuICAgICAgICBpZiAoaXNTZWxlY3RlZCkge1xuICAgICAgICAgICR0aGlzLnJlbW92ZUNsYXNzKCdmaWx0ZXItc2VsZWN0ZWQnKTtcbiAgICAgICAgICBzZWxlY3RlZEZpbHRlcnMgPSAkKCcuZmVhdHVyZXMtZmlsdGVyIC5maWx0ZXItc2VsZWN0ZWQnKTtcbiAgICAgICAgICAvLyBJZiBhbGwgZmlsdGVycyBhcmUgbm93IHVuY2hlY2tlZCwgc2hvdyBhbGwgcmVzdWx0cy5cbiAgICAgICAgICBpZiAoIXNlbGVjdGVkRmlsdGVycy5sZW5ndGgpIHtcbiAgICAgICAgICAgIGFsbENhcmRzLmNsb3Nlc3QoJy5jb2x1bW4taXRlbScpLnNob3coKTtcbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgYWxsQ2FyZHMuZmlsdGVyKCcuJyArIGNsYXNzX25hbWUpLmNsb3Nlc3QoJy5jb2x1bW4taXRlbScpLmhpZGUoKTtcbiAgICAgICAgICB9XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgJHRoaXMuYWRkQ2xhc3MoJ2ZpbHRlci1zZWxlY3RlZCcpO1xuICAgICAgICAgIGlmIChpc0ZpcnN0U2VsZWN0aW9uKSB7XG4gICAgICAgICAgICBhbGxDYXJkcy5jbG9zZXN0KCcuY29sdW1uLWl0ZW0nKS5oaWRlKCk7XG4gICAgICAgICAgICBhbGxDYXJkcy5maWx0ZXIoJy4nICsgY2xhc3NfbmFtZSkuY2xvc2VzdCgnLmNvbHVtbi1pdGVtJykuc2hvdygpO1xuICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBhbGxDYXJkcy5maWx0ZXIoJy4nICsgY2xhc3NfbmFtZSkuY2xvc2VzdCgnLmNvbHVtbi1pdGVtJykuc2hvdygpO1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfSk7XG5cbiAgICAgICQoJy5wZW5jaWwtYWQnKVxuICAgICAgICAuZmluZCgnLmZpZWxkID4gZGl2JylcbiAgICAgICAgLmFwcGVuZCgnPGRpdiBjbGFzcz1cInBlbmNpbC1hZC1jbG9zZSBpY29uLWRiLWNsb3NlXCI+PC9kaXY+JylcbiAgICAgICAgLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICQoJy5wZW5jaWwtYWQnKS5oaWRlKCk7XG4gICAgICAgIH0pO1xuICAgIH1cbiAgfTtcbn0pKGpRdWVyeSwgRHJ1cGFsKTtcbiJdfQ==
