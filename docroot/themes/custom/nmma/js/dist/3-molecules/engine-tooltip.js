'use strict';

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

      function tooltipExpand() {
        if (!$('.engine__tooltip', this).hasClass('show')) {
          $('.engine__tooltip', this).addClass('show');
        }
      }

      function tooltipClose() {
        $('.engine__tooltip', this).removeClass('show');
      }
    }
  };
})(jQuery, Drupal);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIjMtbW9sZWN1bGVzL2VuZ2luZS10b29sdGlwLmpzIl0sIm5hbWVzIjpbIiQiLCJEcnVwYWwiLCJiZWhhdmlvcnMiLCJlbmdpbmVUb29sdGlwIiwiYXR0YWNoIiwiY29udGV4dCIsInNldHRpbmdzIiwiaG92ZXJJbnRlbnQiLCJvdmVyIiwidG9vbHRpcEV4cGFuZCIsIm91dCIsInRvb2x0aXBDbG9zZSIsInRpbWVvdXQiLCJoYXNDbGFzcyIsImFkZENsYXNzIiwicmVtb3ZlQ2xhc3MiLCJqUXVlcnkiXSwibWFwcGluZ3MiOiI7O0FBQUEsQ0FBQyxVQUFVQSxDQUFWLEVBQWFDLE1BQWIsRUFBcUI7QUFDcEJBLFNBQU9DLFNBQVAsQ0FBaUJDLGFBQWpCLEdBQWlDO0FBQy9CQyxZQUFRLFNBQVNBLE1BQVQsQ0FBZ0JDLE9BQWhCLEVBQXlCQyxRQUF6QixFQUFtQztBQUN6QztBQUNBO0FBQ0E7QUFDQTtBQUNBTixRQUFFLHNCQUFGLEVBQTBCTyxXQUExQixDQUFzQztBQUNwQ0MsY0FBTUMsYUFEOEI7QUFFcENDLGFBQUtDLFlBRitCO0FBR3BDQyxpQkFBUztBQUgyQixPQUF0Qzs7QUFNQSxlQUFTSCxhQUFULEdBQXdCO0FBQ3RCLFlBQUcsQ0FBQ1QsRUFBRSxrQkFBRixFQUFzQixJQUF0QixFQUE0QmEsUUFBNUIsQ0FBcUMsTUFBckMsQ0FBSixFQUFpRDtBQUMvQ2IsWUFBRSxrQkFBRixFQUFzQixJQUF0QixFQUE0QmMsUUFBNUIsQ0FBcUMsTUFBckM7QUFDRDtBQUNGOztBQUVELGVBQVNILFlBQVQsR0FBdUI7QUFDckJYLFVBQUUsa0JBQUYsRUFBc0IsSUFBdEIsRUFBNEJlLFdBQTVCLENBQXdDLE1BQXhDO0FBQ0Q7QUFFRjtBQXRCOEIsR0FBakM7QUF3QkQsQ0F6QkQsRUF5QkdDLE1BekJILEVBeUJXZixNQXpCWCIsImZpbGUiOiIzLW1vbGVjdWxlcy9lbmdpbmUtdG9vbHRpcC5qcyIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiAoJCwgRHJ1cGFsKSB7XG4gIERydXBhbC5iZWhhdmlvcnMuZW5naW5lVG9vbHRpcCA9IHtcbiAgICBhdHRhY2g6IGZ1bmN0aW9uIGF0dGFjaChjb250ZXh0LCBzZXR0aW5ncykge1xuICAgICAgLy8gY29uc29sZS5sb2coJ3Rlc3QnKTtcbiAgICAgIC8vICQoJy5lbmdpbmUtd2l0aC10b29sdGlwJykuaG92ZXIoZnVuY3Rpb24oKXtcbiAgICAgIC8vICAgJCgnLmVuZ2luZV9fdG9vbHRpcCcsIHRoaXMpLmFkZENsYXNzKCdzaG93Jyk7XG4gICAgICAvLyB9KVxuICAgICAgJCgnLmVuZ2luZS13aXRoLXRvb2x0aXAnKS5ob3ZlckludGVudCh7XG4gICAgICAgIG92ZXI6IHRvb2x0aXBFeHBhbmQsXG4gICAgICAgIG91dDogdG9vbHRpcENsb3NlLFxuICAgICAgICB0aW1lb3V0OiAxMDBcbiAgICAgIH0pO1xuXG4gICAgICBmdW5jdGlvbiB0b29sdGlwRXhwYW5kKCl7XG4gICAgICAgIGlmKCEkKCcuZW5naW5lX190b29sdGlwJywgdGhpcykuaGFzQ2xhc3MoJ3Nob3cnKSl7XG4gICAgICAgICAgJCgnLmVuZ2luZV9fdG9vbHRpcCcsIHRoaXMpLmFkZENsYXNzKCdzaG93Jyk7XG4gICAgICAgIH1cbiAgICAgIH1cblxuICAgICAgZnVuY3Rpb24gdG9vbHRpcENsb3NlKCl7XG4gICAgICAgICQoJy5lbmdpbmVfX3Rvb2x0aXAnLCB0aGlzKS5yZW1vdmVDbGFzcygnc2hvdycpO1xuICAgICAgfVxuXG4gICAgfVxuICB9O1xufSkoalF1ZXJ5LCBEcnVwYWwpO1xuIl19
