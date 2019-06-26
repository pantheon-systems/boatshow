(function ($, Drupal) {
  Drupal.behaviors.socialShare = {
    attach: function attach(context, settings) {
      var maxTries = 10;
      var tryIndex = 0;
      var trying;

      if ($(".article-share").length) {
        trying = setInterval(function () {
          if (typeof FB !== "undefined") {
            $(".article-share .facebook").on("click", function (e) {
              e.preventDefault();

              FB.ui({
                method: 'share',
                mobile_iframe: true,
                href: window.location.href,
              }, function(response){});
            });

            clearInterval(trying);
          }
          else {
            if (++tryIndex >= maxTries) {
              clearInterval(trying);
              return;
            }
          }
        }, 500);
      }
    }
  };
})(jQuery, Drupal);
