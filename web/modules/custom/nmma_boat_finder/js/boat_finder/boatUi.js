boatFinder.ui.formatDecimal = function (value, fixedDigits) {
  var result = value.toFixed(fixedDigits);
  if (boatFinder.options.cultureCode === 'fr-ca') {
    result = result.replace('.', ',');
  }
  return result;
};

boatFinder.ui.showComparisonAlert = function (el) {
  var alert = '<div class="compare-alert">' + 'Warning' + '</div>';
  var self = jQuery(el);
  $('.compare-alert').remove();
  self.parent().append(alert);
  setTimeout(function() {
    self.siblings('.compare-alert').remove();
  }, 10000);
};

boatFinder.init.filterRangeSliders = function() {
  var passengersSliderMin = 0,
    passengersSliderMax = boatFinder.constants.maxPassengers,
    boatLengthSliderMin = boatFinder.constants.minBoatLength,
    boatLengthSliderMax = boatFinder.constants.maxBoatLength,
    passengersSliderInit = false,
    boatLengthSliderInit = false,
    boatLengthSliderUpdateCnt = 0;

  var passengersSlider = document.getElementsByClassName('js-filter-passengers-slider')[0];

  noUiSlider.create(passengersSlider, {
    range: {
      'min' : passengersSliderMin,
      'max' : passengersSliderMax
    },
    start: passengersSliderMin,
    tooltips: [wNumb({decimals: 0})],
    step: 1,
    connect: 'lower',
    handles: 1,
    serialization: {
      to: [false, false],
      resolution: 1
    },
  });

  passengersSlider.noUiSlider.on('update', function( values, handle ){
    boatFinder.viewModel.UpdateCapacity(values[0], passengersSliderInit);
    // Flag every subsequent updates as already being init so we can tell the
    // difference between page load and user interaction.
    passengersSliderInit = true;
  });

  jQuery(document).ready(function () {
    boatFinder.selectors.passengersSlider.wrap("<div class='noUi-holder'></div>");
    boatFinder.selectors.passengersSlider.append('<div class="noUi-ranges _4"><span>' + boatFinder.lang.No_Preference + '</span><div><span class="screen-md-up">5</span><span class="screen-md-up">10</span><span class="screen-md-up">15</span><span>20+</span></div></div>');
  });

  var boatLengthSlider = document.getElementsByClassName('js-filter-boat-length-slider')[0];

  noUiSlider.create(boatLengthSlider, {
    range: {
      'min' : boatLengthSliderMin,
      'max' : boatLengthSliderMax
    },
    start: [boatLengthSliderMin, boatLengthSliderMax],
    tooltips: [
      wNumb({decimals: 0, suffix: ' ft'}),
      wNumb({decimals: 0, suffix: ' ft'})],
    step: 1,
    handles: 2,
    connect: true,
    serialization: {
      to: [false, false],
      resolution: 1
    },
  });

  boatLengthSlider.noUiSlider.on('update', function( values, handle ){
    boatFinder.viewModel.UpdateBoatLength(values[0], values[1], boatLengthSliderInit);
    // Flag every subsequent updates as already being init so we can tell the
    // difference between page load and user interaction.
    boatLengthSliderUpdateCnt++;
    if (values.length === boatLengthSliderUpdateCnt) {
      boatLengthSliderInit = true;
    }
  });

  jQuery(document).ready(function () {
    boatFinder.selectors.boatLengthSlider.wrap("<div class='noUi-holder'></div>");
    boatFinder.selectors.boatLengthSlider.append('<div class="noUi-ranges _7"><span>' + boatFinder.lang.No_Preference + '</span><div><span class="screen-md-up">20</span><span class="screen-md-up">30</span><span class="screen-md-up">40</span><span class="screen-md-up">50</span><span class="screen-md-up">60</span><span>70+</span></div></div>');
  });
};

boatFinder.init.mobileFilterRangeSliders = function(passengerInit, boatLengthMinInit, boatLengthMaxInit){
  var passengersSliderMin = 0,
    passengersSliderMax = boatFinder.constants.maxPassengers,
    boatLengthSliderMin = boatFinder.constants.minBoatLength,
    boatLengthSliderMax = boatFinder.constants.maxBoatLength,
    passengersSliderInit = false,
    boatLengthSliderInit = false,
    boatLengthSliderUpdateCnt = 0;

  var passengersMobileSlider = document.getElementsByClassName('js-filter-mobile-passengers-slider')[0];

  noUiSlider.create(passengersMobileSlider, {
    range: {
      'min' : passengersSliderMin,
      'max' : passengersSliderMax
    },
    start: passengerInit? passengerInit : passengersSliderMin,
    tooltips: [wNumb({decimals: 0})],
    step: 1,
    connect: 'lower',
    handles: 1,
    serialization: {
      to: [false, false],
      resolution: 1
    },
  });

  passengersMobileSlider.noUiSlider.on('update', function( values, handle ){
    boatFinder.viewModel.UpdateCapacity(values[0], passengersSliderInit);
    passengersSliderInit = true;
  });

    boatFinder.selectors.passengersMobileSlider.wrap("<div class='noUi-holder'></div>");
    boatFinder.selectors.passengersMobileSlider.append('<div class="noUi-ranges _4"><span>' + boatFinder.lang.No_Preference + '</span><div><span class="screen-md-up">5</span><span class="screen-md-up">10</span><span class="screen-md-up">15</span><span>20+</span></div></div>');
  var boatLengthSlider = document.getElementsByClassName('js-filter-mobile-boat-length-slider')[0];

  var boatLengthSliderMinStart = boatLengthSliderMin;
  var boatLengthSliderMaxStart = boatLengthSliderMax;

  if(boatLengthMinInit){
    boatLengthSliderMinStart = boatLengthMinInit;
  }
  if(boatLengthMaxInit){
    boatLengthSliderMaxStart = boatLengthMaxInit;
  }

  noUiSlider.create(boatLengthSlider, {
    range: {
      'min' : boatLengthSliderMin,
      'max' : boatLengthSliderMax
    },
    start: [boatLengthSliderMinStart, boatLengthSliderMaxStart],
    tooltips: [
      wNumb({decimals: 0, suffix: ' ft'}),
      wNumb({decimals: 0, suffix: ' ft'})],
    step: 1,
    handles: 2,
    connect: true,
    serialization: {
      to: [false, false],
      resolution: 1
    },
  });

  boatLengthSlider.noUiSlider.on('update', function( values, handle ){
    boatFinder.viewModel.UpdateBoatLength(values[0], values[1], boatLengthSliderInit);
    boatLengthSliderUpdateCnt++;
    if (values.length === boatLengthSliderUpdateCnt) {
      boatLengthSliderInit = true;
    }
  });

  jQuery(document).ready(function () {
    boatFinder.selectors.boatLengthMobileSlider.wrap("<div class='noUi-holder'></div>");
    boatFinder.selectors.boatLengthMobileSlider.append('<div class="noUi-ranges _7"><span>' + boatFinder.lang.No_Preference + '</span><div><span class="screen-md-up">20</span><span class="screen-md-up">30</span><span class="screen-md-up">40</span><span class="screen-md-up">50</span><span class="screen-md-up">60</span><span>70+</span></div></div>');
  });
};