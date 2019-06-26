'use strict';

(function ($, Drupal) {
  Drupal.behaviors.hero = {
    attach: function attach(context, settings) {
      $('.hero', context).once('heroBehavior').each(function () {
        var hero = this;
        $(hero).slick({
          dots: $('.slide', hero).length > 1 ? true : false,
          arrows: true,
          autoplay: true,
          autoplaySpeed: 3000,
          customPaging: function customPaging(i) {
            return "<span class='slider-pager'></span>";
          }
        });
      }).slick("pause");

      setTimeout(function () {
        $(".hero").slick("play");
      }, 5000);

      $('.js-nmma-carousel:not(.hero)', context).once('sliderBehavior').each(function () {
        $(this).slick({
          dots: true,
          arrows: true,
          infinite: true,
          slidesToScroll: 1,
          centerMode: true,
          // autoplay: true,
          customPaging: function customPaging(i) {
            return "<span class='slider-pager'></span>";
          }
        });
      });
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIjQtb3JnYW5pc21zL25tbWEtc2xpY2suanMiXSwibmFtZXMiOlsiJCIsIkRydXBhbCIsImJlaGF2aW9ycyIsImhlcm8iLCJhdHRhY2giLCJjb250ZXh0Iiwic2V0dGluZ3MiLCJvbmNlIiwiZWFjaCIsInNsaWNrIiwiZG90cyIsImxlbmd0aCIsImFycm93cyIsImF1dG9wbGF5IiwiYXV0b3BsYXlTcGVlZCIsImN1c3RvbVBhZ2luZyIsImkiLCJzZXRUaW1lb3V0IiwiaW5maW5pdGUiLCJzbGlkZXNUb1Njcm9sbCIsImNlbnRlck1vZGUiLCJqUXVlcnkiXSwibWFwcGluZ3MiOiI7O0FBQUEsQ0FBQyxVQUFVQSxDQUFWLEVBQWFDLE1BQWIsRUFBcUI7QUFDcEJBLFNBQU9DLFNBQVAsQ0FBaUJDLElBQWpCLEdBQXdCO0FBQ3RCQyxZQUFRLFNBQVNBLE1BQVQsQ0FBZ0JDLE9BQWhCLEVBQXlCQyxRQUF6QixFQUFtQztBQUN6Q04sUUFBRSxPQUFGLEVBQVdLLE9BQVgsRUFBb0JFLElBQXBCLENBQXlCLGNBQXpCLEVBQXlDQyxJQUF6QyxDQUE4QyxZQUFVO0FBQ3RELFlBQUlMLE9BQU8sSUFBWDtBQUNBSCxVQUFFRyxJQUFGLEVBQVFNLEtBQVIsQ0FBYztBQUNWQyxnQkFBTVYsRUFBRSxRQUFGLEVBQVlHLElBQVosRUFBa0JRLE1BQWxCLEdBQTJCLENBQTNCLEdBQStCLElBQS9CLEdBQXNDLEtBRGxDO0FBRVZDLGtCQUFRLElBRkU7QUFHVkMsb0JBQVUsSUFIQTtBQUlWQyx5QkFBZSxJQUpMO0FBS1ZDLHdCQUFjLHNCQUFVQyxDQUFWLEVBQWE7QUFDekIsbUJBQU8sb0NBQVA7QUFDRDtBQVBTLFNBQWQ7QUFTRCxPQVhELEVBV0dQLEtBWEgsQ0FXUyxPQVhUOztBQWFBUSxpQkFBVyxZQUFXO0FBQUVqQixVQUFFLE9BQUYsRUFBV1MsS0FBWCxDQUFpQixNQUFqQjtBQUEyQixPQUFuRCxFQUFxRCxJQUFyRDs7QUFFRFQsUUFBRSw4QkFBRixFQUFrQ0ssT0FBbEMsRUFBMkNFLElBQTNDLENBQWdELGdCQUFoRCxFQUFrRUMsSUFBbEUsQ0FBdUUsWUFBWTtBQUNoRlIsVUFBRSxJQUFGLEVBQVFTLEtBQVIsQ0FBYztBQUNkQyxnQkFBTSxJQURRO0FBRWRFLGtCQUFRLElBRk07QUFHZE0sb0JBQVUsSUFISTtBQUlkQywwQkFBZ0IsQ0FKRjtBQUtaQyxzQkFBWSxJQUxBO0FBTWQ7QUFDQUwsd0JBQWMsc0JBQVVDLENBQVYsRUFBYTtBQUMxQixtQkFBTyxvQ0FBUDtBQUNBO0FBVGEsU0FBZDtBQVdGLE9BWkQ7QUFhQTtBQTlCcUIsR0FBeEI7QUFnQ0QsQ0FqQ0QsRUFpQ0dLLE1BakNILEVBaUNXcEIsTUFqQ1giLCJmaWxlIjoiNC1vcmdhbmlzbXMvbm1tYS1zbGljay5qcyIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiAoJCwgRHJ1cGFsKSB7XG4gIERydXBhbC5iZWhhdmlvcnMuaGVybyA9IHtcbiAgICBhdHRhY2g6IGZ1bmN0aW9uIGF0dGFjaChjb250ZXh0LCBzZXR0aW5ncykge1xuICAgICAgJCgnLmhlcm8nLCBjb250ZXh0KS5vbmNlKCdoZXJvQmVoYXZpb3InKS5lYWNoKGZ1bmN0aW9uKCl7XG4gICAgICAgIHZhciBoZXJvID0gdGhpcztcbiAgICAgICAgJChoZXJvKS5zbGljayh7XG4gICAgICAgICAgICBkb3RzOiAkKCcuc2xpZGUnLCBoZXJvKS5sZW5ndGggPiAxID8gdHJ1ZSA6IGZhbHNlLFxuICAgICAgICAgICAgYXJyb3dzOiB0cnVlLFxuICAgICAgICAgICAgYXV0b3BsYXk6IHRydWUsXG4gICAgICAgICAgICBhdXRvcGxheVNwZWVkOiAzMDAwLFxuICAgICAgICAgICAgY3VzdG9tUGFnaW5nOiBmdW5jdGlvbiAoaSkge1xuICAgICAgICAgICAgICByZXR1cm4gXCI8c3BhbiBjbGFzcz0nc2xpZGVyLXBhZ2VyJz48L3NwYW4+XCI7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgICAgfSkuc2xpY2soXCJwYXVzZVwiKTtcblxuICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpIHsgJChcIi5oZXJvXCIpLnNsaWNrKFwicGxheVwiKTsgfSwgNTAwMCk7XG5cblx0ICAgICQoJy5qcy1ubW1hLWNhcm91c2VsOm5vdCguaGVybyknLCBjb250ZXh0KS5vbmNlKCdzbGlkZXJCZWhhdmlvcicpLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAkKHRoaXMpLnNsaWNrKHtcbiAgXHRcdCAgICBkb3RzOiB0cnVlLFxuICBcdFx0ICAgIGFycm93czogdHJ1ZSxcbiAgXHRcdCAgICBpbmZpbml0ZTogdHJ1ZSxcbiAgXHRcdCAgICBzbGlkZXNUb1Njcm9sbDogMSxcbiAgICAgICAgICBjZW50ZXJNb2RlOiB0cnVlLFxuICBcdFx0ICAgIC8vIGF1dG9wbGF5OiB0cnVlLFxuICBcdFx0ICAgIGN1c3RvbVBhZ2luZzogZnVuY3Rpb24gKGkpIHtcbiAgXHRcdFx0ICAgIHJldHVybiBcIjxzcGFuIGNsYXNzPSdzbGlkZXItcGFnZXInPjwvc3Bhbj5cIjtcbiAgXHRcdCAgICB9XG4gICAgICAgIH0pO1xuXHQgICAgfSk7XG4gICAgfVxuICB9XG59KShqUXVlcnksIERydXBhbCk7XG4iXX0=
