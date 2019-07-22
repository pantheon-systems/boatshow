'use strict';

(function($, Drupal) {

  // Example of Drupal behavior loaded.
  Drupal.behaviors.boatshowFeaturesFilter = {
    attach: function attach(context, settings) {

      // Features filter.
      $('.features-filter .filter').on('click', function() {
        var class_name = $.grep(this.className.split(" "), function(v, i){
          return v.indexOf('filter-') === 0;
        }).join();

        var $this = $(this);
        var isSelected = $this.hasClass('filter-selected');
        var selectedFilters = $('.features-filter .filter-selected');
        var isFirstSelection = !selectedFilters.length;
        var allCards = $('.features-grid .filter');

        if (isSelected) {
          $this.removeClass('filter-selected');
          selectedFilters = $('.features-filter .filter-selected');
          // If all filters are now unchecked, show all results.
          if (!selectedFilters.length) {
            allCards.closest('.column-item').show();
          } else {
            allCards.filter('.' + class_name).closest('.column-item').hide();
          }
        } else {
          $this.addClass('filter-selected');
          if (isFirstSelection) {
            allCards.closest('.column-item').hide();
            allCards.filter('.' + class_name).closest('.column-item').show();
          } else {
            allCards.filter('.' + class_name).closest('.column-item').show();
          }
        }
      });
    }
  };
})(jQuery, Drupal);
