<?php

namespace Drupal\nmma_go_boating_map\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'BoatingMapBlock' block.
 *
 * @Block(
 *  id = "go_boating_map_block",
 *  admin_label = @Translation("Go Boating Map Block"),
 * )
 */
class BoatingMapBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = ['#theme' => 'boating_map'];

    $build['#attached']['library'][] = 'nmma_go_boating_map/google_maps';
    $build['#attached']['library'][] = 'knockout/knockout';
    $build['#attached']['library'][] = 'nmma_go_boating_map/boating_map';

    return $build;
  }

}
