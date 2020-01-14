(function ($, Drupal) {
  'use strict';

  /**
   *
   * @param jquery object $contentMaskElement
   * @param object options
   */
  function maskText($contentMaskElement, options) {

    // Options defaults, can be overridden with options param
    var defaults = {
      expandText: 'Read more',
      collapseText: 'Hide',
      maxHeight: 70,
      buttonClass: 'read-more-button',
      gradientEndColor: '#fff',
      parentSelector: null
    };

    var settings = $.extend({}, defaults, options || {});
    var expanded = false;

    if ($contentMaskElement.height() > settings.maxHeight) {
      // Button for expanding content
      var $contentMaskExpandBtn = $('<button class='+ settings.buttonClass +'>' + settings.expandText + '</button>');

      // If parentSelector option is set, grab background color
      if (settings.parentSelector !== null) {
        var $parentElem = $contentMaskElement.closest(settings.parentSelector);

        var bgColor = $parentElem.css('background-color');

        // Default element bg color is transparent,
        // so set as param value if transparent.
        if (bgColor !== 'rgba(0, 0, 0, 0)') {
          settings.gradientEndColor = bgColor;
        }
      }

      $contentMaskElement.addClass('content-mask');
      // wrap content in div
      $contentMaskElement.wrapInner('<div class="content-mask-inner"></div>');
      var $contentMaskInner = $contentMaskElement.find('.content-mask-inner')

      $contentMaskInner.append('<div class="content-mask-overlay"></div>');
      $contentMaskInner.css({height: settings.maxHeight + 'px'});

      $contentMaskElement.find('.content-mask-overlay').css({
        background: 'linear-gradient(transparent,' + settings.gradientEndColor + ')'
      });

      // append button
      $contentMaskElement.append($contentMaskExpandBtn);

      // Toggle show/hide content
      $contentMaskExpandBtn.click(function(event) {
        event.preventDefault();

        if (!expanded) {
          $contentMaskElement.addClass('expanded');
          $contentMaskExpandBtn.html(settings.collapseText);
        }
        else {
          $contentMaskElement.removeClass('expanded');
          $contentMaskExpandBtn.html(settings.expandText);
        }

        expanded = !expanded;
      });
    }
  }

  /**
   * Drupal Behavior
   */
  Drupal.behaviors.boatshowReadMore = {
    attach: function attach(context, settings) {

      // whos-exhibiting, /boat-brands pages
      $(context).find('.view-exhibitors.view-display-id-block_1 .view-booths, .view-exhibitors.view-display-id-block_2 .view-booths, .view-exhibitors.view-display-id-block_3 .view-booths').once('whos-exhibiting').each(function() {
        maskText($(this), {
          expandText: 'See all booths',
          maxHeight: 70,
          parentSelector: 'tr'
        });
      });

      // Sailing at the show page
      $(context).find('.view-exhibitors.view-display-id-sail_boats .view-booths').once('exhibitors-by-brand').each(function() {
        maskText($(this), {
          expandText: 'See all booths'
        });
      });

      // speakers view
      $(context).find('.view-all-speakers .views-row .speaker-text').once('speakers').each(function() {
        maskText($(this), {
          maxHeight: 200,
          gradientEndColor: '#f5f5f5'
        });
      });

      // features view
      $(context).find('.features-grid .grid-item--content .body').once('features').each(function() {
        maskText($(this), {
          maxHeight: 250,
          gradientEndColor: '#e7e5e5'
        });
      });
    }
  };
})(jQuery, Drupal);
