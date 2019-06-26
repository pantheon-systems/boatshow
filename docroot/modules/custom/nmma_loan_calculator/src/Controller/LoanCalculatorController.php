<?php

namespace Drupal\nmma_loan_calculator\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 */
class LoanCalculatorController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function content() {
    $build = ['#theme' => 'loan_calculator'];

    $build['#attached']['library'][] = 'nmma_loan_calculator/loan_calculator';

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
