<?php

namespace Drupal\nmma_multinational\MelissaData;

use GuzzleHttp\ClientInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Utility\Error;
use Drupal\Component\Serialization\Json;

/**
 * Class IpLocator.
 *
 * @package Drupal\nmma_multinational\MelissaData
 */
class IpLocator {

  /**
   * The HTTP client to fetch the files with.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  const API_BASE = 'https://globalip.melissadata.net/v4/WEB/';

  const IP_LOCATOR_ENDPOINT = 'iplocation/doiplocation';

  const CUSTOMER_ID = '98902674';

  /**
   * IpLocator constructor.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   A Guzzle client object.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   A logger factory.
   */
  public function __construct(ClientInterface $http_client, LoggerChannelFactoryInterface $loggerFactory) {
    $this->httpClient = $http_client;
    $this->loggerFactory = $loggerFactory;
  }

  /**
   * Return an array of location data keyed by IP address.
   *
   * @param array $ips
   *   IPV4 addresses.
   *
   * @return array
   *   The location data keyed by IP address.
   */
  public function ipLocator(array $ips) {
    $return = [];
    try {
      $records = [];
      foreach ($ips as $key => $ip) {
        $records[] = [
          'RecordID' => 'record_id_' . $key,
          'IPAddress' => $ip,
        ];
      }
      $ref = (string) random_int(0, 9999);
      $response = $this->httpClient->request('POST', $this::API_BASE . $this::IP_LOCATOR_ENDPOINT, [
        'headers' => [
          'Content-Type' => 'application/json',
        ],
        'timeout' => 5,
        'json' => [
          "TransmissionReference" => $ref,
          "CustomerID" => $this::CUSTOMER_ID,
          "Records" => $records,
        ],
      ]);
      if ($response->getStatusCode() === 200) {
        $data = Json::decode($response->getBody()->getContents());
        if (!isset($data['TransmissionReference']) || $data['TransmissionReference'] !== $ref) {
          $this->loggerFactory->get('nmma_multinational')
            ->error("The reference ID given was not returned by the IP locate API.");
          return $return;
        }
        if (empty($data['Records'])) {
          $this->loggerFactory->get('nmma_multinational')
            ->error("Record set was empty for the IP locate API, invalid parameters given probably.");
          return $return;
        }
        else {
          foreach ($data['Records'] as $record) {
            foreach ($ips as $key => $ip) {
              if ($record['RecordID'] === 'record_id_' . $key) {
                $return[$ip] = $record;
              }
            }
          }
        }
      }
      else {
        $variables['@ips'] = implode(', ', $ips);
        $variables['@reason'] = $response->getReasonPhrase() . " (" . $response->getStatusCode() . ")";
        $this->loggerFactory->get('nmma_multinational')
          ->error("A non 200 response occurred when trying to IP locate the following IPS: @ips Reason: @reason.", $variables);
      }
    }
    catch (\Exception $e) {
      $variables = Error::decodeException($e);
      $variables['@ips'] = implode(', ', $ips);
      $this->loggerFactory->get('nmma_multinational')
        ->error("Unable to retrieve location data for IPs: @ips Error: %type: @message in %function (line %line of %file).", $variables);
    }
    return $return;
  }

}
