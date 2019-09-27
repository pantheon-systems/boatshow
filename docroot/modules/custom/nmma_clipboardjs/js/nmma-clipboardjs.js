/**
 * @file
 * Javascript to integrate the clipboard.js library with Drupal.
 */

window.ClipboardJS = window.ClipboardJS || Clipboard;

(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.clipboardjs = {
    attach: function (context, settings) {
      var selector = '.js-nm-clipboard';
      $(selector, context).once('nmma-clipboardjs-hide-tooltip').each(function (i, e) {
        Drupal.behaviors.clipboardjs.hideTooltip(e);
      });

      Drupal.clipboard = new ClipboardJS(selector);
      Drupal.clipboard.on('success', function (e) {
        var text = Drupal.behaviors.clipboardjs.getAlertText(e.trigger);
        switch (e.trigger.getAttribute('data-clipboard-alert')) {
          case 'alert':
            alert(text);
            break;
          default:
            e.trigger.setAttribute('data-clipboard-alert-text', text);
            $(e.trigger).addClass(Drupal.behaviors.clipboardjs.getTooltipCssClasses(e.trigger));
            setTimeout(function () {
                Drupal.behaviors.clipboardjs.clearTooltip(e.trigger);
            }, 2000);
        }
      });
      Drupal.clipboard.on('error', function (e) {
        var message = '';
        if (/iPhone|iPad/i.test(navigator.userAgent)) {
          message = 'This device does not support HTML5 Clipboard Copying. Please copy manually.';
        }
        else {
          message = /Mac/i.test(navigator.userAgent) ? 'Press ⌘-C to copy' : 'Press Ctrl-C to copy';
        }
        switch (e.trigger.getAttribute('data-clipboard-alert')) {
          case 'alert':
            alert(message);
            break;
          default:
            e.trigger.setAttribute('data-clipboard-alert-text', message);
            $(e.trigger).addClass(Drupal.behaviors.clipboardjs.getTooltipCssClasses(e.trigger));
        }
      });
    },

    clearTooltip: function (e) {
      $(e).removeClass(Drupal.behaviors.clipboardjs.getTooltipCssClasses(e));
    },

    getAlertText: function (e) {
      return e.getAttribute('data-clipboard-alert-default-text') || 'copied to clipboard';
    },

    getTooltipCssClasses: function (e) {
      var classes = ['nm-clipboard__tooltip'];
      classes.push(Drupal.behaviors.clipboardjs.getTooltipStyle(e));
      return classes.join(' ');
    },

    getTooltipStyle: function (e) {
      return e.getAttribute('data-clipboardtooltip-style') || 'nm-clipboard__tooltip--top';
    },

    hideTooltip: function (e) {
      var $e = $(e);
      if ($e.data('clipboardAlert') === 'tooltip') {
        $e.on('blur', function () {
          Drupal.behaviors.clipboardjs.clearTooltip(this);
        });
        $e.on('mouseleave', function () {
          Drupal.behaviors.clipboardjs.clearTooltip(this);
        });
      }
    },
  }
})(jQuery, Drupal, drupalSettings);
