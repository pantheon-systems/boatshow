<?php

namespace Drupal\nmma_multinational\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\nmma_multinational\MelissaData\IpLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\nmma_multinational\Content\MultinationalSites;

/**
 * Class IpLocatorController.
 *
 * @package Drupal\nmma_multinational\MelissaData
 */
class IpLocatorController extends ControllerBase {

  /**
   * The IP Locator.
   *
   * @var \Drupal\nmma_multinational\MelissaData\IpLocator
   */
  protected $ipLocator;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The optional cache backend.
   *
   * @var \Drupal\nmma_multinational\Content\MultinationalSites
   */
  protected $multinationalSites;

  /**
   * IpLocatorController constructor.
   *
   * @param \Drupal\nmma_multinational\MelissaData\IpLocator $ipLocator
   *   The node storage.
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *   Current user.
   * @param \Drupal\nmma_multinational\Content\MultinationalSites $multinationalSites
   *   Retrieves multinational site nodes.
   */
  public function __construct(IpLocator $ipLocator, AccountProxyInterface $currentUser, MultinationalSites $multinationalSites) {
    $this->ipLocator = $ipLocator;
    $this->currentUser = $currentUser;
    $this->multinationalSites = $multinationalSites;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('nmma_multinational.ip_locator'),
      $container->get('current_user'),
      $container->get('nmma_multinational.multinational_sites')
    );
  }

  /**
   * Menu callback for 'multinational-message'.
   *
   * Uses melissa data to locate the user's country by IP. Then get the
   * appropriate message for that IP's country.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   JSON that has a property of country.
   *
   * @throws \Exception
   *   If the site retrieval function fails.
   */
  public function multinationalMessage(Request $request, RouteMatchInterface $route_match) {
    $return = ['message' => '', 'redirect_url' => ''];
    $messages = $this->multinationalSites->all();
    // No need to go on if there are no stored messages.
    if (empty($messages)) {
      return new JsonResponse($return);
    }
    $country = '';
    if (!empty($request->get('country')) && $this->currentUser->hasPermission('nmma_multinational bypass')) {
      $country = $request->get('country');
    }
    else {
      if (!empty($request->get('ip')) && $this->currentUser->hasPermission('nmma_multinational bypass')) {
        $ip = $request->get('ip');
      }
      else {
        $ip = $request->getClientIp();
      }
      // $ip = '34.202.122.77'; // US.
      // $ip = '201.138.25.108'; // MX.
      // $ip = '24.37.87.6'; // CA.
      $locationData = $this->ipLocator->ipLocator([$ip]);
      $locationData = current($locationData);
      if (!empty($locationData['CountryAbbreviation'])) {
        $country = $locationData['CountryAbbreviation'];
      }
    }
    // If the user's country matches a message we have, show it.
    if (strlen($country) && isset($messages[$country])) {
      $return['message'] = str_replace(["\r\n"], ["\n"], $messages[$country]['message']);
      $return['redirect_url'] = $messages[$country]['url'];
    }
    return new JsonResponse($return);
  }

}
