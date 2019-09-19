<?php

namespace Drupal\migrate_tools\Plugin\migrate\source;

use Drupal\migrate\Row;

/**
 * Helper to implement \Drupal\migrate_tools\SyncableSourceInterface.
 *
 * The main use case for this trait is for source plugins that are children of
 * \Drupal\migrate\Plugin\migrate\source\SourcePluginBase.
 *
 * It can also be used with other source plugins, but they would need to at
 * least:
 * - Implement aboveHighwater(), fetchNextRow(), getIterator(),
 *   getHighWaterProperty(), rowChanged(), and saveHighWater(), similar to
 *   SourcePluginBase;
 * - Use a currentRow data member with a \Drupal\Migrate\Row value;
 * - Use a currentSourceIds data member with the primary key of the current row;
 * - Use a configuration data member to store plugin configuration; and
 * - Use an idMap data member with a
 *   \Drupal\migrate\Plugin\MigrateIdMapInterface corresponding to the related
 *   migration.
 *
 * An example of a source plugin using the trait can be found at
 * \Drupal\migrate_tools\Plugin\migrate\source\SyncableEmbeddedDataSource
 *
 * Available configuration keys:
 * - all_rows: If set to TRUE, it will return all available source rows. It will
 *   skip other checks, like id map, the need for update, or the highwater flag.
 *
 * @see \Drupal\migrate_tools\Plugin\migrate\source\SyncableEmbeddedDataSource
 */
trait SyncableSourceTrait {

  /**
   * Flags whether to return all available source rows.
   *
   * @var bool
   */
  protected $allRows = FALSE;

  /**
   * Set the $allRows property based on configuration.
   */
  protected function setAllRowsFromConfiguration() {
    if (isset($this->configuration['all_rows'])) {
      $this->allRows = (bool) $this->configuration['all_rows'];
    }
  }

  /**
   * Handles all_rows configuration during \Iterator::next().
   *
   * @see \Drupal\migrate\Plugin\migrate\source\SourcePluginBase::next()
   */
  public function next() {
    $this->currentSourceIds = NULL;
    $this->currentRow = NULL;

    // In order to find the next row we want to process, we ask the source
    // plugin for the next possible row.
    while (!isset($this->currentRow) && $this->getIterator()->valid()) {

      $row_data = $this->getIterator()->current() + $this->configuration;
      $this->fetchNextRow();
      $row = new Row($row_data, $this->getIds());

      // Populate the source key for this row.
      $this->currentSourceIds = $row->getSourceIdValues();

      // Pick up the existing map row, if any, unless fetchNextRow() did it.
      if (!$this->mapRowAdded && ($id_map = $this->idMap->getRowBySource($this->currentSourceIds))) {
        $row->setIdMap($id_map);
      }

      // Clear any previous messages for this row before potentially adding
      // new ones.
      if (!empty($this->currentSourceIds)) {
        $this->idMap->delete($this->currentSourceIds, TRUE);
      }

      // Preparing the row gives source plugins the chance to skip.
      if ($this->prepareRow($row) === FALSE) {
        continue;
      }

      // Check whether the row needs processing.
      // 1. We're supposed to return all rows.
      // 2. This row has not been imported yet.
      // 3. Explicitly set to update.
      // 4. The row is newer than the current highwater mark.
      // 5. If no such property exists then try by checking the hash of the row.
      if ($this->allRows || !$row->getIdMap() || $row->needsUpdate() || $this->aboveHighwater($row) || $this->rowChanged($row)) {
        $this->currentRow = $row->freezeSource();
      }

      if ($this->getHighWaterProperty()) {
        $this->saveHighWater($row->getSourceProperty($this->highWaterProperty['name']));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function sourceIds() {
    $ids = [];
    foreach ($this->idList() as $source_ids) {
      $ids[] = $source_ids;
    }
    return $ids;
  }

  /**
   * Generator for source ids.
   */
  protected function idList() {
    $ids = $this->getIds();
    $iterator = $this->getIterator();
    $iterator->rewind();
    while ($iterator->valid()) {
      yield array_intersect_key($iterator->current(), $ids);
      $iterator->next();
    }
  }

}
