'use strict';

(function ($, Drupal) {
  $("select").on("chosen:ready", function (evt, params) {
    var dropdown = $("div.chosen-container .chosen-single");

    dropdown.each(function (i, el) {
      if (!$(el).find("i").length) {
        $(el).append($("<i class='icon icon-db-arrow-down' />"));
      }
    });
  });
})(jQuery, Drupal);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIjAtdXRpbGl0eS9nbG9iYWwuanMiXSwibmFtZXMiOlsiJCIsIkRydXBhbCIsIm9uIiwiZXZ0IiwicGFyYW1zIiwiZHJvcGRvd24iLCJlYWNoIiwiaSIsImVsIiwiZmluZCIsImxlbmd0aCIsImFwcGVuZCIsImpRdWVyeSJdLCJtYXBwaW5ncyI6IkFBQUE7O0FBRUEsQ0FBQyxVQUFVQSxDQUFWLEVBQWFDLE1BQWIsRUFBcUI7QUFDcEJELElBQUUsUUFBRixFQUFZRSxFQUFaLENBQWUsY0FBZixFQUErQixVQUFTQyxHQUFULEVBQWNDLE1BQWQsRUFBc0I7QUFDbkQsUUFBSUMsV0FBV0wsRUFBRSxxQ0FBRixDQUFmOztBQUVBSyxhQUFTQyxJQUFULENBQWMsVUFBVUMsQ0FBVixFQUFhQyxFQUFiLEVBQWlCO0FBQzdCLFVBQUksQ0FBQ1IsRUFBRVEsRUFBRixFQUFNQyxJQUFOLENBQVcsR0FBWCxFQUFnQkMsTUFBckIsRUFBNkI7QUFDM0JWLFVBQUVRLEVBQUYsRUFBTUcsTUFBTixDQUFhWCxFQUFFLHVDQUFGLENBQWI7QUFDRDtBQUNGLEtBSkQ7QUFLRCxHQVJEO0FBVUQsQ0FYRCxFQVdHWSxNQVhILEVBV1dYLE1BWFgiLCJmaWxlIjoiMC11dGlsaXR5L2dsb2JhbC5qcyIsInNvdXJjZXNDb250ZW50IjpbIid1c2Ugc3RyaWN0JztcblxuKGZ1bmN0aW9uICgkLCBEcnVwYWwpIHtcbiAgJChcInNlbGVjdFwiKS5vbihcImNob3NlbjpyZWFkeVwiLCBmdW5jdGlvbihldnQsIHBhcmFtcykge1xuICAgIHZhciBkcm9wZG93biA9ICQoXCJkaXYuY2hvc2VuLWNvbnRhaW5lciAuY2hvc2VuLXNpbmdsZVwiKTtcblxuICAgIGRyb3Bkb3duLmVhY2goZnVuY3Rpb24gKGksIGVsKSB7XG4gICAgICBpZiAoISQoZWwpLmZpbmQoXCJpXCIpLmxlbmd0aCkge1xuICAgICAgICAkKGVsKS5hcHBlbmQoJChcIjxpIGNsYXNzPSdpY29uIGljb24tZGItYXJyb3ctZG93bicgLz5cIikpO1xuICAgICAgfVxuICAgIH0pO1xuICB9KTtcblxufSkoalF1ZXJ5LCBEcnVwYWwpOyJdfQ==
