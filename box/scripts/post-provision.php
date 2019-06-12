#!/usr/bin/env php
<?php
/**
 * @file
 * Settings.php file is writable while inside a local development environment.
 */

foreach ([
  '/var/www/nmma/docroot/sites/default' => '0755',
  '/var/www/nmma/docroot/sites/default/settings.php' => '644',
] as $filename => $mode) {
  if (file_exists($filename)) {
    if (FALSE === chmod($filename, octdec($mode))) {
      $errors[] = "Unable to change permissions on $filename to $mode\n";
    }
  }
}
if (!empty($errors)) {
  foreach ($errors as $error) {
    echo $error;
  }
  exit(1);
}
