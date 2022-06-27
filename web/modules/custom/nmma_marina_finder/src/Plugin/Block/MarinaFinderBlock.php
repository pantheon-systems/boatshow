<?php

namespace Drupal\nmma_marina_finder\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'MarinaFinderBlock' block.
 *
 * @Block(
 *  id = "marina_finder_block",
 *  admin_label = @Translation("Marina Finder Block"),
 * )
 */
class MarinaFinderBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = ['#theme' => 'marina_finder'];

    return $build;
  }

}
