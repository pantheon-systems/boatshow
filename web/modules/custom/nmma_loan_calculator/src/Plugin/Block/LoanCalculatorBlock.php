<?php

namespace Drupal\nmma_loan_calculator\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'LoanCalculatorBlock' block.
 *
 * @Block(
 *  id = "loan_calculator_block",
 *  admin_label = @Translation("Loan Calculator Block"),
 * )
 */
class LoanCalculatorBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = ['#theme' => 'loan_calculator'];

    $build['#attached']['library'][] = 'nmma_loan_calculator/loan_calculator';

    return $build;
  }

}
