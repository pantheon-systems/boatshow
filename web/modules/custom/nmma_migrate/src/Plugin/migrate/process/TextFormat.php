<?php

namespace Drupal\nmma_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Set a text format field.
 *
 * @see \Drupal\migrate\Plugin\MigrateProcessInterface
 *
 * @MigrateProcessPlugin(
 *   id = "text_format"
 * )
 */
class TextFormat extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (empty($this->configuration['format'])) {
      $this->configuration['format'] = 'rich_text';
    }
    return ['value' => $value, 'format' => $this->configuration['format']];
  }

}
