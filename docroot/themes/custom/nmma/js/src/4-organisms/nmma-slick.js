(function ($, Drupal) {
  Drupal.behaviors.hero = {
    attach: function attach(context, settings) {
      $('.hero', context).once('heroBehavior').each(function(){
        var hero = this;
        $(hero).slick({
            dots: $('.slide', hero).length > 1 ? true : false,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 3000,
            customPaging: function (i) {
              return "<span class='slider-pager'></span>";
            }
        });
      }).slick("pause");

      setTimeout(function() { $(".hero").slick("play"); }, 5000);

	    $('.js-nmma-carousel:not(.hero)', context).once('sliderBehavior').each(function () {
        $(this).slick({
  		    dots: true,
  		    arrows: true,
  		    infinite: true,
  		    slidesToScroll: 1,
          centerMode: true,
  		    // autoplay: true,
  		    customPaging: function (i) {
  			    return "<span class='slider-pager'></span>";
  		    }
        });
	    });
    }
  }
})(jQuery, Drupal);
