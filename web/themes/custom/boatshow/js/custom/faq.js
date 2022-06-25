(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.faq = {
    attach: function (context, settings) {
      $(context).find('.faq-list .faq-question').once('boatshow-faq').each(function() {
        var $thisFaqQuestion = $(this);

        var $thisFaqControl = $thisFaqQuestion.find('button');
        var expanded = $thisFaqControl.attr('aria-expanded');
        var $thisFaqAnswer = $thisFaqQuestion.siblings('.faq-answer').find('div#' + $thisFaqControl.attr('aria-controls'));

        if (expanded === 'false') {
          $thisFaqAnswer.hide();
        }

        $thisFaqControl.click(function(event){
          if (expanded === 'false') {
            $thisFaqControl.attr('aria-expanded', 'true');
            $thisFaqAnswer.show();
          }
          else {
            $thisFaqControl.attr('aria-expanded', 'false');
            $thisFaqAnswer.hide();
          }

          expanded = $thisFaqControl.attr('aria-expanded');
        });
      });
    }
  };
})(jQuery, Drupal);
