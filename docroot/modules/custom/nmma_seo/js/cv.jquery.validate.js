/**
 * @file
 * Attaches behaviors for the Clientside Validation jQuery module.
 */
(function ($, Drupal) {
  /**
   * Attaches jQuery validate behavoir to forms.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *  Attaches the outline behavior to the right context.
   */
  Drupal.behaviors.cvJqueryValidate = {
    attach: function (context) {
      $(context).find('form').each(function() {
        $(this).validate({
          invalidHandler: function(f, validator) {
            $.each(validator.errorList, function(key, value) {
              dataLayer.push({
                'event': 'Form Error',
                'Category': 'Form',
                'Action': 'Error',
                'Label': value.message
              });
            });
          }
        });

      });
    }
  };
})(jQuery, Drupal);
