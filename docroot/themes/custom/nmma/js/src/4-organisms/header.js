(function($, Drupal) {
  function toggleMobileMenu(override) {
    $('header.header').toggleClass('mobile-menu-active', override);
    $('.mobile-nav').toggle(override);
  }

  function toggleSearchBar(override) {
    $('header.header').toggleClass('search-active', override);
  }

  function checkWindow() {
    if (window.matchMedia('(min-width: 768px)').matches) {
      toggleMobileMenu(false);
    }
  }

  Drupal.behaviors.header = {
    attach: function attach(context, settings) {
      $('.mobile-trigger').once().click((event) => {
        event.preventDefault();

        toggleSearchBar(false);
        toggleMobileMenu();
      });

      $('.search-trigger').once().click((event) => {
        event.preventDefault();

        toggleMobileMenu(false);
        toggleSearchBar();

        if ($('.search-bar input').is(':visible')) {
          $('.search-bar input').focus();
        }
      });

      $(window).on('resize', checkWindow);
    }
  }
})(jQuery, Drupal);