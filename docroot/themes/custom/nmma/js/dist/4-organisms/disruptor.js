'use strict';

//Makes disruptors match height when stacked
(function ($, Drupal) {

  function disruptorHeight() {
    $('.disruptor').each(function () {
      var disruptor = this;

      if ($(window).width() < 768) {
        var leftHeight = $('.disruptor-content--left', this).outerHeight();
        var rightHeight = $('.disruptor-content--right', this).outerHeight();

        if ($('.disruptor-content--left .brick--type--media', this).length > 0) {
          $('.disruptor-content--left', this).css('height', $('.disruptor-content--right', this).outerHeight() + 'px');
        }

        if ($('.disruptor-content--right .brick--type--media', this).length > 0) {
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
  };
})(jQuery, Drupal);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIjQtb3JnYW5pc21zL2Rpc3J1cHRvci5qcyJdLCJuYW1lcyI6WyIkIiwiRHJ1cGFsIiwiZGlzcnVwdG9ySGVpZ2h0IiwiZWFjaCIsImRpc3J1cHRvciIsIndpbmRvdyIsIndpZHRoIiwibGVmdEhlaWdodCIsIm91dGVySGVpZ2h0IiwicmlnaHRIZWlnaHQiLCJsZW5ndGgiLCJjc3MiLCJiZWhhdmlvcnMiLCJhdHRhY2giLCJjb250ZXh0Iiwic2V0dGluZ3MiLCJqUXVlcnkiXSwibWFwcGluZ3MiOiI7O0FBQ0E7QUFDQSxDQUFDLFVBQVNBLENBQVQsRUFBWUMsTUFBWixFQUFvQjs7QUFFbkIsV0FBU0MsZUFBVCxHQUEwQjtBQUN4QkYsTUFBRSxZQUFGLEVBQWdCRyxJQUFoQixDQUFxQixZQUFVO0FBQzdCLFVBQUlDLFlBQVksSUFBaEI7O0FBRUEsVUFBR0osRUFBRUssTUFBRixFQUFVQyxLQUFWLEtBQW9CLEdBQXZCLEVBQTJCO0FBQzFCLFlBQUlDLGFBQWNQLEVBQUUsMEJBQUYsRUFBOEIsSUFBOUIsRUFBb0NRLFdBQXBDLEVBQWxCO0FBQ0EsWUFBSUMsY0FBZVQsRUFBRSwyQkFBRixFQUErQixJQUEvQixFQUFxQ1EsV0FBckMsRUFBbkI7O0FBRUEsWUFBR1IsRUFBRSw4Q0FBRixFQUFrRCxJQUFsRCxFQUF3RFUsTUFBeEQsR0FBaUUsQ0FBcEUsRUFBc0U7QUFDcEVWLFlBQUUsMEJBQUYsRUFBOEIsSUFBOUIsRUFBb0NXLEdBQXBDLENBQXdDLFFBQXhDLEVBQWtEWCxFQUFFLDJCQUFGLEVBQStCLElBQS9CLEVBQXFDUSxXQUFyQyxLQUFxRCxJQUF2RztBQUNEOztBQUVBLFlBQUdSLEVBQUUsK0NBQUYsRUFBbUQsSUFBbkQsRUFBeURVLE1BQXpELEdBQWtFLENBQXJFLEVBQXVFO0FBQ3JFVixZQUFFLDJCQUFGLEVBQStCLElBQS9CLEVBQXFDVyxHQUFyQyxDQUF5QyxRQUF6QyxFQUFtRFgsRUFBRSwwQkFBRixFQUE4QixJQUE5QixFQUFvQ1EsV0FBcEMsS0FBb0QsSUFBdkc7QUFDRDtBQUNGLE9BWEQsTUFXTztBQUNMUixVQUFFLDBCQUFGLEVBQThCLElBQTlCLEVBQW9DVyxHQUFwQyxDQUF3QyxRQUF4QyxFQUFrRCxNQUFsRDtBQUNBWCxVQUFFLDJCQUFGLEVBQStCLElBQS9CLEVBQXFDVyxHQUFyQyxDQUF5QyxRQUF6QyxFQUFtRCxNQUFuRDtBQUNEO0FBQ0YsS0FsQkQ7QUFtQkQ7O0FBRURWLFNBQU9XLFNBQVAsQ0FBaUJSLFNBQWpCLEdBQTZCO0FBQzNCUyxZQUFRLFNBQVNBLE1BQVQsQ0FBZ0JDLE9BQWhCLEVBQXlCQyxRQUF6QixFQUFtQzs7QUFFekM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNEO0FBUjBCLEdBQTdCO0FBV0QsQ0FuQ0QsRUFtQ0dDLE1BbkNILEVBbUNXZixNQW5DWCIsImZpbGUiOiI0LW9yZ2FuaXNtcy9kaXNydXB0b3IuanMiLCJzb3VyY2VzQ29udGVudCI6WyJcbi8vTWFrZXMgZGlzcnVwdG9ycyBtYXRjaCBoZWlnaHQgd2hlbiBzdGFja2VkXG4oZnVuY3Rpb24oJCwgRHJ1cGFsKSB7XG5cbiAgZnVuY3Rpb24gZGlzcnVwdG9ySGVpZ2h0KCl7XG4gICAgJCgnLmRpc3J1cHRvcicpLmVhY2goZnVuY3Rpb24oKXtcbiAgICAgIHZhciBkaXNydXB0b3IgPSB0aGlzO1xuXG4gICAgICBpZigkKHdpbmRvdykud2lkdGgoKSA8IDc2OCl7XG4gICAgICAgdmFyIGxlZnRIZWlnaHQgPSAoJCgnLmRpc3J1cHRvci1jb250ZW50LS1sZWZ0JywgdGhpcykub3V0ZXJIZWlnaHQoKSk7XG4gICAgICAgdmFyIHJpZ2h0SGVpZ2h0ID0gKCQoJy5kaXNydXB0b3ItY29udGVudC0tcmlnaHQnLCB0aGlzKS5vdXRlckhlaWdodCgpKTtcblxuICAgICAgIGlmKCQoJy5kaXNydXB0b3ItY29udGVudC0tbGVmdCAuYnJpY2stLXR5cGUtLW1lZGlhJywgdGhpcykubGVuZ3RoID4gMCl7XG4gICAgICAgICAkKCcuZGlzcnVwdG9yLWNvbnRlbnQtLWxlZnQnLCB0aGlzKS5jc3MoJ2hlaWdodCcsICQoJy5kaXNydXB0b3ItY29udGVudC0tcmlnaHQnLCB0aGlzKS5vdXRlckhlaWdodCgpICsgJ3B4Jyk7XG4gICAgICAgfVxuXG4gICAgICAgIGlmKCQoJy5kaXNydXB0b3ItY29udGVudC0tcmlnaHQgLmJyaWNrLS10eXBlLS1tZWRpYScsIHRoaXMpLmxlbmd0aCA+IDApe1xuICAgICAgICAgICQoJy5kaXNydXB0b3ItY29udGVudC0tcmlnaHQnLCB0aGlzKS5jc3MoJ2hlaWdodCcsICQoJy5kaXNydXB0b3ItY29udGVudC0tbGVmdCcsIHRoaXMpLm91dGVySGVpZ2h0KCkgKyAncHgnKTtcbiAgICAgICAgfVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgJCgnLmRpc3J1cHRvci1jb250ZW50LS1sZWZ0JywgdGhpcykuY3NzKCdoZWlnaHQnLCAnYXV0bycpO1xuICAgICAgICAkKCcuZGlzcnVwdG9yLWNvbnRlbnQtLXJpZ2h0JywgdGhpcykuY3NzKCdoZWlnaHQnLCAnYXV0bycpO1xuICAgICAgfVxuICAgIH0pO1xuICB9XG5cbiAgRHJ1cGFsLmJlaGF2aW9ycy5kaXNydXB0b3IgPSB7XG4gICAgYXR0YWNoOiBmdW5jdGlvbiBhdHRhY2goY29udGV4dCwgc2V0dGluZ3MpIHtcblxuICAgICAgLy8gJCh3aW5kb3cpLm9uKCdsb2FkJywgZnVuY3Rpb24oKSB7XG4gICAgICAvLyAgIGRpc3J1cHRvckhlaWdodCgpO1xuICAgICAgLy8gfSk7XG4gICAgICAvL1xuICAgICAgLy8gJCh3aW5kb3cpLm9uKCdyZXNpemUnLCBkaXNydXB0b3JIZWlnaHQpO1xuICAgIH1cbiAgfVxuXG59KShqUXVlcnksIERydXBhbCk7Il19
