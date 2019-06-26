(function ($, Drupal) {
  Drupal.behaviors.loanCalculatorTabs = {
    attach: function (context, settings) {
      $('#loan-calc-wrapper').tabs({ active: 0});
    }
  };
})(jQuery, Drupal);