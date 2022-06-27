<?php

namespace Drupal\nmma_importer;

/**
 * Interface NmmaImporterClientInterface.
 *
 * @package Drupal\nmma_importer
 */
interface NmmaImporterClientInterface {

  /**
   * Interface for client class.
   *
   * @param string $method
   *   get, post, patch, delete, etc. See Guzzle documentation.
   * @param string $endpoint
   *   The NMMA Middleware endpoint.
   * @param array $query
   *   Query string parameters the endpoint allows.
   * @param array $body
   *   (converted to JSON)
   *   Utilized for some endpoints.
   *
   * @return object
   *   \GuzzleHttp\Psr7\Response body
   */
  public function connect($method, $endpoint, array $query, array $body);

}
