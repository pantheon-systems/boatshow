<?php

namespace Drupal\nmma_megamenu_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'OwningABoat' block.
 *
 * @Block(
 *  id = "owning_a_boat",
 *  admin_label = @Translation("Owning A Boat"),
 * )
 */
class OwningABoat extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'nmma_megamenu_owning_a_boat',
    ];
  }

}
