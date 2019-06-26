(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.nmma_multinational_ip_locate_country = {
    attach: function attach(context, settings) {
      if ($('body', context).once('nmma_multinational_ip_locate_country').length > 0) {
        // can we create cookies?
        if (!$.isFunction($.cookie)) {
          return false;
        }
        // If the cookie is set, just stop.
        if (false === Drupal.nmma_multinational.shouldMessageBeShown()) {
          return;
        }
        Drupal.nmma_multinational.showPopIfCountryCanBeFound();
      }
    }
  };

  Drupal.nmma_multinational = {};

  /**
   * Show the popup be shown?
   *
   * @returns {boolean}
   */
  Drupal.nmma_multinational.shouldMessageBeShown = function () {
    var cookieName = drupalSettings.nmma_multinational.cookie_name;
    var cookieCurrentValue = parseInt($.cookie(cookieName));
    return isNaN(cookieCurrentValue) || 1 !== cookieCurrentValue;
  };

  /**
   * Set a cookie so that the message is not shown again.
   */
  Drupal.nmma_multinational.supressFutureMessages = function() {
    var path = drupalSettings.path.baseUrl;
    var cookieName = drupalSettings.nmma_multinational.cookie_name;
    var cookieSession = parseInt(drupalSettings.nmma_multinational.cookie_session);
    var cookieValue = 1;
    if (cookieSession) {
      $.cookie(cookieName, cookieValue, { path: path });
    } else {
      var lifetime = parseInt(drupalSettings.nmma_multinational.cookie_lifetime);
      var date = new Date();
      date.setDate(date.getDate() + lifetime);
      $.cookie(cookieName, cookieValue, { expires: date, path: path });
    }
  };

  /**
   * Parse a query string into variables.
   *
   * @param qs
   */
  Drupal.nmma_multinational.getQueryParams = function(qs) {
    qs = qs.split("+").join(" ");
    var params = {},
      tokens,
      re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
      params[decodeURIComponent(tokens[1])]
        = decodeURIComponent(tokens[2]);
    }

    return params;
  };

  /**
   * Determine if the current user is from a country there is a message for.
   */
  Drupal.nmma_multinational.showPopIfCountryCanBeFound = function() {
    // Allow admin users to set explicit country or IP.
    var queryParams = Drupal.nmma_multinational.getQueryParams(document.location.search);
    var queryString = '';
    if (queryParams.hasOwnProperty('country')) {
      queryString = '?country=' + queryParams.country;
    }
    else if (queryParams.hasOwnProperty('ip')) {
      queryString = '?ip=' + queryParams.ip;
    }
    $.ajax({
      type: 'POST',
      url: drupalSettings.nmma_multinational.end_point + queryString,
      success: function(data, textStatus, jqXHR) {
        // Show the pop-up.
        if (data.hasOwnProperty('message') && data.message.length && data.hasOwnProperty('redirect_url') && data.redirect_url.length) {
          if (confirm(data.message)) {
            window.location = data.redirect_url;
          }
        }
      },
      complete: function(textStatus, jqXHR) {
        // Make sure the pop-up never happens again.
        Drupal.nmma_multinational.supressFutureMessages();
      },
      dataType: 'json'
    });
  };

})(jQuery, Drupal, drupalSettings);
