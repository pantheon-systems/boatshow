
//Makes disruptors match height when stacked
(function($, Drupal) {

  function disruptorHeight(){
    $('.disruptor').each(function(){
      var disruptor = this;

      if($(window).width() < 768){
       var leftHeight = ($('.disruptor-content--left', this).outerHeight());
       var rightHeight = ($('.disruptor-content--right', this).outerHeight());

       if($('.disruptor-content--left .brick--type--media', this).length > 0){
         $('.disruptor-content--left', this).css('height', $('.disruptor-content--right', this).outerHeight() + 'px');
       }

        if($('.disruptor-content--right .brick--type--media', this).length > 0){
          $('.disruptor-content--right', this).css('height', $('.disruptor-content--left', this).outerHeight() + 'px');
        }
      } else {
        $('.disruptor-content--left', this).css('height', 'auto');
        $('.disruptor-content--right', this).css('height', 'auto');
      }
    });
  }

  Drupal.behaviors.disruptor = {
    attach: function attach(context, settings) {

      // $(window).on('load', function() {
      //   disruptorHeight();
      // });
      //
      // $(window).on('resize', disruptorHeight);
    }
  }

})(jQuery, Drupal);