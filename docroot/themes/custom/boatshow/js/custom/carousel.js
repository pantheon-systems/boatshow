(function($, Drupal) {
  'use strict';

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

      // Dining teaser images
      $('.featured-dining .node--type-dining.node--view-mode-teaser .field--name-field-media.field__items', context).once('diningCarousels').each(function() {
        $(this).slick({
          dots: false,
          arrows: true,
          mobileFirst: true,
          infinite: true,
          rows: 1,
          centerMode: true,
          slidesToScroll: 1,
          variableWidth: true,
          accessibility: true,
          adaptiveHeight: true,
          responsive: [
            {
              breakpoint: 767, // $screen-md - 1px
              settings: {
                arrows: false,
                infinite: false,
                centerMode: false,
                variableWidth: false
              }
            }
          ]
        });
      });
    }
  }
})(jQuery, Drupal);
