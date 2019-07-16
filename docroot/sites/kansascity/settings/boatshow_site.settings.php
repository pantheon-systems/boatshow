<?php

/**
 * Multisite variables.
 */
$settings['boatshow.city.key'] = 'kansascity';
$settings['boatshow.city.searchId'] = '30';

$config['system.site']['name'] = 'Kansas City Boat Show';
$config['gtm.settings']['google-tag'] = 'GTM-KZL2LRS';

/**
 * Location of the site configuration files.
 */
$config_directories = [
  CONFIG_SYNC_DIRECTORY => DRUPAL_ROOT . "/../config/kansascity"
];

/**
 * Private file path.
 */
$settings['file_private_path'] = DRUPAL_ROOT . '/../files-private/kansascity';

/**
 * Load multisite configuration, if available.
 */
if (file_exists('/var/www/site-php')) {
  require '/var/www/site-php/boatshow/kansascity-settings.inc';
}
