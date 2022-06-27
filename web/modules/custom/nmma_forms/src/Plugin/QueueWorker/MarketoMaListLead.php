<?php

namespace Drupal\nmma_forms\Plugin\QueueWorker;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\nmma_forms\NMMAMarketoMaApiClient;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Updates Marketo lead.
 *
 * @QueueWorker(
 *   id = "marketo_ma_list_lead",
 *   title = @Translation("Marketo MA List Lead"),
 *   cron = {"time" = 60}
 * )
 */
class MarketoMaListLead extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * The NMMA Marketo MA API Client.
   *
   * @var \Drupal\nmma_forms\NMMAMarketoMaApiClient
   */
  protected $apiClient;

  /**
   * Constructs a Drupal\Component\Plugin\PluginBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\nmma_forms\NMMAMarketoMaApiClient $api_client
   *   The marketo API client.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, NMMAMarketoMaApiClient $api_client = NULL) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->apiClient = $api_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('nmma_marketo_ma.api_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    // Use the API service to sync the lead.
    $this->apiClient->syncListLead($data['email'], $data['listId']);
  }

}
