(function ($, Drupal) {
  Drupal.behaviors.nmma_seo_data_layer_onread = {
    attach: function attach(context, settings) {
      if ($('body', context).once('nmma_seo_data_layer_onread').length > 0) {
        if (
            'object' === typeof settings.nmmaSeo &&
            'object' === typeof settings.nmmaSeo.dataLayerOnready &&
            'string' === typeof settings.nmmaSeo.dataLayerOnready.data_layer_name &&
            settings.nmmaSeo.dataLayerOnready.data_layer_name.length > 0 &&
            'object' === typeof settings.nmmaSeo.dataLayerOnready.values &&
            settings.nmmaSeo.dataLayerOnready.values.length > 0
        ) {
          // Push each pair into the data layer.
          $.each(settings.nmmaSeo.dataLayerOnready.values, function (key, value) {
            window[settings.nmmaSeo.dataLayerOnready.data_layer_name].push(value);
          });
        }
      }
    }
  };
})(jQuery, Drupal);
