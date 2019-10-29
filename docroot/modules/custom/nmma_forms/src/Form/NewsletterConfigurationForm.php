<?php

namespace Drupal\nmma_forms\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class NewsletterConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'nmma_forms_newsletter_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'nmma_forms.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $nmma_forms = $this->config('nmma_forms.settings');
    $form['marketo_newsletter_list_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Marketo List ID'),
      '#description' => $this->t('Please enter the list id corresponding to the Marketo'),
      '#default_value' => $nmma_forms->get('marketo_newsletter_list_id'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('nmma_forms.settings')
      ->set('marketo_newsletter_list_id', $values['marketo_newsletter_list_id'])
      ->save();
    parent::submitForm($form, $form_state);
  }

}
