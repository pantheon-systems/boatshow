 function mapInitialized() {
  google = google || {};
  google.maps = google.maps || {};
  infowindow = new google.maps.InfoWindow();
  var ll = new google.maps.LatLng(boatingMap.defaultCoordinates.latitude, boatingMap.defaultCoordinates.longitude);
  console.re.log('ll', ll, ll.lat(), ll.lng());
  boatingMap.viewModel = new goBoatingTodayViewModel(new google.maps.Map(document.getElementById('map-canvas'), {
    zoom: boatingMap.zoomLevelOverview,
    center: new google.maps.LatLng(boatingMap.defaultCoordinates.latitude, boatingMap.defaultCoordinates.longitude),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    scrollwheel: false,
    panControl: true,
    panControlOptions: {
      position: google.maps.ControlPosition.RIGHT_CENTER
    },
    zoomControlOptions: {
      position: google.maps.ControlPosition.LEFT_CENTER
    }
  }));

  var tileListener = google.maps.event.addListener(boatingMap.viewModel.map, 'tilesloaded', fixMyPageOnce);

  function fixMyPageOnce() {
    //immediately remove the listener (or this thing fires for every tile that gets loaded, which is a lot when you start to pan)
    jQuery('#map-canvas .gmnoprint div[title^="Pan "]').on('touchstart', function () {
      $(this).click();
      return false;
    });
    google.maps.event.removeListener(tileListener);
  }

  ko.applyBindings(boatingMap.viewModel, document.getElementById('go-boating-today'));

  boatingMap.viewModel.initializeSearch();

  boatingMap.viewModel.initMapControlsAndHeight();

  var checkMobile = function () {
    var isMobileView = boatingMap.viewModel.mobileView();

    if (boatingMapUtil.viewport().width <= 768) {
      if (!isMobileView) {
        boatingMap.viewModel.mobileView(true);
        boatingMap.viewModel.initMapControlsAndHeight();
      }
    } else {
      if (isMobileView) {
        boatingMap.viewModel.mobileView(false);
        boatingMap.viewModel.initMapControlsAndHeight();
      }
    }
  };

  jQuery(window).smartresize(checkMobile);

  checkMobile();
}

mapInitialized();