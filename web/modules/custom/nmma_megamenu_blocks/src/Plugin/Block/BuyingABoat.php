<?php

namespace Drupal\nmma_megamenu_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'BuyingABoat' block.
 *
 * @Block(
 *  id = "buying_a_boat",
 *  admin_label = @Translation("Buying A Boat"),
 * )
 */
class BuyingABoat extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'nmma_megamenu_buying_a_boat',
    ];
  }

}
