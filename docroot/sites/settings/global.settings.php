<?php

/**
 * Include settings files in docroot/sites/settings.
 *
 * If instead you want to add settings to a specific site, see BLT's includes
 * file in docroot/sites/{site-name}/settings/default.includes.settings.php.
 */
$additionalSettingsFiles = [
  DRUPAL_ROOT . "/sites/settings/common.settings.php",
  DRUPAL_ROOT . "/sites/" . $site_dir . "/settings/boatshow_site.settings.php"
];

foreach ($additionalSettingsFiles as $settingsFile) {
  if (file_exists($settingsFile)) {
    // phpcs:ignore
    require $settingsFile;
  }
}
