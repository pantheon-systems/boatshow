'use strict';

(function ($, Drupal) {
  $("select").on("chosen:ready", function(evt, params) {
    var dropdown = $("div.chosen-container .chosen-single");

    dropdown.each(function (i, el) {
      if (!$(el).find("i").length) {
        $(el).append($("<i class='icon icon-db-arrow-down' />"));
      }
    });
  });

})(jQuery, Drupal);