<?php

namespace Drupal\nmma_boat_finder\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 */
class BoatFinderController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function content() {
    $build = ['#theme' => 'nmma_boat_finder'];

    $build['#attached']['library'][] = 'knockout/knockout';
    $build['#attached']['library'][] = 'nmma_boat_finder/boatfinder';
    $noindex_meta_tag = [
      '#tag' => 'meta',
      '#attributes' => [
        'name' => 'robots',
        'content' => 'noindex',
      ],
    ];
    $build['#attached']['html_head'][] = [$noindex_meta_tag, 'noindex_embedded'];

    return $build;
  }

}
