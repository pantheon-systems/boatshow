<?php

namespace Drupal\nmma_seo\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Path\AliasManagerInterface;
use Drupal\Core\State\StateInterface;

/**
 * Class Redirect.
 *
 * @package Drupal\nmma_seo\EventSubscriber
 */
class Redirect implements EventSubscriberInterface {

  /**
   * The currently active route match object.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The path alias manager.
   *
   * @var \Drupal\Core\Path\AliasManagerInterface
   */
  protected $aliasManager;

  /**
   * The state manager.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Redirect constructor.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $routeMatch
   *   The currently active route match object.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Path\AliasManagerInterface $alias_manager
   *   The path alias manager.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state manager.
   */
  public function __construct(RouteMatchInterface $routeMatch, EntityTypeManagerInterface $entity_type_manager, AliasManagerInterface $alias_manager, StateInterface $state) {
    $this->routeMatch = $routeMatch;
    $this->entityTypeManager = $entity_type_manager;
    $this->aliasManager = $alias_manager;
    $this->state = $state;
  }

  /**
   * Check to see if we need to redirect.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The response event.
   */
  public function checkForRedirection(FilterResponseEvent $event) {
    if ($this->routeMatch->getRouteName() === 'view.search.page' && !empty($event->getRequest()->query->get('q'))) {
      $event->setResponse(new RedirectResponse(Url::fromRoute('<front>')->toString(), '301'));
    }
    elseif ($this->routeMatch->getRouteName() === 'system.404') {
      $path = array_values(array_filter(explode('/', $event->getRequest()->getRequestUri())));
      if (count($path) === 1) {
        $cached_aliases = $this->state->get('nmma_seo.article_aliases');
        if (NULL === $cached_aliases) {
          $nodeStorage = $this->entityTypeManager->getStorage('node');
          $query = $nodeStorage->getQuery()->condition('type', 'article');
          $nids = $query->execute();
          $cached_aliases = [];
          foreach ($nids as $nid) {
            $alias = $this->aliasManager->getAliasByPath('/node/' . $nid);
            $alias = array_values(array_filter(explode('/', $alias)));
            if (count($alias) === 2 && $alias[0] === 'resources') {
              $cached_aliases[] = $alias[1];
            }
          }
          $this->state->set('nmma_seo.article_aliases', $cached_aliases);
        }
        $key = array_search($path[0], $cached_aliases);
        if (FALSE !== $key) {
          $event->setResponse(new RedirectResponse('/resources/' . $cached_aliases[$key], '301'));
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['checkForRedirection'];
    return $events;
  }

}
