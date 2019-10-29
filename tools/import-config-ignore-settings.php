<?php
//https://gist.github.com/mikecrittenden/2d2c6734c506d509505fa79142125757

// Or, import YAML config an arbitrary directory.
global $config_directories;
$config_path = $config_directories[CONFIG_SYNC_DIRECTORY];

$source = new \Drupal\Core\Config\FileStorage($config_path);
$config_storage = \Drupal::service('config.storage');

$config_storage->write('config_ignore.settings', $source->read('config_ignore.settings'));
