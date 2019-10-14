<?php

namespace Example\Blt\Plugin\Commands;

use Acquia\Blt\Robo\BltTasks;
use Acquia\Blt\Robo\Commands\Sync\SyncCommand;

/**
 * Defines commands in the "nmma" namespace.
 */
class NmmaSyncCommands extends SyncCommand {

  /**
   * Synchronize each multisite.
   *
   * @command nmma:sync-all
   * @executeInVm
   */
  public function allSites($options = [
    'sync-files' => FALSE,
  ]) {
    $multisites = $this->getConfigValue('multisites');
    $this->printSyncMap($multisites);
    $continue = $this->confirm("Continue?", TRUE);
    if (!$continue) {
      return 0;
    }
    foreach ($multisites as $multisite) {
      $this->say("Refreshing site <comment>$multisite</comment>...");
      $this->switchSiteContext($multisite);
      $this->sync([
        'sync-files' => $options['sync-files']
      ]);
    }
  }

  /**
   * Synchronize single multisite.
   *
   * @command nmma:sync
   * @executeInVm
   */
  public function sync($options = [
    'sync-files' => FALSE,
  ]) {
    parent::sync($options);
  }
}
