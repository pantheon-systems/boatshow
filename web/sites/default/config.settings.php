<?php

// phpcs:ignore
if (!isset($blt_override_config_directories)) {
  $blt_override_config_directories = TRUE;
}

// Configuration directories.
if ($blt_override_config_directories) {
  // phpcs:ignore
  $config_directories['sync'] = __DIR__ . "/config/default";
  // phpcs:ignore
  $settings['config_sync_directory'] = __DIR__ . "/config/default";
}

$split_filename_prefix = 'config_split.config_split';
if (isset($config_directories['sync'])) {
  $split_filepath_prefix = $config_directories['sync'] . '/' . $split_filename_prefix;
}
else {
  $split_filepath_prefix = $settings['config_sync_directory'] . '/' . $split_filename_prefix;
}

/**
 * Set environment splits.
 */
$split_envs = [
  'local',
  'dev',
  'stage',
  'prod',
  'ci',
  'ah_other',
];

// Disable all split by default.
foreach ($split_envs as $split_env) {
  $config["$split_filename_prefix.$split_env"]['status'] = FALSE;
}

// Enable env splits.
// Do not set $split unless it is unset. This allows prior scripts to set it.
// phpcs:ignore
if (!isset($split)) {
  $split = 'none';

  // Local envs.
  if (EnvironmentDetector::isLocalEnv()) {
    $split = 'local';
  }
  // CI envs.
  if (EnvironmentDetector::isCiEnv()) {
    $split = 'ci';
  }
  // Acquia only envs.
  if (EnvironmentDetector::isAhEnv()) {
    $config_directories['vcs'] = $config_directories['sync'];
    $split = 'ah_other';
  }

  if (EnvironmentDetector::isDevEnv() || EnvironmentDetector::isAhOdeEnv()) {
    $split = 'dev';
  }
  elseif (EnvironmentDetector::isStageEnv()) {
    $split = 'stage';
  }
  elseif (EnvironmentDetector::isProdEnv()) {
    $split = 'prod';
  }
}

// Enable the environment split only if it exists.
if ($split != 'none') {
  $config["$split_filename_prefix.$split"]['status'] = TRUE;
}

/**
 * Set multisite split.
 */
// phpcs:ignore
$config["$split_filename_prefix.$site_dir"]['status'] = TRUE;

// Set acsf site split if explicit global exists.
global $_acsf_site_name;
if (isset($_acsf_site_name)) {
  $config["$split_filename_prefix.$_acsf_site_name"]['status'] = TRUE;
}
