<?php

namespace Drupal\nmma_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Set the meta tags.
 *
 * @see \Drupal\migrate\Plugin\MigrateProcessInterface
 *
 * @MigrateProcessPlugin(
 *   id = "meta_tag"
 * )
 */
class MetaTag extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $validKeys = [
      'abstract',
      'canonical_url',
      'content_language',
      'description',
      'generator',
      'geo_placename',
      'geo_position',
      'geo_region',
      'icbm',
      'image_src',
      'keywords',
      'news_keywords',
      'original_source',
      'referrer',
      'rights',
      'robots',
      'set_cookie',
      'shortlink',
      'standout',
      'title',
    ];
    $return = [];
    foreach ($this->configuration as $key => $keyValue) {
      if (in_array($key, $validKeys)) {
        // A source property key was passed, use it's value.
        $sourcePropertyValue = $row->getSourceProperty($keyValue);
        if (NULL !== $sourcePropertyValue) {
          $return[$key] = $sourcePropertyValue;
        }
        // If not a source property key, use as explicit string.
        else {
          $return[$key] = $keyValue;
        }
      }
    }
    return serialize($return);
  }

}
