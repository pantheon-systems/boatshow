(function($, Drupal) {
  Drupal.behaviors.mobileNav = {
    attach: function attach(context, settings) {
      var isHovering = false;

      //Mobile SubNavs
      $('.subnav__trigger').once().click(function(e){
        e.preventDefault();
        
        $(this).toggleClass('active');
        $(this).next('.subnav').toggleClass('collapsed');
      });

      // Show/hide the megamenu drawer
      $('.header .menu.screen-lg-up').hoverIntent({
        over: mmExpand,
        out: mmClose,
        selector: 'li.menu-item',
        timeout: 500
      });

      // Highlight/unhighlight the menu item text
      $('.header .menu.screen-lg-up').hoverIntent({
        over: activateSelection,
        out: deactivateSelection,
        selector: 'li.menu-item'
      });

      function getIndex (el) {
        return el.find('a').attr('id').substr(el.find('a').attr('id').length - 1);
      }

      function mmExpand() {
        $('.megamenu--region').removeClass('active');
        $('.megamenu--region-' + getIndex($(this))).addClass('active');

        $('.header').addClass('drawer-open');
      }

      function mmClose() {
        $('.megamenu--region-' + getIndex($(this))).removeClass('active');

        if (!isHovering) {
          $('.header').removeClass('drawer-open');
        }
      }

      function activateSelection () {
        $('#mm-dd-' + getIndex($(this))).addClass('active');
        isHovering = true;
      }

      function deactivateSelection () {
        $('#mm-dd-' + getIndex($(this))).removeClass('active');
        isHovering = false;
      }
    }
  }
})(jQuery, Drupal);