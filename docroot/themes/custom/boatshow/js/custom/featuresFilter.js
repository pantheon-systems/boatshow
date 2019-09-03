(function($, Drupal) {
  'use strict';

  // Convert a single date to min (00:00:00) and max(23:59:59) for a given day
  // and set values to date-between form fields
  function filterDateRangeCheckboxes(value, minTarget, maxTarget) {
    if (value){
      let min = value.split('|')[0];
      let max = value.split('|')[1];
      console.log(min, max);
      $(minTarget).val(min);
      $(maxTarget).val(max);
    }
  }

  // Example of Drupal behavior loaded.
  Drupal.behaviors.boatshowCustomFilters = {
    attach: function attach(context, settings) {

      $('.brick--type--exposed-filter').once('boatshowCustomFilters').each(function () {
        $filtersParent = $(this);

        $filtersParent.find('input[type="radio"][name="field_date_radios"]').change(function() {
          const value = $(this).val();
          const minTarget="#edit-field-smnr-seminar-date-value-min";
          const maxTarget="#edit-field-smnr-seminar-date-value-max";
          filterDateRangeCheckboxes(value, minTarget, maxTarget);
        });

        $filtersParent.find('input[type="radio"][name="field_speaker_radios"]').change(function() {
          const value = $(this).val();
          $('#edit-field-smnr-speaker-target-id').val(value);
        });

        if ($filtersParent.hasClass('collapsible')) {
          $filtersParent.find('.form--inline >.form-item').each(function(){
            if ($(this).css('display') != 'none'){
              $(this).attr('open', '');
            }
          });

          $filtersParent.find('.toggle-filters').click(function(){
            const $form = $(this).closest('.brick--type--exposed-filters.collapsible');
            $form.toggleClass('collapse');
            $form.find('.form--inline >.form-item').each(function(){
              if (!$form.hasClass('collapse') && $(this).css('display') != 'none'){
                $(this).attr('open', '');
              } else {
                $(this).removeAttr('open');
              }
            })
          });

          $filtersParent.find('.close-filters').click(function(){
            const $form = $(this).closest('.brick--type--exposed-filters.collapsible');
            $form.addClass('collapse');
            $form.find('.form--inline >.form-item').each(function(){
              $(this).removeAttr('open');
            })
          });
        }
      });
    }
  };

  Drupal.behaviors.boatshowFeaturesFilter = {
    attach: function attach(context, settings) {

      // Features filter.
      $('.features-filter .filter').once('boatshowFeaturesFilter').on('click', function() {
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
})($, Drupal);
