(function ($, Drupal) {
  Drupal.behaviors.nmma_forms_cshs = {
    attach: function attach(context, settings) {
      $('.select-wrapper', context).once('nmma-forms-cshs').each(function () {
        Drupal.behaviors.nmma_forms_cshs.createMiniChosenSelect(this);
      });
    },

    /**
     * Create a basic DOM dropdown that will piggyback on chosen-select's styling.
     *
     * @param {jQuery} parent
     *   Attach parent for new dropdown
     */
    createMiniChosenSelect: function (parent) {
      var $parent = $(parent);
      var $select = $parent.find("select");
      var $newSelect = $("<div class='chosen-container chosen-container-single form-select chosen-enable chosen-container-single-nosearch' />");
      var $activator = $("<a class='chosen-single' data-gtm-tracking=''><span></span><i class='icon icon-db-arrow-down'></i></a>");
      var $dropdown = $("<div class='chosen-drop'></div>");
      var $results = $("<ul class='chosen-results'></ul>");

      var gtmText = 'Navigation - {selected} - Inline';
      var activationClasses = "chosen-container-active chosen-with-drop";

      var updateActivator = function (text) {
        $activator.attr("data-gtm-tracking", gtmText.replace("{selected}", text));
        $activator.find("span").html(text);
      };

      $select.hide();

      $activator.on("click", function (e) {
        $(e.target).closest(".chosen-container").toggleClass(activationClasses);
      });

      $(document).on("click", function (e) {
        var $parent = $(e.target).closest(".select-wrapper");

        $(".chosen-container").each(function (i, v) {
          if (!$(v).is($parent.find(".chosen-container"))) {
            $(v).removeClass(activationClasses);
          }
        });
      });

      $select.find("option").each(function (i, v) {
        var $option = $("<li class='active-result' data-value='" + v.value + "'>" + v.innerText + "</li>");

        $($option).on("click", function (e) {
          var value = $(e.target).attr("data-value");
          var text = e.target.innerText;

          $select.val(value);
          $select.trigger("change");

          updateActivator(text);
          $(".chosen-container").removeClass(activationClasses);

          Drupal.attachBehaviors();
        });

        $results.append($option);
      });

      updateActivator($select.find("option:selected").text());

      $dropdown.append($results);
      $newSelect.append($activator);
      $newSelect.append($dropdown);

      // Attach completed control
      $parent.append($newSelect);
    }

  }
})(jQuery, Drupal);
