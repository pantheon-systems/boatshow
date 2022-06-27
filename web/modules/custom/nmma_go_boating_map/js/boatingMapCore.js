var boatingMap = {
  core: {},
  mapFunctions: {},
  service: null,
  infowindow: null,
  viewModel: null,
  placesPerPage : 6,
  zoomLevelOverview : 13, //zoomLevelOverview : Number(lang.GBT_DefaultZoom) || 13,
  keywordHash : [],
  selectedKeywords : [],
  keywordIdx : 0,
  searchQueue : [],
  radarCache : [],
  radarCacheByKeyword : {},
  radarCacheById : {},
  completedRadarRequests : 0,
  nearbyCache : [],
  nearbyCacheByKeyword : {},
  nearbyCacheById : {},
  completedNearbyRequests : 0,
  totalRequests : 0,
  prevLatLang: null,
  failsafe: null,
  tabImagesPathBase : '/shared-site/static/images/tab-backgrounds/',
  pinIcon : '/modules/custom/nmma_go_boating_map/images/map-pin.png',
  reqs : 0,
  defaultCoordinates : {
    latitude: 10.8781208, //latitude: lang.GBT_DefaultLatitude || 41.8781208
    longitude: -30.6294101 //longitude: lang.GBT_DefaultLongitude || -87.6294101
  }
}

console.re = console.re || console;

if (isNaN(boatingMap.zoomLevelOverview)) {
  boatingMap.zoomLevelOverview = 13;
}

//Core Functions
boatingMap.core.getBrowserLocation = function (callback) {
  console.re.log('core.getBrowserLocation()')
  // Try HTML5 geolocation
  console.log(navigator.geolocation);
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
        position.coords.longitude);

      boatingMap.viewModel.map.setCenter(pos);
      boatingMap.viewModel.setCoordinates(position.coords.latitude, position.coords.longitude);
      boatingMap.viewModel.map.setZoom(boatingMap.zoomLevelOverview);

      var geocoder = new google.maps.Geocoder();
      var addr;
      geocoder.geocode({'location': pos}, function(results, status) {
        if (status === 'OK') {
          if (results[0] && results[0].address_components.length) {
            var addressComps = results[0].address_components;
            addr = addressComps[2].short_name + ', ' + addressComps[5].short_name + ', ' + addressComps[6].short_name;
            boatingMap.viewModel.address(addr);
            jQuery('#go-boating-today #inputSubmit').val(addr);
          }
          else {
            window.alert('No results found');
          }
        }
        else {
          window.alert('Geocoder failed due to: ' + status);
        }
      });

        callback.call(callback, true);
    }, function () {
      callback.call(callback, true);
    });
  } else {
    callback.call(callback, false);
  }
};

// boatingMap.core.getGeoLocation = function (callbackFn) {
//   var callback;
//   if (!callbackFn) {
//     console.re.log('MISSING CALLBACK AT "getGeoLocation()"');
//     callback = function () { };
//   }
//   else {
//     callback = callbackFn;
//   }
//   // console.re.log('core.getGeoLocation');
//   // console.re.log('shared.isMobile.checkAny');
//   // console.re.log(shared.isMobile().checkAny);
//   // If mobile try HTML5 geo
//   //TODO shared
//   // if (shared.isMobile().checkAny) {
//   //   callback.status = null;
//   //   boatingMap.core.getBrowserLocation(callback);
//   //   return;
//   // }
//
//   // Otherwise try IP based
//   //TODO reintegrate location
//   if (window.NMMA_LOCATION) {
//     console.log('location gotten');
//     var geocoder = new google.maps.Geocoder();
//     var loc = window.NMMA_LOCATION;
//     var addr;
//
//     if (loc.city.indexOf('Reserved') !== -1 || loc.city.indexOf('Private') !== -1 ||
//       loc.state.indexOf('Reserved') !== -1 || loc.state.indexOf('Private') !== -1) {
//       console.re.log('location is private: ', loc);
//       boatingMap.viewModel.locationServicesWork(false);
//       callback.status = false;
//       callback(false);
//       return;
//     }
//
//     addr = loc.city + ' ' + loc.state + ' ' + loc.country;
//     boatingMap.viewModel.address(addr);
//
//     geocoder.geocode({
//       "address": boatingMap.viewModel.address()
//     }, function (results) {
//       if (results && results[0] && results[0].geometry) {
//         //TODO shared
//         // var params = {
//         //   pace: 'Chicago Illinois US',
//         //   page: '1'
//         // }
//         var params = boatingMapUtil.getHashParams();
//         params.place = boatingMap.viewModel.address();
//         boatingMapUtil.hashQueryUpdate(params);
//         var pos = new google.maps.LatLng(results[0].geometry.location.lat(),
//           results[0].geometry.location.lng());
//
//         boatingMap.viewModel.map.setCenter(pos);
//         boatingMap.viewModel.map.setZoom(boatingMap.zoomLevelOverview);
//
//         boatingMap.viewModel.setCoordinates(results[0].geometry.location.lat(), results[0].geometry.location.lng());
//         callback.status = true;
//         callback(true);
//       }
//       else {
//         boatingMap.viewModel.locationServicesWork(false);
//         console.re.log('geocode failed with addr:');
//         console.re.log(addr);
//         callback.status = false;
//         callback(false);
//       }
//     });
//   }
//   else {
//     callback(false);
//   }
// };

//Map Functions

boatingMap.mapFunctions.clearMapMarkers = function() {
  boatingMap.mapFunctions.setAllMap(null);

  if (boatingMap.viewModel != undefined && boatingMap.viewModel.radarPlaces != undefined) {
    boatingMap.viewModel.radarPlaces.removeAll();
  }
};

boatingMap.mapFunctions.setAllMap = function(map) {
  if (boatingMap.viewModel == undefined || boatingMap.viewModel.radarPlaces() == undefined || boatingMap.viewModel.radarPlaces().length == 0) {
    return;
  }

  for (var i = 0; i < boatingMap.viewModel.radarPlaces().length; i++) {
    boatingMap.viewModel.radarPlaces()[i].marker().setMap(map);
  }
};

boatingMap.mapFunctions.processNearbyResults = function () {
  var resultsToDisplay = [];
  var resultsToDisplayById = {};

  var currentPage = 1;
  var currentKeywordResults;
  var i = 0;
  var x = 0;
  var place_id;

  console.log(selectedKeywords);
  // loop through each keyword
  for (i = 0; i < selectedKeywords.length; i++) {
    currentKeywordResults = boatingMap.nearbyCacheByKeyword[selectedKeywords[i]];

    if (!currentKeywordResults) {
      continue;
    }

    // check each keyword result set for dueplicates
    for (x = 0; x < currentKeywordResults.length; x++) {
      place_id = currentKeywordResults[x].place_id;
      // check if this entry exists
      if (!resultsToDisplayById[place_id]) {
        // add to ID hash
        resultsToDisplayById[place_id] = currentKeywordResults[x];
        // add to display hash
        resultsToDisplay[resultsToDisplay.length] = currentKeywordResults[x];
      }
    }
  }

  console.re.log('# of nearby results', resultsToDisplay.length)

  if (resultsToDisplay.length > 0) {
    boatingMap.viewModel.totalResults(resultsToDisplay.length);

    for (var i = 0; i < resultsToDisplay.length; i++) {
      resultsToDisplay[i].index = i + 1;
      boatingMap.viewModel.addPlace(resultsToDisplay[i]);
    }

    if (boatingMap.viewModel.isFirstLoad) {
      //TODO shared hashparams contains page number

      // var page = shared.getHashParams().page;

      //currentPage = page ? page : 1;
      currentPage = 1;
      boatingMap.viewModel.isFirstLoad = false;
    } else {
      boatingMap.viewModel.setPlacesPage(1);
    }

    boatingMap.viewModel.setPlacesPage(currentPage);
    boatingMap.viewModel.setPagination(currentPage);
  }
  else {
    boatingMap.viewModel.totalResults(0);
    boatingMap.viewModel.setPagination();
  }

  //boatingMap.viewModel.checkDoneLoading();
};

boatingMap.mapFunctions.processRadarResults = function () {
  var resultsToDisplay = [];
  var resultsToDisplayById = {};

  var currentPage = 1;
  var currentKeywordResults;
  var i = 0;
  var x = 0;
  var place_id;

  console.log(selectedKeywords);
  // loop through each keyword
  for (i = 0; i < selectedKeywords.length; i++) {
    currentKeywordResults = boatingMap.nearbyCacheByKeyword[selectedKeywords[i]];

    if (!currentKeywordResults) {
      continue;
    }

    // check each keyword result set for dueplicates
    for (x = 0; x < currentKeywordResults.length; x++) {
      place_id = currentKeywordResults[x].place_id;
      // check if this entry exists
      if (!resultsToDisplayById[place_id]) {
        // add to ID hash
        resultsToDisplayById[place_id] = currentKeywordResults[x];
        // add to display hash
        resultsToDisplay[resultsToDisplay.length] = currentKeywordResults[x];
      }
    }
  }

  console.re.log('# of radar results', resultsToDisplay.length);

  var bounds = new google.maps.LatLngBounds();
  var latlng;

  if (resultsToDisplay.length > 0) {

    for (i = 0; i < resultsToDisplay.length; i++) {
      resultsToDisplay[i].index = i + 1;
      boatingMap.viewModel.addRadarPlace(resultsToDisplay[i]);
      latlng = new google.maps.LatLng(resultsToDisplay[i].geometry.location.lat(),
        resultsToDisplay[i].geometry.location.lng());
      bounds.extend(latlng);
      //console.re.log('resultsToDisplay[i]');
      //console.re.log(resultsToDisplay[i]);
    }

    boatingMap.viewModel.resetMap(bounds);
  }
};

boatingMap.mapFunctions.nearbySearchCallback = function (idx, keyword, results, status) {
  var requestsComplete = boatingMap.totalRequests === ++boatingMap.completedNearbyRequests;

  console.re.log('r', results);

  var i = 0;
  var result;

  if (!boatingMap.nearbyCacheByKeyword[keyword]) {
    boatingMap.nearbyCacheByKeyword[keyword] = [];
  }

  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (i = 0; i < results.length; i++) {
      result = results[i];
      result._keyword = keyword;
      boatingMap.nearbyCache[boatingMap.radarCache.length] = result;
      boatingMap.nearbyCacheByKeyword[keyword][boatingMap.nearbyCacheByKeyword[keyword].length] = result;
      boatingMap.nearbyCacheById[results[i].place_id] = result;
    }
  }

  if (requestsComplete) {
    console.re.log('nearby done');
    boatingMap.mapFunctions.processNearbyResults();
    // console.log('processRadarResultsCalled');
    boatingMap.mapFunctions.processRadarResults();
  }
};

boatingMap.mapFunctions.radarSearchCallback = function (idx, keyword, results, status) {
  console.re.log('radar cb, idx', idx);
  console.re.log('keyword', keyword);

  var requestsComplete = boatingMap.totalRequests === ++boatingMap.completedRadarRequests;
  var i = 0;
  var result;

  if (!boatingMap.radarCacheByKeyword[keyword]) {
    boatingMap.radarCacheByKeyword[keyword] = [];
  }

  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (i = 0; i < results.length; i++) {
      result = results[i];
      result._keyword = keyword;
      boatingMap.radarCache[boatingMap.radarCache.length] = result;
      boatingMap.radarCacheByKeyword[keyword][boatingMap.radarCacheByKeyword[keyword].length] = result;
      boatingMap.radarCacheById[results[i].place_id] = result;
    }
  }

  if (requestsComplete) {
    console.re.log('radar complete');
    boatingMap.viewModel.isLoading(false);
    // boatingMap.viewModel.checkDoneLoading();
  }
};