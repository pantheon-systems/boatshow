<?php

/**
 * Multisite variables.
 */
$settings['boatshow.city.key'] = 'nashville';
$settings['boatshow.city.searchId'] = '31';

$config['system.site']['name'] = 'Nashville Boat Show';
$config['gtm.settings']['google-tag'] = 'GTM-NLZJRW5';

/**
 * Location of the site configuration files.
 */
$config_directories = [
  CONFIG_SYNC_DIRECTORY => DRUPAL_ROOT . "/../config/nashville"
];

/**
 * Private file path.
 */
$settings['file_private_path'] = DRUPAL_ROOT . '/../files-private/nashville';

/**
 * Load multisite configuration, if available.
 */
if (file_exists('/var/www/site-php')) {
  require '/var/www/site-php/boatshow/nashville-settings.inc';
}
