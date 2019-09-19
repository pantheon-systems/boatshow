<?php

namespace Drupal\migrate_tools;

/**
 * Interface SyncableSourceInterface.
 *
 * Migrate source plugins can implement this interface in order to synchronize
 * migrated content with the source. That is, migrated content can be added,
 * updated, or removed to match the source.
 *
 * @package Drupal\migrate\Plugin
 */
interface SyncableSourceInterface {

  /**
   * Returns all source ids.
   *
   * @return array
   *   The source id fields and their values.
   */
  public function sourceIds();

}
