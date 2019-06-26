(function ($, Drupal) {
  Drupal.behaviors.engineTooltip = {
    attach: function attach(context, settings) {
      // console.log('test');
      // $('.engine-with-tooltip').hover(function(){
      //   $('.engine__tooltip', this).addClass('show');
      // })
      $('.engine-with-tooltip').hoverIntent({
        over: tooltipExpand,
        out: tooltipClose,
        timeout: 100
      });

      function tooltipExpand(){
        if(!$('.engine__tooltip', this).hasClass('show')){
          $('.engine__tooltip', this).addClass('show');
        }
      }

      function tooltipClose(){
        $('.engine__tooltip', this).removeClass('show');
      }

    }
  };
})(jQuery, Drupal);
