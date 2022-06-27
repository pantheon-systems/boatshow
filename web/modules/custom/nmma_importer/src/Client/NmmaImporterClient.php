<?php

namespace Drupal\nmma_importer\Client;

use Drupal\nmma_importer\NmmaImporterClientInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Drupal\Core\Site\Settings;

/**
 * Class NmmaImporterClient.
 *
 * @package Drupal\nmma_importer\Client
 */
class NmmaImporterClient implements NmmaImporterClientInterface {

  /**
   * An http client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Base middleware URL to query.
   *
   * @var string
   */
  protected $baseurl;

  /**
   * Authorization string.
   *
   * @var string
   */
  protected $auth;

  /**
   * NmmaImporterCommands constructor.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   Http_client instance.
   */
  public function __construct(ClientInterface $http_client) {
    $this->httpClient = $http_client;
    $this->baseurl = Settings::get('middlewareIP') . '/middleware/';
    $this->auth = Settings::get('middlewareHash');
  }

  /**
   * Connect to endpoint.
   *
   * @param string $method
   *   Get, post, etc.
   * @param string $endpoint
   *   Rest endpoint.
   * @param array $query
   *   Various query values.
   * @param array $body
   *   Body as needed.
   *
   * @return string
   *   Result value.
   */
  public function connect(
    $method = 'get',
    $endpoint = 'index.php',
    array $query = ['action' => 'all'],
    array $body = []
  ) {
    try {

      $response = $this->httpClient->{$method}(
        $this->baseurl . $endpoint,
        $this->buildOptions($query, $body)
      );
      \Drupal::logger('nmma_importer')->notice('Connected to NMMA Api.');
    }
    catch (RequestException $exception) {
      \Drupal::logger('nmma_importer')
        ->error('Failed to complete middleware request. "%error"', ['%error' => $exception->getMessage()]);
      return FALSE;
    }

    $body = $response->getBody()->getContents();
    $data = json_decode($body);
    return $data->message;
  }

  /**
   * Build options for the client.
   */
  private function buildOptions(array $query, $body) {
    $options = [];
    $options['query']['auth'] = $this->auth;
    if ($body) {
      $options['body'] = $body;
    }
    if ($query) {
      foreach ($query as $key => $value) {
        $options['query'][$key] = $value;
      }
    }

    return $options;
  }

}
