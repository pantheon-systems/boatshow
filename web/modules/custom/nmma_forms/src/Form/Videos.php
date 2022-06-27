<?php

namespace Drupal\nmma_forms\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides the NMMA Articles and Resources search form.
 *
 * @internal
 */
class Videos extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'videos_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['wrapper'] = [
      '#prefix' => '<div class="flex-container">',
      '#suffix' => '</div>',
    ];
    $form['wrapper']['keyword'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keyword Refine'),
      '#placeholder' => $this->t('e.g. Swordfish'),
      '#prefix' => '<div class="col-12-xs col-12-sm col-6-md">',
      '#suffix' => '',
    ];
    $form['wrapper']['submit'] = [
      '#type' => 'submit',
      '#value' => '',
      '#suffix' => '<i class="icon icon-db-arrow-right"></i></div>',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirectUrl($this->getRedirect($form_state->getValue('keyword')));
  }

  /**
   * Get the form redirect.
   *
   * @param string $keyword
   *   The keyword.
   *
   * @return \Drupal\Core\Url
   *   The form redirect.
   */
  protected function getRedirect($keyword) {
    $options = [];
    if (strlen($keyword)) {
      $options['query']['keyword'] = $keyword;
    }
    return Url::fromRoute('<front>', [], $options);
  }

}
