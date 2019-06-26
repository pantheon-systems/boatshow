"use strict";

(function ($, Drupal) {
  Drupal.behaviors.socialShare = {
    attach: function attach(context, settings) {
      var maxTries = 10;
      var tryIndex = 0;
      var trying;

      if ($(".article-share").length) {
        trying = setInterval(function () {
          if (typeof FB !== "undefined") {
            $(".article-share .facebook").on("click", function (e) {
              e.preventDefault();

              FB.ui({
                method: 'share',
                mobile_iframe: true,
                href: window.location.href
              }, function (response) {});
            });

            clearInterval(trying);
          } else {
            if (++tryIndex >= maxTries) {
              clearInterval(trying);
              return;
            }
          }
        }, 500);
      }
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIjMtbW9sZWN1bGVzL3NvY2lhbC1zaGFyZS5qcyJdLCJuYW1lcyI6WyIkIiwiRHJ1cGFsIiwiYmVoYXZpb3JzIiwic29jaWFsU2hhcmUiLCJhdHRhY2giLCJjb250ZXh0Iiwic2V0dGluZ3MiLCJtYXhUcmllcyIsInRyeUluZGV4IiwidHJ5aW5nIiwibGVuZ3RoIiwic2V0SW50ZXJ2YWwiLCJGQiIsIm9uIiwiZSIsInByZXZlbnREZWZhdWx0IiwidWkiLCJtZXRob2QiLCJtb2JpbGVfaWZyYW1lIiwiaHJlZiIsIndpbmRvdyIsImxvY2F0aW9uIiwicmVzcG9uc2UiLCJjbGVhckludGVydmFsIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiOztBQUFBLENBQUMsVUFBVUEsQ0FBVixFQUFhQyxNQUFiLEVBQXFCO0FBQ3BCQSxTQUFPQyxTQUFQLENBQWlCQyxXQUFqQixHQUErQjtBQUM3QkMsWUFBUSxTQUFTQSxNQUFULENBQWdCQyxPQUFoQixFQUF5QkMsUUFBekIsRUFBbUM7QUFDekMsVUFBSUMsV0FBVyxFQUFmO0FBQ0EsVUFBSUMsV0FBVyxDQUFmO0FBQ0EsVUFBSUMsTUFBSjs7QUFFQSxVQUFJVCxFQUFFLGdCQUFGLEVBQW9CVSxNQUF4QixFQUFnQztBQUM5QkQsaUJBQVNFLFlBQVksWUFBWTtBQUMvQixjQUFJLE9BQU9DLEVBQVAsS0FBYyxXQUFsQixFQUErQjtBQUM3QlosY0FBRSwwQkFBRixFQUE4QmEsRUFBOUIsQ0FBaUMsT0FBakMsRUFBMEMsVUFBVUMsQ0FBVixFQUFhO0FBQ3JEQSxnQkFBRUMsY0FBRjs7QUFFQUgsaUJBQUdJLEVBQUgsQ0FBTTtBQUNKQyx3QkFBUSxPQURKO0FBRUpDLCtCQUFlLElBRlg7QUFHSkMsc0JBQU1DLE9BQU9DLFFBQVAsQ0FBZ0JGO0FBSGxCLGVBQU4sRUFJRyxVQUFTRyxRQUFULEVBQWtCLENBQUUsQ0FKdkI7QUFLRCxhQVJEOztBQVVBQywwQkFBY2QsTUFBZDtBQUNELFdBWkQsTUFhSztBQUNILGdCQUFJLEVBQUVELFFBQUYsSUFBY0QsUUFBbEIsRUFBNEI7QUFDMUJnQiw0QkFBY2QsTUFBZDtBQUNBO0FBQ0Q7QUFDRjtBQUNGLFNBcEJRLEVBb0JOLEdBcEJNLENBQVQ7QUFxQkQ7QUFDRjtBQTdCNEIsR0FBL0I7QUErQkQsQ0FoQ0QsRUFnQ0dlLE1BaENILEVBZ0NXdkIsTUFoQ1giLCJmaWxlIjoiMy1tb2xlY3VsZXMvc29jaWFsLXNoYXJlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uICgkLCBEcnVwYWwpIHtcbiAgRHJ1cGFsLmJlaGF2aW9ycy5zb2NpYWxTaGFyZSA9IHtcbiAgICBhdHRhY2g6IGZ1bmN0aW9uIGF0dGFjaChjb250ZXh0LCBzZXR0aW5ncykge1xuICAgICAgdmFyIG1heFRyaWVzID0gMTA7XG4gICAgICB2YXIgdHJ5SW5kZXggPSAwO1xuICAgICAgdmFyIHRyeWluZztcblxuICAgICAgaWYgKCQoXCIuYXJ0aWNsZS1zaGFyZVwiKS5sZW5ndGgpIHtcbiAgICAgICAgdHJ5aW5nID0gc2V0SW50ZXJ2YWwoZnVuY3Rpb24gKCkge1xuICAgICAgICAgIGlmICh0eXBlb2YgRkIgIT09IFwidW5kZWZpbmVkXCIpIHtcbiAgICAgICAgICAgICQoXCIuYXJ0aWNsZS1zaGFyZSAuZmFjZWJvb2tcIikub24oXCJjbGlja1wiLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgICAgICAgRkIudWkoe1xuICAgICAgICAgICAgICAgIG1ldGhvZDogJ3NoYXJlJyxcbiAgICAgICAgICAgICAgICBtb2JpbGVfaWZyYW1lOiB0cnVlLFxuICAgICAgICAgICAgICAgIGhyZWY6IHdpbmRvdy5sb2NhdGlvbi5ocmVmLFxuICAgICAgICAgICAgICB9LCBmdW5jdGlvbihyZXNwb25zZSl7fSk7XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgY2xlYXJJbnRlcnZhbCh0cnlpbmcpO1xuICAgICAgICAgIH1cbiAgICAgICAgICBlbHNlIHtcbiAgICAgICAgICAgIGlmICgrK3RyeUluZGV4ID49IG1heFRyaWVzKSB7XG4gICAgICAgICAgICAgIGNsZWFySW50ZXJ2YWwodHJ5aW5nKTtcbiAgICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICAgICAgfVxuICAgICAgICAgIH1cbiAgICAgICAgfSwgNTAwKTtcbiAgICAgIH1cbiAgICB9XG4gIH07XG59KShqUXVlcnksIERydXBhbCk7XG4iXX0=
