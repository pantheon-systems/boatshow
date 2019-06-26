(function ($, Drupal) {
  var drawerWrapper = $("<div class='js-boat-brand-drawer-container boat-brand__drawer-container' />");

  var getScreen = function () {
    var screen = "xs";

    // Mobile and Above
    if (window.matchMedia('(min-width: 576px)').matches) {
      screen = "sm";
    }

    // Tablet and Above
    if (window.matchMedia('(min-width: 768px)').matches) {
      screen = "md";
    }

    return screen;
  }

  var closeContainer = function () {
    $(".js-boat-brand-drawer-container").slideUp(function () { $(this).remove() });
    $(".js-boat-brand-item").removeClass("active");
  }

  Drupal.behaviors.brandGrid = {
    attach: function attach(context, settings) {
      var allItems = $(".js-boat-brand-item").eq(0).closest("[class*=col-]").parent().children("[class*=col-]");

      $('.js-boat-brand-item').once().click(function (e) {
        e.preventDefault();
        var target = $(e.target).closest(".js-boat-brand-item");
        var dataIndex = target.attr("data-index").replace(/<!--(.*?)-->/g, "").trim();
        var content = $(".js-boat-brand-drawer-content[data-index='" + dataIndex + "']").clone().removeAttr("data-index");
        var item = target.closest("[class*=col-]");
        var rowEnd = item;
        var container;
        var i = item.index();


        if (content.length) {
          $(".js-boat-brand-item").removeClass("active");

          switch (getScreen()) {
            case "sm":
              rowEnd = allItems.eq(i + (1 - i % 2));
              break;
            case "md":
              rowEnd = allItems.eq(i + (3 - i % 4));
              break;
          }
          if (!rowEnd.length) {
            rowEnd = allItems.last();
          }

          if (rowEnd.next().hasClass("js-boat-brand-drawer-container")) {
            container = rowEnd.next();
            container.empty();
          }
          else {
            closeContainer();
            container = drawerWrapper.clone();
          }

          content.find(".close").on("click", function (e) { e.preventDefault(); closeContainer(); });

          container.html(content);
          container.insertAfter(rowEnd).slideDown();
          target.addClass("active");
        }
        var thisOffset
        var getOffset = function() {
          thisOffset = container.offset().top;
          jQuery('html, body').animate({
            scrollTop: thisOffset - 220
          }, 400);
        }
        setTimeout(getOffset, 400);
      });
    }
  };
})(jQuery, Drupal);
