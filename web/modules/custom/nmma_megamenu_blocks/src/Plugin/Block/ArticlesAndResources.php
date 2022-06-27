<?php

namespace Drupal\nmma_megamenu_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'ArticlesAndResources' block.
 *
 * @Block(
 *  id = "articles_and_resources",
 *  admin_label = @Translation("Articles_and_resources"),
 * )
 */
class ArticlesAndResources extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'nmma_megamenu_articles_and_resources',
    ];
  }

}
