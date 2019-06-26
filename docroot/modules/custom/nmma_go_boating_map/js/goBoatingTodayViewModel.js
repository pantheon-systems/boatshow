// ViewModel
var goBoatingTodayViewModel = function(map) {
  var parent = this;

  window._NMMA_MAP = parent.map = map;

  parent.isLoading = ko.observable(true);
  parent.places = ko.observableArray();
  parent.radarPlaces = ko.observableArray();
  parent.coordinates = ko.observable(boatingMap.defaultCoordinates);
  parent.pagination = ko.observable();
  parent.address = ko.observable();
  parent.totalResults = ko.observable();
  parent.locationServicesWork = ko.observable(true);

  parent.mobileView = ko.observable(boatingMapUtil.viewport().width <= 768);
  parent.isFirstLoad = true;

  parent.kwBoatRentalActive = ko.observable(true);
  parent.kwBoatCharterActive = ko.observable(true);

  //Lang variables not defined on page
  keywordHash = [
    { observable: parent.kwBoatRentalActive, keyword: 'Boat Rental' },
    // { observable: parent.kwBoatRentalActive, keyword: lang.GBT_Keywords_BoatRental },
    { observable: parent.kwBoatCharterActive, keyword: 'Charter' }
    // { observable: parent.kwBoatCharterActive, keyword: lang.GBT_Keywords_BoatCharter }
  ];

  parent.resetUi = function (msg) {
    if (msg) {
      parent.hasMessage(true);
      parent.message(msg);
    }
    parent.places.removeAll();
    parent.radarPlaces.removeAll();
    parent.totalResults(0);
    parent.setPagination();
    parent.isLoading(false);
    return;
  };

  parent.hasMessage = ko.observable();
  parent.message = ko.observable();

  parent.getLocation = function () {
    parent.isLoading(true);
    boatingMap.core.getBrowserLocation(function (gotLocation) {
      //console.re.log('parent.getLocation() > core.getBrowserLocation()');
      // console.re.log(gotLocation);
      if (gotLocation) {
        parent.searchForLocations();
      }
      else {
        //lang undefined
        parent.resetUi('');
        // parent.resetUi(lang.GBT_Msg_GetLocationFailed);
        return;
      }
    });
  }

  parent.getMapHeight = function() {
    return parent.mobileView() ? "368px" : "998px";
  }

  parent.initMapControlsAndHeight = function() {
    jQuery('#map-canvas').css('height', parent.getMapHeight());

    parent.map.setOptions({
      draggable: !parent.mobileView(),
      panControlOptions: {
        position: parent.mobileView() ? google.maps.ControlPosition.RIGHT_CENTER : google.maps.ControlPosition.RIGHT_TOP
      },
      zoomControlOptions: {
        position: parent.mobileView() ? google.maps.ControlPosition.LEFT_CENTER : google.maps.ControlPosition.LEFT_TOP
      }
    });

    google.maps.event.trigger(parent.map, "resize");
  }

  parent.isEmbeddedPage = function() {
    return window.location.pathname === "/get-on-the-water/embedded.aspx";
  }

  parent.addPlace = function (place) {
    console.log('place added');
    parent.places.push(new placeViewModel(place));
  }

  parent.addRadarPlace = function (place) {
    console.log('pin addded');
    parent.radarPlaces.push(new radarPlaceViewModel(place));
  }

  parent.setCoordinates = function(lat, lng) {
    parent.coordinates(new coordinatesViewModel(lat, lng));
  }

  parent.setPagination = function(currentPage) {
    parent.pagination(new paginationViewModel(parent.totalResults(), currentPage));
  }

  parent.searchLocation = function () {
    console.log('searchloc fired');
    parent.isLoading(true);
    var geocoder = new google.maps.Geocoder();
    var searchAdd = jQuery('#inputSubmit').val();

    geocoder.geocode({ 'address': searchAdd}, function(results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
        parent.setCoordinates(results[0].geometry.location.lat(), results[0].geometry.location.lng());
      }
      else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

  parent.coordinates.subscribe(function () {
    parent.searchForLocations();
  }, null, "change");

  parent.kwBoatRentalActive.subscribe(function () {
    parent.searchForLocations();
  }, null, "change");

  parent.kwBoatCharterActive.subscribe(function () {
    parent.searchForLocations();
  }, null, "change");

  parent.getKeywords = function () {
    var keywords = [];

    for (var i = 0; i < keywordHash.length; i++) {
      if (keywordHash[i].observable()) {
        keywords[keywords.length] = keywordHash[i].keyword;
      }
    }

    return keywords;
  }

  parent.searchForLocations = function () {
    // console.log('coords');
    // console.log(parent.coordinates());
    // console.log('inSearch');
    var coordinates = parent.coordinates();
    var latLang = new google.maps.LatLng(coordinates.latitude, coordinates.longitude);
    var radius = '50000';
    selectedKeywords = parent.getKeywords();
    var timer;

    service = new google.maps.places.PlacesService(parent.map);

    boatingMap.mapFunctions.clearMapMarkers();

    if (typeof coordinates === 'undefined' && typeof parent.address() === 'undefined') {
      parent.resetUi(lang.GBT_Msg_EnterLocation);
      return;
    }

    if (selectedKeywords.length === 0) {
      parent.hasMessage(true);
      parent.message(lang.GBT_Msg_SelectFilter);
      parent.totalResults(0);
      parent.setPagination();
      parent.isLoading(false);
      return;
    }

    parent.hasMessage(false);
    parent.message('');

    /**/
    if (boatingMap.prevLatLang)
	    console.re.log('prevLatLang', boatingMap.prevLatLang.lat(), boatingMap.prevLatLang.lng());
    // console.re.log('latLang', latLang.lat(), latLang.lng());
    /**/

    if (boatingMap.prevLatLang && latLang.lat() === boatingMap.prevLatLang.lat()
      && latLang.lng() === boatingMap.prevLatLang.lng() && !boatingMap.viewModel.isFirstLoad) {
      //boatingMap.mapFunctions.processRadarResults();
      boatingMap.mapFunctions.processNearbyResults();
      return;
    }
    else {
      boatingMap.prevLatLang = latLang;
      boatingMap.keywordIdx = 0;

      boatingMap.radarCache = [];
      boatingMap.radarCacheByKeyword = {};
      boatingMap.radarCacheById = {};
      boatingMap.completedRadarRequests = 0;

      boatingMap.nearbyCache = [];
      boatingMap.nearbyCacheByKeyword = {};
      boatingMap.nearbyCacheById = {};
      boatingMap.completedNearbyRequests = 0;

      parent.resetUi();

      boatingMap.totalRequests = selectedKeywords.length;
    }

    if (parent.isLoading()) {
      // console.re.log('search tried to execute during busy operation');
      return;
    }

    parent.isLoading(true);

    boatingMap.failsafe = setTimeout(function () {
      if (parent.isLoading()) {
        parent.resetUi(); //TODO:(lang.GBT_Msg_Failsafe);
      }
    }, 7500);

    // console.re.log('executing search interval');

    timer = setInterval(function () {
      /**/
      // console.re.log('r', ++reqs);
      // console.re.log('keywordIdx', boatingMap.keywordIdx);
      // console.re.log(keywordHash[boatingMap.keywordIdx] ? keywordHash[boatingMap.keywordIdx].keyword : 'no kw');
      /**/
      if (boatingMap.keywordIdx === keywordHash.length || boatingMap.keywordIdx > 10 || !keywordHash[boatingMap.keywordIdx]) {
        //console.re.log('loop ender');
        clearInterval(timer);
        clearTimeout(boatingMap.failsafe);
        return;
      }

      if (!keywordHash[boatingMap.keywordIdx].observable()) {
        //console.re.log('skipping kw', keywordHash[boatingMap.keywordIdx].keyword);
        boatingMap.keywordIdx++;
        return;
      }

      var radarRequestCallback = (function(idx, keyword) {
        return function(results, status) {
          return boatingMap.mapFunctions.radarSearchCallback(idx, keyword, results, status);
        }
      }(boatingMap.keywordIdx, keywordHash[boatingMap.keywordIdx].keyword));

      var nearbyRequestCallback = (function(idx, keyword) {
        return function(results, status) {
          return boatingMap.mapFunctions.nearbySearchCallback(idx, keyword, results, status);
        }
      }(boatingMap.keywordIdx, keywordHash[boatingMap.keywordIdx].keyword));

      // service.radarSearch({
      //   location: latLang,
      //   radius: radius,
      //   keyword: keywordHash[boatingMap.keywordIdx].keyword,
      // }, radarRequestCallback);

      service.nearbySearch({
        location: latLang,
        radius: radius,
        keyword: keywordHash[boatingMap.keywordIdx].keyword,
      }, nearbyRequestCallback);

      boatingMap.keywordIdx++
    }, 250);

    //viewModel.map.setCenter(latLang);
  }

  parent.checkDoneLoading = function () {
    // var radarComplete = boatingMap.totalRequests === boatingMap.completedRadarRequests;
    // var nearbyComplete = boatingMap.totalRequests === boatingMap.completedNearbyRequests;

    /*
        console.re.log('check done:');
        console.re.log('totalRequests', totalRequests);
        console.re.log('completedRadarRequests', completedRadarRequests);
        console.re.log('completedNearbyRequests', completedNearbyRequests);
    */

    clearTimeout(boatingMap.failsafe);
    parent.isLoading(false);

    if (parent.totalResults() === 0) {
      parent.hasMessage(true);
      // parent.message(lang.GBT_Msg_NoResults)
      parent.message('');
    }
    else {
      //boatingMap.mapFunctions.processRadarResults();
    }

    // if (nearbyComplete && radarComplete) {
    //   clearTimeout(boatingMap.failsafe);
    //   parent.isLoading(false);
    //
    //   if (parent.totalResults() === 0) {
    //     parent.hasMessage(true);
    //     // parent.message(lang.GBT_Msg_NoResults)
    //     parent.message('');
    //   }
    //   else {
    //     //boatingMap.mapFunctions.processRadarResults();
    //   }
    // }
  };

  parent.clearSelectedPlaces = function() {
    $.each(parent.places(), function (i, place) {
      if (place.isSelected()) {
        place.isSelected(false);
      }
    });
  }

  parent.resetMap = function (bounds) {
    if (typeof bounds !== 'undefined') {
      parent.map.fitBounds(bounds);
      parent.map.setCenter(bounds.getCenter());
      google.maps.event.addListenerOnce(parent.map, 'bounds_changed', function (event) {
        //console.re.log('bounds_changed');
        //console.re.log(event);
        //if (this.getZoom() > 10) {
        //this.setZoom(10);
        //}
      });
    }
    else {
      parent.map.setZoom(zoomLevelOverview);
      google.maps.event.trigger(parent.map, 'resize');
      parent.map.setCenter(new google.maps.LatLng(parent.coordinates().latitude, parent.coordinates().longitude));
    }
  };

  parent.setPlacesPage = function (page) {
    if (!page) {
      return;
    }

    if (typeof page === "string") {
      page = parseInt(page);
    }

    page = page - 1;

    var start = page * boatingMap.placesPerPage,
      end = start + boatingMap.placesPerPage;

    for (var i = 0; i < parent.places().length; i++) {
      if (i >= start && i < end) {
        parent.places()[i].setActive(true);
      } else {
        parent.places()[i].setActive(false);
      }
    }
  };

  parent.initializeSearch = function () {
    console.log('initsearch Called');
    var qs = document.location.search.split('+').join(' ');

    var params = {},
      tokens,
      re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
      params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }

    if(params.zipcode){
      jQuery('#inputSubmit').val(params.zipcode);
      parent.searchLocation();
    } else {
      boatingMap.core.getBrowserLocation(function (gotLocation) {
        // console.re.log('parent.initializeSearch() > core.getGeoLocation()');
        // console.re.log('gotLocation:');
        // console.re.log(gotLocation);
        if (!gotLocation) {
          //parent.resetUi(lang.GBT_Msg_GetLocationFailed);
          console.log('getLocationFailed')
          parent.resetUi('');
        }
        console.log('LOCATION');
      });
    }
  };

  var coordinatesViewModel = function (lat, lng) {
    var coordinates = this;
    coordinates.latitude = lat;
    coordinates.longitude = lng;
  }

  var placeViewModel = function(place) {
    var placeModel = this;

    placeModel.id = place.place_id;
    placeModel.name = ko.observable(place.name);
    placeModel.title = ko.computed(function () {
      return place.index + '.&nbsp;&nbsp;' + place.name;
    });

    placeModel.rating = ko.observable(Number(place.rating));
    placeModel.ratingStars = ko.observableArray();
    for (var i = 1; i <= 5; i++) {
      placeModel.ratingStars.push({ star: i <= Math.round(placeModel.rating()) ? 'full' : 'empty' });
    }

    placeModel.address = ko.observable(place.formatted_address == undefined ? place.vicinity : place.formatted_address);

    placeModel.isSelected = ko.observable(false);
    placeModel.isActive = ko.observable(false);
    placeModel.infoWindow;
    placeModel.hasWebsiteLink = ko.observable(false);
    placeModel.websiteLink = ko.observable();

    placeModel.directionsLink = ko.computed(function() {
      return "//maps.google.com/?q=" + encodeURI(placeModel.address());
    });
    placeModel.directionsLinkGTM = ko.computed(function() {
      return "Go Boating Today - Direction - " + placeModel.address();
    });
    placeModel.websiteLinkGTM = ko.computed(function() {
      return "Go Boating Today - Website - " + placeModel.websiteLink();
    });
    placeModel.directionsLinkPrGTM = ko.computed(function() {
      return "participation referral - directions - " + placeModel.address();
    });
    placeModel.websiteLinkPrGTM = ko.computed(function() {
      return "participation referral - website - " + placeModel.websiteLink();
    });
    placeModel.googleSearchLink = ko.computed(function () {
      return "//www.google.com/search?q=" + encodeURI(placeModel.title() + " " + placeModel.address());
    });

    placeModel.setActive = function(active) {
      placeModel.isActive(active);
    }

    placeModel.getWebsiteLink = function(callback) {
      service = new google.maps.places.PlacesService(boatingMap.viewModel.map);

      service.getDetails({
        placeId: placeModel.id
      }, function (result, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK && result.website) {
          callback(result.website);
        } else {
          callback(placeModel.googleSearchLink());
        }
      });
    }

    placeModel.goToWebsite = function () {
      placeModel.getWebsiteLink(function(website) {
        window.location.href = website;
      });
    }
  }

  parent.selectedPlace = ko.observable();

  var radarPlaceViewModel = function (place) {
    var radarPlaceModel = this;
    radarPlaceModel.id = place.place_id;
    radarPlaceModel.keyword = place._keyword;

    radarPlaceModel.placeModel;
    radarPlaceModel.infoWindow;
    radarPlaceModel.isSelected = ko.observable(false);

    radarPlaceModel.marker = ko.observable(new google.maps.Marker({
      map: parent.map,
      icon: {
        url: boatingMap.pinIcon,
        labelOrigin: new google.maps.Point(14,15),
      },
      label: {
        text: place.index.toString(),
        color: "white",
        fontSize: "12px",
      },
      place: {
        placeId: place.place_id,
        location: place.geometry.location
      }
    }));

    radarPlaceModel.pinClicked = function (item, event) {
      google.maps.event.trigger(item.marker(), 'click');

      $("html, body").animate({ scrollTop: $('.js-filter-map-container').offset().top }, 1000);

    }

    radarPlaceModel.openInfoWindow = function (marker) {
      var place = boatingMap.nearbyCacheById[radarPlaceModel.id];
      var placeModel = new placeViewModel(place);
      var apiStatus = false;
      var websiteLink;
      var target;
      var wrap;

      radarPlaceModel.isSelected(true);
      parent.selectedPlace(placeModel);

      /**
       console.re.log('parent', parent);
       console.re.log('placeModel', placeModel);
       /**/

      service = new google.maps.places.PlacesService(parent.map);

      service.getDetails({
        placeId: radarPlaceModel.id
      }, function (result, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK && result.website) {
          apiStatus = true;
          websiteLink = result.website;
        } else {
          websiteLink = placeModel.googleSearchLink();
        }
        if (apiStatus) {
          placeModel.websiteLink(websiteLink);
          placeModel.hasWebsiteLink(true);
        }

        callWindow();
      });

      function callWindow() {
        target = document.getElementById('infowindow-container').cloneNode(true);
        target.style.display = 'block';

        wrap = document.createElement('div');
        wrap.appendChild(target);

        infowindow.setContent(wrap.innerHTML);
        infowindow.open(boatingMap.viewModel.map, marker);
        jQuery.each(jQuery('a').filter(function(index) { return jQuery(this).text() === "View on Google Maps"; }), function() {
          var link = jQuery(this);
          link.attr('data-gtm-tracking', 'participation referral - view on google maps - ' + placeModel.address());
        });
        if (typeof (radarPlaceModel.infoWindow) === 'undefined') {
          radarPlaceModel.infoWindow = infowindow;
          var closeClickListener = google.maps.event.addListener(radarPlaceModel.infoWindow, 'closeclick', function () {
            document.getElementById('infowindow-container').appendChild(radarPlaceModel.infoWindow.getContent());
            radarPlaceModel.isSelected(false);
            parent.selectedPlace(null);
            google.maps.event.removeListener(closeClickListener);
          });
        }
      }

    }

    ko.computed(function () {
      google.maps.event.addListener(radarPlaceModel.marker(), 'click', function () {
        var marker = this;

        // We need to request more details from Google
        if (!boatingMap.nearbyCacheById[radarPlaceModel.id]) {
          service.getDetails(place, function (result, status) {
            //console.re.log(status);
            if (status !== google.maps.places.PlacesServiceStatus.OK) {
              console.error(status);
              return;
            }

            var byKeyword = boatingMap.nearbyCacheByKeyword[radarPlaceModel.keyword] || [];

            boatingMap.nearbyCache[boatingMap.nearbyCache.length] = result;
            byKeyword[byKeyword.length] = result;
            boatingMap.nearbyCacheById[radarPlaceModel.id] = result;

            radarPlaceModel.openInfoWindow(marker);
          });
        }
        else {
          radarPlaceModel.openInfoWindow(marker);
        }
      });
    });
  };

  var paginationViewModel = function(totalResults, currentPage) {
    var paginationModel = this,
      totalPages = Math.ceil(totalResults / boatingMap.placesPerPage);
    //console.re.log('totalPages:')
    //console.re.log(totalPages);
    if (typeof currentPage === "string") {
      currentPage = parseInt(currentPage);
    }

    paginationModel.pages = ko.observableArray();
    for (var i = 0; i < totalPages; i++) {
      paginationModel.pages.push(new pageViewModel(i + 1));
    }

    paginationModel.currentPage = ko.observable(currentPage ? currentPage : 1);
    paginationModel.totalPages = ko.observable(totalPages);

    paginationModel.loadPage = function (page) {
      paginationModel.currentPage(page);
      parent.setPlacesPage(page);
    };
  }

  var pageViewModel = function(page) {
    var pageModel = this;

    pageModel.page = page;
  }
} // viewModel