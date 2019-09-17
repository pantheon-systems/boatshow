<?php

namespace Drupal\nmma_forms\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Url;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\nmma_forms\NewsletterSubmission;

/**
 * Provides the NMMA Newsletter filter form.
 *
 * @internal
 */
class Newsletter extends FormBase {

  /**
   * Allows access to messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The newsletter submission service.
   *
   * @var \Drupal\nmma_forms\NewsletterSubmission
   */
  protected $newsletterSubmission;

  /**
   * Newsletter constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\nmma_forms\NewsletterSubmission $newsletter_submission
   *   The newsletter submission service.
   */
  public function __construct(MessengerInterface $messenger, NewsletterSubmission $newsletter_submission) {
    $this->messenger = $messenger;
    $this->newsletterSubmission = $newsletter_submission;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('nmma_forms.newsletter_submission')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'newsletter_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#prefix'] = '<div id="email-field-display-overview-wrapper">';
    $form['#suffix'] = '</div>';
    $form['newsletterEmail'] = [
      '#type' => 'email',
      '#placeholder' => $this->t('Email Address'),
      '#required' => TRUE,
      '#prefix' => '<div class="submit-input-field--clear">',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => '',
      '#suffix' => '<i class="icon icon-db-arrow-right" data-gtm-tracking="Newsletter Sign Up - Submit - Footer"></i></div>',
      '#attributes' => ['data-gtm-tracking' => 'Newsletter Sign Up - Submit - Footer'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('newsletterEmail') == 'test@test.com') {
      $form_state->setErrorByName('newsletterEmail', $this->t('This is a test validation error.'));
    }
    // Not needed, as email validator is already added to this.
    // See Drupal\Core\Render\Element\Email::validateEmail().
    if ($form_state->isValueEmpty('newsletterEmail')) {
      $form_state->setErrorByName('newsletterEmail', $this->t('Email address is required.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Add the email as a lead and to the newsletter list in Marketo.
    $this->newsletterSubmission->submit($form_state->getValue('newsletterEmail'));
    $form_state->setRedirectUrl($this->getRedirect());
  }

  /**
   * Ajax form callback.
   *
   * @param array $form
   *   The form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current form state.
   *
   * @return array|AjaxResponse
   *   The modified form or a redirect.
   */
  public function ajaxCallback(array $form, FormStateInterface $form_state) {
    $emailError = $form_state->getError($form['newsletterEmail']);
    if (!empty($emailError)) {
      $form['error'] = [
        '#type' => 'markup',
        // This mimics the client side validation error so that double errors
        // are not created.
        '#markup' => sprintf('<label id="%s-error" class="error" for="%s">%s</label>', $form['newsletterEmail']['#id'], $form['newsletterEmail']['#id'], 'This field does not contain a valid email.'),
        '#allowed_tags' => ['label'],
        '#weight' => 99,
      ];
      // Remove the errors from the messages.
      $this->messenger()->deleteAll();
    }
    else {
      $response = new AjaxResponse();
      $response->addCommand(new RedirectCommand($this->getRedirect()->toString()));
      return $response;
    }
    return $form;
  }

  /**
   * Get the form redirect.
   *
   * @return \Drupal\Core\Url
   *   The form redirect.
   */
  protected function getRedirect() {
    return Url::fromRoute('entity.node.canonical', ['node' => 28096]);
  }
}
