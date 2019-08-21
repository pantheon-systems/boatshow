'use strict';

(function($, Drupal) {

  // Example of Drupal behavior loaded.
  Drupal.behaviors.boatshowCustomFilters = {
    attach: function attach(context, settings) {
      function dateToSQLstr(d){
        let Y = d.getFullYear();
        let M = (d.getMonth()+1).toString().padStart(2, '0');
        let D = d.getDate().toString().padStart(2, '0');
        return Y+'-'+M+'-'+D
      }
      // Convert a single date to min (00:00:00) and max(23:59:59) for a given day
      // and set values to date-between form fields
      function filterDateRangeCheckboxes(value, minTarget, maxTarget) {
        let min = '';
        let max = '';
        if (value){
          const d = new Date(value);
          const date = dateToSQLstr(d);
          min = date + ' 00:00:00';
          max = date + ' 23:59:59';
        }
        jQuery(minTarget).val(min);
        jQuery(maxTarget).val(max);
      }

      $('input[type="radio"][name="field_date_radios"]').change(function() {
        const value = jQuery(this).val();
        const minTarget="#edit-field-smnr-seminar-date-value-min";
        const maxTarget="#edit-field-smnr-seminar-date-value-max";
        filterDateRangeCheckboxes(value, minTarget, maxTarget);
      });

      $('input[type="radio"][name="field_speaker_radios"]').change(function() {
        const value = jQuery(this).val();
        jQuery('#edit-field-smnr-speaker-target-id').val(value);
      });
    }
  };

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
