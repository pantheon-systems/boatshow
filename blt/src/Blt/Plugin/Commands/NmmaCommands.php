<?php

namespace Example\Blt\Plugin\Commands;

use Acquia\Blt\Robo\BltTasks;

/**
 * Defines commands in the "nmma" namespace.
 */
class NmmaCommands extends BltTasks {

  /**
   * Noop command to override existing commands without throwing errors. Does nothing.
   *
   * @command nmma:noop
   * @description Do nothing
   */
  public function noop() {
    // Do nothing, return nothing
  }

}
