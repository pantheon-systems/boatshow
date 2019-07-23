'use strict';

(function($, Drupal) {

  // Example of Drupal behavior loaded.
  Drupal.behaviors.boatshowCarousel = {
    attach: function attach(context, settings) {

      $('.js-nmma-carousel:not(.hero)', context).once('sliderBehavior').each(function() {
        $(this).slick({
          dots: true,
          arrows: false,
          mobileFirst: true,
          infinite: true,
          slidesToScroll: 1,
          // autoplay: true,
          customPaging: function(i) {
            return "<span class='slider-pager'></span>";
          }
        });
      });

    }
  }
})(jQuery, Drupal);
