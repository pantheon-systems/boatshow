'use strict';

(function ($, Drupal) {

  function inIframe () {
    try {
      return window.self !== window.top;
    } catch (e) {
      return false;
    }
  }

  if (inIframe()){
    $('.hide-on-embed').addClass('hidden');
  }
})(jQuery, Drupal);