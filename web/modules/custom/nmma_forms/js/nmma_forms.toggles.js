/**
 * @file
 * Alter checkboxes and radios using JS.
 */
(function ($, Drupal) {
  Drupal.behaviors.nmma_forms_toggles = {
    attach: function (context) {
      $(context).find('input[type="checkbox"].form-checkbox, input[type="radio"].form-radio').once().each(function() {
        var $toggle = $(this);
        var $label = $toggle.next('label');
        var icon = $toggle[0].type == 'checkbox' ? '<i class="icon icon-db-check"></i>' : '<i class="icon icon-db-circle"></i>';
        if ($label.length === 1) {
          $label.addClass('toggle-wrapper');
          $toggle.appendTo($label);
          $(icon).appendTo($label);
        }
      });
    }
  };
})(jQuery, Drupal);
