<?php

namespace Drupal\nmma_forms;

use Drupal\marketo_ma\Service\MarketoMaService;
use Psr\Log\LoggerInterface;
use Drupal\marketo_ma\Lead;
use Drupal\Core\Queue\QueueFactory;

/**
 * Create a newsletter submission to Marketo.
 */
class NewsletterSubmission {

  /**
   * The ID of the newsletter static ID in Marketo.
   *
   * @var int
   */
  protected $newsletterMarketoID = 1007;

  /**
   * The Marketo MA service.
   *
   * @var \Drupal\marketo_ma\Service\MarketoMaService
   */
  protected $marketoMaService;

  /**
   * A logger instance.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * The NMMA Marketo MA service.
   *
   * @var \Drupal\nmma_forms\NMMAMarketoMaApiClient
   */
  private $apiClient;

  /**
   * The queue service.
   *
   * @var \Drupal\Core\Queue\QueueFactory
   */
  protected $queueFactory;

  /**
   * Newsletter submission constructor.
   *
   * @param \Drupal\marketo_ma\Service\MarketoMaService $marketo_ma_service
   *   The marketo MA Service.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\nmma_forms\NMMAMarketoMaApiClient $api_client
   *   The marketo ma api client.
   * @param \Drupal\Core\Queue\QueueFactory $queue_factory
   *   The queue service.
   */
  public function __construct(MarketoMaService $marketo_ma_service, LoggerInterface $logger, NMMAMarketoMaApiClient $api_client, QueueFactory $queue_factory) {
    $this->marketoMaService = $marketo_ma_service;
    $this->logger = $logger;
    $this->apiClient = $api_client;
    $this->queueFactory = $queue_factory;
  }

  /**
   * Add a user as a lead and to the newsletter.
   */
  public function submit($email, $first_name = '', $last_name = '', $postal_code = '') {
    $lead = new Lead([
      'email' => $email,
      'firstName' => $first_name,
      'lastName' => $last_name,
      'postalCode' => $postal_code,
    ]);

    $this->marketoMaService->updateLead($lead);
    $newsletter_id_for_marketo = \Drupal::config('nmma_forms.settings')->get('marketo_newsletter_list_id');
    $this->updateListLead($lead->getEmail(), isset($newsletter_id_for_marketo) ? $newsletter_id_for_marketo : 0);
  }

  /**
   * Add an existing lead email address to a list.
   *
   * @return \Drupal\nmma_forms\NewsletterSubmission
   *   Returns itself for chaining.
   */
  public function updateListLead($email, $listId) {
    // Do we need to batch the update?
    if (!$this->marketoMaService->config()->get('rest.batch_requests')) {
      // Just sync the list lead now.
      $this->apiClient->syncListLead($email, $listId);
    }
    else {
      // Queue up the list lead sync.
      $this->queueFactory->get('marketo_ma_list_lead')->createItem(['email' => $email, 'listId' => $listId]);
    }
    return $this;
  }

}
