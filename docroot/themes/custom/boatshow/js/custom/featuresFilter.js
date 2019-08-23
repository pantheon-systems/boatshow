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

      jQuery('input[type="radio"][name="field_date_radios"]').change(function() {
        const value = jQuery(this).val();
        const minTarget="#edit-field-smnr-seminar-date-value-min";
        const maxTarget="#edit-field-smnr-seminar-date-value-max";
        filterDateRangeCheckboxes(value, minTarget, maxTarget);
      });

      jQuery('input[type="radio"][name="field_speaker_radios"]').change(function() {
        const value = jQuery(this).val();
        jQuery('#edit-field-smnr-speaker-target-id').val(value);
      });

      jQuery('.brick--type--exposed-filters.collapsible .toggle-filters').click(function(){
        const $form = jQuery(this).closest('.brick--type--exposed-filters.collapsible');
        $form.toggleClass('expand');
        $form.find('.form--inline >.form-item').each(function(){
          if ($form.hasClass('expand') && jQuery(this).css('display') != 'none'){
            jQuery(this).attr('open', '');
          } else {
            jQuery(this).removeAttr('open');
          }
        })
      })

      jQuery('.brick--type--exposed-filters .js-hide').each(function(){
        if (jQuery(this).is(':only-child')){
          jQuery(this).parent().remove();
        } else {
          jQuery(this).remove();
        }

      });

      jQuery('.brick--type--exposed-filters.collapsible .close-filters').click(function(){
        const $form = jQuery(this).closest('.brick--type--exposed-filters.collapsible');
        $form.removeClass('expand');
        $form.find('.form--inline >.form-item').each(function(){
          jQuery(this).removeAttr('open');
        })
      })


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
