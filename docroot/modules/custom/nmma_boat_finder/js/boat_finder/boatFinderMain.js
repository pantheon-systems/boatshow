(function($, Drupal) {

boatFinder.core.init = function() {
  ko.applyBindings(boatFinder.viewModel, document.getElementById('boat-selector'));
  boatFinder.init.filterRangeSliders();
  // module.compareBoatsPanel();
  // module.mobileFilter();
};

//Instantiate a new BoatListViewModel
boatFinder.viewModel = new BoatListViewModel(null, null, null);

//Load the Boats into the Model
boatFinder.core.loadBoats(boatFinder.viewModel);

// Call Init Function
$(function() {
  boatFinder.core.init();
});

$(window).resize(function(){
  viewport = function(){
    var e = window, a = 'inner';
    if (!('innerWidth' in window)) {
      a = 'client';
      e = document.documentElement || document.body;
    }
    return { width: e[a + 'Width'], height: e[a + 'Height'] };
  };

  if (viewport().width > 991) {
    jQuery('.modal-context').css('top', jQuery('.node--view-mode-full').offset().top + 'px');
    jQuery('.modal-context').css('height', 'auto');
    jQuery('.node--view-mode-full').css('height', jQuery('.modal-context').height() + 'px');
  } else {
    jQuery('.modal-context').css('top', '0');
    jQuery('.modal-context').css('height', jQuery('body').height() + 'px');
  }
});

})(jQuery, Drupal);