(function($, Drupal) {
  Drupal.behaviors.accordion = {
    attach: function attach(context, settings) {
      $(".js-accordion").accordion({
        heightStyle: "content",
        collapsible: true,
        active: false,
        create: function( event, ui ) {
          $(event.target).find(".ui-accordion-header-icon").removeClass().addClass("icon icon-db-arrow-down");
        }
      });
    }
  }
})(jQuery, Drupal);