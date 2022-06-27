<?php

namespace Drupal\nmma_megamenu\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'MegaMenu' block.
 *
 * @Block(
 *  id = "mega_menu",
 *  admin_label = @Translation("Mega Menu"),
 * )
 */
class MegaMenu extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = ['#theme' => 'nmma_megamenu'];

    $build['#attached']['library'][] = 'nmma_megamenu/megamenu';

    return $build;
  }

}
