'use strict';

(function ($, Drupal) {
  Drupal.behaviors.brandGrid = {
    attach: function attach(context, settings) {
      $('.subnav__trigger').once().click(function (e) {
        e.preventDefault();
        $(this).next('.subnav').toggleClass('collapsed');
      });
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIjQtb3JnYW5pc21zL21vYmlsZS1uYXYgY29weS5qcyJdLCJuYW1lcyI6WyIkIiwiRHJ1cGFsIiwiYmVoYXZpb3JzIiwiYnJhbmRHcmlkIiwiYXR0YWNoIiwiY29udGV4dCIsInNldHRpbmdzIiwib25jZSIsImNsaWNrIiwiZSIsInByZXZlbnREZWZhdWx0IiwibmV4dCIsInRvZ2dsZUNsYXNzIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiOztBQUFBLENBQUMsVUFBVUEsQ0FBVixFQUFhQyxNQUFiLEVBQXFCO0FBQ3BCQSxTQUFPQyxTQUFQLENBQWlCQyxTQUFqQixHQUE2QjtBQUMzQkMsWUFBUSxTQUFTQSxNQUFULENBQWdCQyxPQUFoQixFQUF5QkMsUUFBekIsRUFBbUM7QUFDekNOLFFBQUUsa0JBQUYsRUFBc0JPLElBQXRCLEdBQTZCQyxLQUE3QixDQUFtQyxVQUFVQyxDQUFWLEVBQWE7QUFDOUNBLFVBQUVDLGNBQUY7QUFDQVYsVUFBRSxJQUFGLEVBQVFXLElBQVIsQ0FBYSxTQUFiLEVBQXdCQyxXQUF4QixDQUFvQyxXQUFwQztBQUNELE9BSEQ7QUFJRDtBQU4wQixHQUE3QjtBQVFELENBVEQsRUFTR0MsTUFUSCxFQVNXWixNQVRYIiwiZmlsZSI6IjQtb3JnYW5pc21zL21vYmlsZS1uYXYgY29weS5qcyIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiAoJCwgRHJ1cGFsKSB7XG4gIERydXBhbC5iZWhhdmlvcnMuYnJhbmRHcmlkID0ge1xuICAgIGF0dGFjaDogZnVuY3Rpb24gYXR0YWNoKGNvbnRleHQsIHNldHRpbmdzKSB7XG4gICAgICAkKCcuc3VibmF2X190cmlnZ2VyJykub25jZSgpLmNsaWNrKGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgJCh0aGlzKS5uZXh0KCcuc3VibmF2JykudG9nZ2xlQ2xhc3MoJ2NvbGxhcHNlZCcpO1xuICAgICAgfSk7XG4gICAgfVxuICB9O1xufSkoalF1ZXJ5LCBEcnVwYWwpO1xuIl19
