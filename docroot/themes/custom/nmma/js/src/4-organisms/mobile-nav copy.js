(function ($, Drupal) {
  Drupal.behaviors.brandGrid = {
    attach: function attach(context, settings) {
      $('.subnav__trigger').once().click(function (e) {
        e.preventDefault();
        $(this).next('.subnav').toggleClass('collapsed');
      });
    }
  };
})(jQuery, Drupal);
