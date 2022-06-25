window.BoatShows = window.BoatShows || {};

(function($, Drupal, BoatShows) {
  'use strict';

  var GettingToTheShow = function() {

    function CustomMarker(latlng, map, args) {
      this.latlng = latlng;
      this.args = args;
      this.setMap(map);
    }

    function initMap($thisMap, $filteredLocations) {
      var $thisMapContainer = $thisMap.find('.map-container');
      var latLng = new google.maps.LatLng($thisMap.data('lat'), $thisMap.data('lng'));
      var gmapOptions = {
        zoom: $thisMap.data('map-zoom'),
        center: latLng,
        // disableDefaultUI: true
      }

      // The map, centered on the location
      var gmap = new google.maps.Map($thisMapContainer.get(0), gmapOptions);

      // The markers, positioned on the location
      $filteredLocations.each(function() {
        var $thisLocation = $(this);
        var markerLatLng = new google.maps.LatLng($thisLocation.data('lat'), $thisLocation.data('lng'));
        var marker = new CustomMarker(markerLatLng, gmap, {marker_id: $thisLocation.data('marker-label')});
      });
    }

    // Custom HTML marker prototype extend
    function CustomMarkerSetup() {
      CustomMarker.prototype = new google.maps.OverlayView();

      CustomMarker.prototype.draw = function() {
        var self = this;
        var markerDiv = self.div;
        if (!markerDiv) {
          markerDiv = self.div = document.createElement('div');
          var markerDivContent = document.createElement('div');
          markerDiv.appendChild(markerDivContent);
          markerDiv.className = 'map-marker-label';
          markerDivContent.className = 'marker-label-content';
          markerDiv.style.position = 'absolute';

          if (typeof(self.args.marker_id) !== 'undefined') {
            markerDiv.dataset.marker_id = self.args.marker_id;
            markerDivContent.innerHTML = self.args.marker_id;
          }

          var panes = self.getPanes();
          panes.overlayImage.appendChild(markerDiv);
        }

        var point = self.getProjection().fromLatLngToDivPixel(self.latlng);

        if (point) {
          markerDiv.style.left = (point.x - 14) + 'px';
          markerDiv.style.top = (point.y - 41) + 'px';
        }
      };

      CustomMarker.prototype.remove = function() {
        if (this.div) {
          this.div.parentNode.removeChild(this.div);
          this.div = null;
        }
      };

      CustomMarker.prototype.getPosition = function() {
        return this.latlng;
      };
    }

    Drupal.behaviors.gettingToTheShow = {
      attach: function(context, settings) {
        $(context).once('getting-to-the-show').each(function() {
          var gmapAPIKey = 'AIzaSyCDlZzpLTpVIxteGhmpaA2Iglm0_zp_dbg';
          var gmapScriptUrl = 'https://maps.googleapis.com/maps/api/js?key=' + gmapAPIKey; // + '&callback=initMap';
          var s = document.createElement("script");
          s.src = gmapScriptUrl;
          s.type = "text/javascript";
          s.async = false;
          document.head.appendChild(s);

          var $maps = $(context).find('.brick--type--map');
          var $arrivalLocations = $(context).find('.brick--type--arrival-location');

          // Initialize map when gmaps script is loaded
          s.onload = function() {
            // Set up marker prototype overrides
            CustomMarkerSetup();

            // Loop maps
            $maps.each(function() {
              var $thisMap = $(this);

              // Filter for arrival locations with same ID as map
              var $filteredLocations = $arrivalLocations.filter(function() {
                return $(this).data('map-id') === $thisMap.data('map-id');
              });

              initMap($thisMap, $filteredLocations);
            });
          }
        });
      }
    };
  };

  BoatShows.GettingToTheShow = new GettingToTheShow();
})(jQuery, Drupal, BoatShows);
