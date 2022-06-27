<?php

namespace Drupal\nmma_go_boating_map\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides the NMMA Go Boating Inline form.
 *
 * @internal
 */
class GoBoatingInline extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'go_boating_inline';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['zipcode'] = [
      '#prefix' => '<div class="submit-input-field">',
      '#type' => 'textfield',
      '#placeholder' => $this->t('Enter Zipcode'),
      '#attributes' => ['onkeyup' => "jQuery('.goboatinginline-gtm').attr('data-gtm-tracking', 'Boat Rental Search - Search by Entry - ' + this.value);"],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => '',
      '#suffix' => '<i class="icon icon-db-arrow-right goboatinginline-gtm" data-gtm-tracking="Boat Rental Search - Search by Entry - "></i></div>',
      '#attributes' => ['class' => ['goboatinginline-gtm'], 'data-gtm-tracking' => 'Boat Rental Search - Search by Entry - '],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $route_parmameters = ['node' => 61];
    $zipcode = $form_state->getValue('zipcode');
    if (strlen($zipcode)) {
      $route_parmameters['zipcode'] = $zipcode;
    }
    $form_state->setRedirectUrl(Url::fromRoute('entity.node.canonical', $route_parmameters));
  }

}
