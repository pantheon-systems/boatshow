var a2a_config = a2a_config || {};
a2a_config.callbacks = a2a_config.callbacks || [];
a2a_config.callbacks.push({
  share: function(data) {
    if (typeof dataLayer !== 'object') {
      return;
    }
    // Track shares in Google Analytics with Google Tag Manager.
    dataLayer.push({
      'event': 'AddToAnyShare',
      'socialNetwork': 'AddToAny',
      'socialAction': data.service,
      'socialTarget': data.url
    });
  }
});
