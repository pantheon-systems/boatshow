<?php

namespace Drupal\nmma_tickets\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class TicketsConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'nmma_tickets_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'nmma_tickets.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $nmma_tickets = $this->config('nmma_tickets.settings');
    $form['interactive_ticketing_note'] = array(
      '#markup' => '<p>You must obtain the ticeting information
      from <a href="https://secure.interactiveticketing.com/dashboard/#event">https://secure.interactiveticketing.com/dashboard/#event</a>.
      Login credentials are required  to access the backend of Interactive Ticketing.</p>',

      );
    $form['ticket_url_path'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Ticket Url Path'),
      '#description' => $this->t('Please enter the Ticket Path URL pulled in from the Interactive Ticketing code. (i.e. 1.30/a5921f/api/v31/embed.js?cn=it-b6f6a)'),
      '#default_value' => $nmma_tickets->get('ticket_url_path'),
    ];
    $form['ticket_id'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Ticket ID'),
      '#description' => $this->t('Please enter the Ticket ID pulled in from the Interactive Ticketing code. (i.e.  it-b6f6a)'),
      '#default_value' => $nmma_tickets->get('ticket_id'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('nmma_tickets.settings')
      ->set('ticket_url_path', $values['ticket_url_path'])
      ->set('ticket_id', $values['ticket_id'])
      ->save();
    parent::submitForm($form, $form_state);
  }

}
