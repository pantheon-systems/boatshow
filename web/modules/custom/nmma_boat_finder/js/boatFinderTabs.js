(function ($, Drupal) {
  function toggleAllTabs() {
    var activeIndex = $('.boat-finder__tabs-wrapper').tabs("option", "active");

    if (!window.matchMedia('(min-width: 768px)').matches) {
      $('.boat-finder__tabs-wrapper .ui-tabs-panel').show();
    }
    else {
      $('.boat-finder__tabs-wrapper .ui-tabs-panel:not(:eq(' + activeIndex + '))').hide();
    }
  }

  Drupal.behaviors.boatFinderTabs = {
    attach: function (context, settings) {
      $('.boat-finder__tabs-wrapper').tabs({ 
        active: 0,
        create: function () {
          toggleAllTabs();
          $(window).on("resize", toggleAllTabs);
        }
      });
    }
  };
})(jQuery, Drupal);