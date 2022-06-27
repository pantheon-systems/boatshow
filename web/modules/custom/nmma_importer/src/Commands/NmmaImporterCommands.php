<?php

namespace Drupal\nmma_importer\Commands;

use Drush\Commands\DrushCommands;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\nmma_importer\Client\NmmaImporterClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Class NmmaImporterCommands.
 *
 * @package Drupal\nmma_importer\Commands
 */
class NmmaImporterCommands extends DrushCommands {

  /**
   * Create a new client.
   *
   * @var nmmaImporterclient
   */
  protected $nmmaImporterClient;

  /**
   * Constructs a new NmmaImporterCommands object.
   */
  public function __construct(NmmaImporterClient $nmmaImporterClient) {
    $this->nmmaImporterClient = $nmmaImporterClient;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('nmma_importer.client')
    );
  }

  /**
   * Refreshes data at nmma endpoint.
   *
   * @param array $options
   *   Option for which request to run.
   *
   * @command nmma_importer:refreshSource
   *
   * @option $type Optional argument to provide specific file updates.
   *
   * @aliases nmma-rs
   *
   * @usage drush nmma-rs
   *   Refresh all remote data from middlware.
   * @usage drush nmma-rs --type=businesses
   *   Refresh only business data.
   * @usage drush nmma-rs --type=youth_program
   *   Refresh only youth program data.
   * @usage drush nmma-rs --type=acc_mfrs
   *   Refresh only accessory manufacturers.
   * @usage drush nmma-rs --type=acc_types
   *   Refresh only accessory types.
   */
  public function refreshSource(array $options = ['type' => 'all']) {

    $endpoint = 'index.php';
    $query['action'] = $options['type'];

    try {

      $result = $this->nmmaImporterClient->connect('get', $endpoint, $query);

    }
    catch (RequestException $e) {
      $this->output->writeln('Unable to refresh ' . $query['action'] . ' data: ' .
        $e->getMessage());
    }
    if ($result == 'Success') {
      $this->output->writeln('Successfully refreshed ' . $query['action'] . ' data.');
    }

  }

}
