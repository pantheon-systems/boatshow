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

      $('.brick--type--exposed-filters').once('boatshowCustomFilters').each(function () {
        var $filtersParent = $(this);
        const $form = $(this).closest('.brick--type--exposed-filters.collapsible');

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

          // Select the view which corresponds to the exposed filters
          var viewPluginId = $filtersParent.find('.block-views').attr('data-block-plugin-id'); //e.g.
          var viewId = viewPluginId.replace('views_exposed_filter_block:','').split('-')[0];
          var viewDisplayId = viewPluginId.replace('views_exposed_filter_block:','').split('-')[1];
          var $view = $('.view-id-'+viewId+'.view-display-id-'+viewDisplayId);

          // Determine whether to open the filters by default
          var openFiltersByDefault = (
            ($view.find('.views-col').length >= 6) // Open by default if there are more than 6 results
            || ($filtersParent.find('[data-drupal-selector="edit-reset"]').length >= 1) // Open by default if filters are set (tested using presence of reset button)
          );

          $filtersParent.find('.form--inline >.form-item').each(function(){
            if (
              ($(this).css('display') != 'none')
              && openFiltersByDefault
            ){
              $(this).attr('open', '');
            }
          });

          if (openFiltersByDefault) {
            $form.removeClass('collapse');
          }
          else {
            $form.addClass('collapse');
          }

          $filtersParent.find('.toggle-filters').click(function(){
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
})(jQuery, Drupal);
