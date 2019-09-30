<?php

namespace Drupal\nmma_forms\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'NewsletterFormBlock' block.
 *
 * @Block(
 *  id = "newsletter_form_block",
 *  admin_label = @Translation("Newsletter form block"),
 *  category = @Translation("Custom")
 * )
 */
class NewsletterFormBlock extends BlockBase  {


  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\nmma_forms\Form\Newsletter');
    return $form;
  }

}
