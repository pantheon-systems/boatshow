window.BoatShows = window.BoatShows || {};

(function($, Drupal, BoatShows) {
  'use strict';

  var GettingToTheShow = function() {
    Drupal.behaviors.gettingToTheShow = {

      attach: function(context, settings) {
        var gmapAPIKey = 'AIzaSyDnUejJV5eCL4reoGScl4pBujqWqgU4ahk';
        var gmapScriptUrl = 'https://maps.googleapis.com/maps/api/js?key=' + gmapAPIKey; // + '&callback=initMap';
        var s = document.createElement("script");
        s.src = gmapScriptUrl;
        s.type = "text/javascript";
        s.async = false;
        document.head.appendChild(s);

        var $maps = $(context).find('.brick--type--map');
        var $arrivalLocations = $(context).find('.brick--type--arrival-location');

        $maps.each(function() {
          var $thisMap = $(this);
          var $thisMapContainer = $thisMap.find('.map-container');

          var $filteredLocations = $arrivalLocations.filter(function() {
            return $(this).data('map-id') === $thisMap.data('map-id');
          });

          function initMap() {
            var location = {lat: $thisMap.data('lat'), lng: $thisMap.data('lng')};

            // The map, centered on the location
            var map = new google.maps.Map($thisMapContainer.get(0), {zoom: 10, center: location});

            // The marker, positioned on the location
            var marker = new google.maps.Marker({position: location, map: map});
          }

          // Initialize map when gmaps script is loaded
          s.onload = function() {
            initMap();
          }
        });
      }
    };
  };

  BoatShows.GettingToTheShow = new GettingToTheShow();
})(jQuery, Drupal, BoatShows);
