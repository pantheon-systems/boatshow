'use strict';

(function ($, Drupal) {
  function toggleMobileMenu(override) {
    $('header.header').toggleClass('mobile-menu-active', override);
    $('.mobile-nav').toggle(override);
  }

  function toggleSearchBar(override) {
    $('header.header').toggleClass('search-active', override);
  }

  function checkWindow() {
    if (window.matchMedia('(min-width: 768px)').matches) {
      toggleMobileMenu(false);
    }
  }

  Drupal.behaviors.header = {
    attach: function attach(context, settings) {
      $('.mobile-trigger').once().click(function (event) {
        event.preventDefault();

        toggleSearchBar(false);
        toggleMobileMenu();
      });

      $('.search-trigger').once().click(function (event) {
        event.preventDefault();

        toggleMobileMenu(false);
        toggleSearchBar();

        if ($('.search-bar input').is(':visible')) {
          $('.search-bar input').focus();
        }
      });

      $(window).on('resize', checkWindow);
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIjQtb3JnYW5pc21zL2hlYWRlci5qcyJdLCJuYW1lcyI6WyIkIiwiRHJ1cGFsIiwidG9nZ2xlTW9iaWxlTWVudSIsIm92ZXJyaWRlIiwidG9nZ2xlQ2xhc3MiLCJ0b2dnbGUiLCJ0b2dnbGVTZWFyY2hCYXIiLCJjaGVja1dpbmRvdyIsIndpbmRvdyIsIm1hdGNoTWVkaWEiLCJtYXRjaGVzIiwiYmVoYXZpb3JzIiwiaGVhZGVyIiwiYXR0YWNoIiwiY29udGV4dCIsInNldHRpbmdzIiwib25jZSIsImNsaWNrIiwiZXZlbnQiLCJwcmV2ZW50RGVmYXVsdCIsImlzIiwiZm9jdXMiLCJvbiIsImpRdWVyeSJdLCJtYXBwaW5ncyI6Ijs7QUFBQSxDQUFDLFVBQVNBLENBQVQsRUFBWUMsTUFBWixFQUFvQjtBQUNuQixXQUFTQyxnQkFBVCxDQUEwQkMsUUFBMUIsRUFBb0M7QUFDbENILE1BQUUsZUFBRixFQUFtQkksV0FBbkIsQ0FBK0Isb0JBQS9CLEVBQXFERCxRQUFyRDtBQUNBSCxNQUFFLGFBQUYsRUFBaUJLLE1BQWpCLENBQXdCRixRQUF4QjtBQUNEOztBQUVELFdBQVNHLGVBQVQsQ0FBeUJILFFBQXpCLEVBQW1DO0FBQ2pDSCxNQUFFLGVBQUYsRUFBbUJJLFdBQW5CLENBQStCLGVBQS9CLEVBQWdERCxRQUFoRDtBQUNEOztBQUVELFdBQVNJLFdBQVQsR0FBdUI7QUFDckIsUUFBSUMsT0FBT0MsVUFBUCxDQUFrQixvQkFBbEIsRUFBd0NDLE9BQTVDLEVBQXFEO0FBQ25EUix1QkFBaUIsS0FBakI7QUFDRDtBQUNGOztBQUVERCxTQUFPVSxTQUFQLENBQWlCQyxNQUFqQixHQUEwQjtBQUN4QkMsWUFBUSxTQUFTQSxNQUFULENBQWdCQyxPQUFoQixFQUF5QkMsUUFBekIsRUFBbUM7QUFDekNmLFFBQUUsaUJBQUYsRUFBcUJnQixJQUFyQixHQUE0QkMsS0FBNUIsQ0FBa0MsVUFBQ0MsS0FBRCxFQUFXO0FBQzNDQSxjQUFNQyxjQUFOOztBQUVBYix3QkFBZ0IsS0FBaEI7QUFDQUo7QUFDRCxPQUxEOztBQU9BRixRQUFFLGlCQUFGLEVBQXFCZ0IsSUFBckIsR0FBNEJDLEtBQTVCLENBQWtDLFVBQUNDLEtBQUQsRUFBVztBQUMzQ0EsY0FBTUMsY0FBTjs7QUFFQWpCLHlCQUFpQixLQUFqQjtBQUNBSTs7QUFFQSxZQUFJTixFQUFFLG1CQUFGLEVBQXVCb0IsRUFBdkIsQ0FBMEIsVUFBMUIsQ0FBSixFQUEyQztBQUN6Q3BCLFlBQUUsbUJBQUYsRUFBdUJxQixLQUF2QjtBQUNEO0FBQ0YsT0FURDs7QUFXQXJCLFFBQUVRLE1BQUYsRUFBVWMsRUFBVixDQUFhLFFBQWIsRUFBdUJmLFdBQXZCO0FBQ0Q7QUFyQnVCLEdBQTFCO0FBdUJELENBdkNELEVBdUNHZ0IsTUF2Q0gsRUF1Q1d0QixNQXZDWCIsImZpbGUiOiI0LW9yZ2FuaXNtcy9oZWFkZXIuanMiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24oJCwgRHJ1cGFsKSB7XG4gIGZ1bmN0aW9uIHRvZ2dsZU1vYmlsZU1lbnUob3ZlcnJpZGUpIHtcbiAgICAkKCdoZWFkZXIuaGVhZGVyJykudG9nZ2xlQ2xhc3MoJ21vYmlsZS1tZW51LWFjdGl2ZScsIG92ZXJyaWRlKTtcbiAgICAkKCcubW9iaWxlLW5hdicpLnRvZ2dsZShvdmVycmlkZSk7XG4gIH1cblxuICBmdW5jdGlvbiB0b2dnbGVTZWFyY2hCYXIob3ZlcnJpZGUpIHtcbiAgICAkKCdoZWFkZXIuaGVhZGVyJykudG9nZ2xlQ2xhc3MoJ3NlYXJjaC1hY3RpdmUnLCBvdmVycmlkZSk7XG4gIH1cblxuICBmdW5jdGlvbiBjaGVja1dpbmRvdygpIHtcbiAgICBpZiAod2luZG93Lm1hdGNoTWVkaWEoJyhtaW4td2lkdGg6IDc2OHB4KScpLm1hdGNoZXMpIHtcbiAgICAgIHRvZ2dsZU1vYmlsZU1lbnUoZmFsc2UpO1xuICAgIH1cbiAgfVxuXG4gIERydXBhbC5iZWhhdmlvcnMuaGVhZGVyID0ge1xuICAgIGF0dGFjaDogZnVuY3Rpb24gYXR0YWNoKGNvbnRleHQsIHNldHRpbmdzKSB7XG4gICAgICAkKCcubW9iaWxlLXRyaWdnZXInKS5vbmNlKCkuY2xpY2soKGV2ZW50KSA9PiB7XG4gICAgICAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgdG9nZ2xlU2VhcmNoQmFyKGZhbHNlKTtcbiAgICAgICAgdG9nZ2xlTW9iaWxlTWVudSgpO1xuICAgICAgfSk7XG5cbiAgICAgICQoJy5zZWFyY2gtdHJpZ2dlcicpLm9uY2UoKS5jbGljaygoZXZlbnQpID0+IHtcbiAgICAgICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcblxuICAgICAgICB0b2dnbGVNb2JpbGVNZW51KGZhbHNlKTtcbiAgICAgICAgdG9nZ2xlU2VhcmNoQmFyKCk7XG5cbiAgICAgICAgaWYgKCQoJy5zZWFyY2gtYmFyIGlucHV0JykuaXMoJzp2aXNpYmxlJykpIHtcbiAgICAgICAgICAkKCcuc2VhcmNoLWJhciBpbnB1dCcpLmZvY3VzKCk7XG4gICAgICAgIH1cbiAgICAgIH0pO1xuXG4gICAgICAkKHdpbmRvdykub24oJ3Jlc2l6ZScsIGNoZWNrV2luZG93KTtcbiAgICB9XG4gIH1cbn0pKGpRdWVyeSwgRHJ1cGFsKTsiXX0=
