<?php

namespace Drupal\nmma_custom_pages\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class Embedded.
 *
 * @package Drupal\nmma_seo\EventSubscriber
 */
class Embedded implements EventSubscriberInterface {

  /**
   * The currently active route match object.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Redirect constructor.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $routeMatch
   *   The currently active route match object.
   */
  public function __construct(RouteMatchInterface $routeMatch) {
    $this->routeMatch = $routeMatch;
  }

  /**
   * Allow a page to be used in an iframe on another site.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The filtered response event object.
   */
  public function embeddedPage(FilterResponseEvent $event) {
    switch ($this->routeMatch->getRouteName()) {
      case 'nmma_boat_finder.content':
      case 'nmma_loan_calculator.content':
        $response = $event->getResponse();
        $response->headers->remove('X-Frame-Options');
        break;

    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['embeddedPage', -10];
    return $events;
  }

}
