<?php

namespace Drupal\migrate_tools\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Plugin\migrate\source\EmbeddedDataSource;
use Drupal\migrate_tools\SyncableSourceInterface;

/**
 * A syncable embedded data source using SyncableSourceTrait.
 *
 * @see Drupal\migrate\Plugin\migrate\source\EmbeddedDataSource
 *
 * @MigrateSource(
 *   id = "syncable_embedded_data",
 *   source_module = "migrate_tools"
 * )
 */
class SyncableEmbeddedDataSource extends EmbeddedDataSource implements SyncableSourceInterface {

  use SyncableSourceTrait;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);
    $this->setAllRowsFromConfiguration();
  }

}
