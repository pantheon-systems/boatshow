(function ($, Drupal) {
  Drupal.behaviors.formActions = {
    attach: function attach(context, settings) {
      if ($(context)[0].id == "views-exposed-form-videos-video-display-grid") {
        $(".block-views-blockvideos-featured-video-block").slideUp();
      }
    }
  };
})(jQuery, Drupal);
