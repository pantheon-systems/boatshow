var boatFinder = {
    options: {
     dataFeedEndpoint: '/nmma_boatfinder_endpoint/nmma_resource?_format=json'
      //dataFeedEndpoint: '/modules/custom/nmma_boat_finder/js/data/boatdata.json'
    },
    core : {},
    init : {},
    ui : {},
    viewModel: {},
    constants : {
      priceMin: 0,
      priceMax: 1000,
      maxPassengers: 20,
      minBoatLength: 6,
      maxBoatLength: 70,
      cookieName: 'boatselector',
      boatSelectorMaxWidth: 920,
      boatTypeImageRoot: 'https:\/\/discoverboating.s3.amazonaws.com\/boat-selector\/grid-images\/',
      boatTypeVideoThumbnailsRoot: 'https:\/\/discoverboating.s3.amazonaws.com\/boat-selector\/video-thumbs\/',
      boatDetailsPageUrl: '/boat-details.aspx?boat=',
      buyingBoatPagePrefix: '/buying/boat/',
      feetToMeter: 0.3048
    },
    selectors: {
      subActivities: '#sub-activities',
      subPropulsion: '#sub-propulsion',
      subTrailerable: '#sub-trailerable',
      priceSlider: '#price-slider',
      lengthSlider: '#length-slider',
      keywords: '#fltr-keywords',
      passengersSlider: jQuery('.js-filter-passengers-slider'),
      boatLengthSlider: jQuery('.js-filter-boat-length-slider'),
      passengersMobileSlider: jQuery('.js-filter-mobile-passengers-slider'),
      boatLengthMobileSlider: jQuery('.js-filter-mobile-boat-length-slider'),
      priceRangeSlider: jQuery('.js-filter-price-range-slider'),
      filterModalBtn: jQuery('.js-mobile-filter-modal'),
      page: jQuery('.page'),
      compareError: jQuery('.compare-error'),
      printButton: '#print-button',
    },
    lang: {
      Compare: "Compare",
      Keep_it_at_a_marina : "Keep it at a marina",
      No_Preference : "No Preference",
      Trailer_it_around: "Trailer it around",
      Types: "types",
      You_have_room_1: "You have room for one more boat in your comparison dock.",
      You_have_room_2: "You have room for two more boats in your comparison dock.",
      You_have_room_3: "You have room for three more boats in your comparison dock.",
      boat: "boat",
      boat_selector_tool_length_slider_max_value: "70+ ft",
      boat_selector_tool_length_slider_medium_value: "35 ft",
      boat_selector_tool_length_slider_min_value: "6 ft",
      boat_selector_tool_warning: "You can&rsquo;t add this boat to your comparison dock because all of the slots are full. To add this boat, please remove a boat from your comparison dock.",
      compare_2_boats: "compare 2 boats",
      compare_3_boats: "compare 3 boats",
      compare_4_boats: "compare 4 boats",
      compare_boats: "compare boats",
      criteria_no_results: "Sorry, your criteria did not return any results. Please widen your search....",
      ft: "ft",
      isCanada: "false",
      length: "length",
      n_a: "n/a",
      nd: "nd",
      no: "no",
      passengers: "passengers",
      rd: "rd",
      select_another_boat_to_compare: "select another boat to compare",
      st: "st",
      th: "th",
      yes: "yes",
    },
    isCanada: false,
    shared : {
      compareSlider: ''
    },
    cookies : {
      comparisonCookie: "boatselector-boat-comparison"
    }
  }

//Load Boats
boatFinder.core.loadBoats = function (viewModel) {
  console.log(boatFinder.options.dataFeedEndpoint);
  jQuery.ajax({
    url: boatFinder.options.dataFeedEndpoint,
    datatype: 'json',
    success: function (responseData) {
      boatFinder.core.transformData(responseData, viewModel);
    },
    error: function (e) {
      console.log("error", e);
    }
  });
}

boatFinder.core.getComparisonCookieValue = function () {
  var result;
  var cookieValue = jQuery.cookie(boatFinder.cookies.comparisonCookie);
  if (cookieValue !== undefined) {
    result = cookieValue.split(',');
  }
  return result;
};

boatFinder.core.setComparisonCookieValue = function(valueArr) {
  if (valueArr == 'undefined') {
    return;
  }
  var valueStr = valueArr.join(','),
    options = { expires: 30 };
  jQuery.cookie(boatFinder.cookies.comparisonCookie, valueStr, options);

};

boatFinder.core.mobileFilters = function(event){
  var modal;

  jQuery('.js-mobile-filter-modal').openModal({
    url: '#mobile-filters',
    title: 'Filter', //window.NMMA_LANG.compare_boats
    className: 'modal-mobile-filter',
    width: 'auto',
    onLoad: function () {
      var modalContent = jQuery('.modal-content');

      ko.applyBindings(boatFinder.viewModel, document.getElementById('mobile-filters-wrapper'));

      var passengerInit = boatFinder.viewModel.filters.maxCapacity.MaxCapacity();
      var boatLengthMinInit = boatFinder.viewModel.filters.boatLength.MinLength();
      var boatLengthMaxInit = boatFinder.viewModel.filters.boatLength.MaxLength();

      //Popup Range Sliders
      boatFinder.init.mobileFilterRangeSliders(passengerInit, boatLengthMinInit, boatLengthMaxInit);

      window.scrollTo(0, 0);
      jQuery("#main > article").hide();

      modal = this;
    },
    onClose: function() {
      jQuery("#main > article").show();
    }
  });
}

boatFinder.core.transformData = function (data, viewModel) {
  // var displayParameter = sharedf.getQueryString["display"];
  // var displayParameterExists = displayParameter !== undefined && displayParameter != "";
  var displayParameter = false;
  var displayParameterExists = false;

  jQuery.each(data.Activities, function (i, activity) {
    activity.isSelected = false;
    if (displayParameterExists) {
      activity.isSelected = displayParameter == activity.Slug;
    }
    if (activity.isSelected) {
      viewModel.filters.IncreaseActiveFiltersCount();
    }
    viewModel.AddActivity(activity);
  });

  jQuery.each(data.PropulsionTypes, function (i, type) {
    viewModel.AddPropulsion(type);
  });

  var comparables = boatFinder.core.getComparisonCookieValue();

  jQuery.each(data.BoatTypes, function (i, boat) {
    var maxCapacityAttr = jQuery.grep(boat.Attributes, function (attr) { return attr.Id === 1; })[0],
      trailerableAttr = jQuery.grep(boat.Attributes, function (attr) { return attr.Id === 2; })[0],
      minLengthAttr = jQuery.grep(boat.Attributes, function (attr) { return attr.Id === 4; })[0],
      maxLengthAttr = jQuery.grep(boat.Attributes, function (attr) { return attr.Id === 3; })[0],
      minPriceAttr = jQuery.grep(boat.Attributes, function (attr) { return attr.Id === 6; })[0],
      maxPriceAttr = jQuery.grep(boat.Attributes, function (attr) { return attr.Id === 7; })[0];

    if (!maxCapacityAttr) {
      log('No capacity attribute was found for: ' + boat.Name);
      maxCapacityAttr = { Value: 1 };
    }

    if (!trailerableAttr) {
      log('No trailerable attribute was found for: ' + boat.Name);
      trailerableAttr = { Value: 'False' };
    }

    if (!minLengthAttr) {
      log('No min length attribute was found for: ' + boat.Name);
      minLengthAttr = { Value: 0 };
    }

    if (!maxLengthAttr) {
      log('No max length attribute was found for: ' + boat.Name);
      maxLengthAttr = { Value: 0 };
    }

    if (!minPriceAttr) {
      log('No min price attribute was found for: ' + boat.Name);
      minPriceAttr = { Value: 0 };
    }

    if (!maxPriceAttr) {
      log('No max price attribute was found for: ' + boat.Name);
      maxPriceAttr = { Value: 0 };
    }

    // Map Activities object to id array:
    boat.activities = jQuery.map(boat.Activities, function (activity) { return activity.Id; });

    boat.maxCapacity = parseInt(maxCapacityAttr.Value, 10);
    boat.minLength = parseInt(minLengthAttr.Value, 10);
    boat.maxLength = parseInt(maxLengthAttr.Value, 10);
    boat.propulsions = jQuery.map(boat.PropulsionTypes, function (propulsion) { return propulsion.Id; });
    boat.priceMin = parseInt(minPriceAttr.Value, 10) / 1000;
    boat.priceMax = parseInt(maxPriceAttr.Value, 10) / 1000;
    boat.isTrailerable = trailerableAttr.Value.toLowerCase() === 'true';

    if (comparables !== undefined && comparables.length > 0) {
      boat.isComparable = jQuery.inArray(boat.Id.toString(), comparables) >= 0;
    } else {
      boat.isComparable = false;
    }
    viewModel.AddBoat(boat);
  });

  viewModel.comparison.ComparableBoats.subscribe(viewModel.comparison.ComparisonCookie);
  console.log('core data');
  console.log(data);
  return data;
};