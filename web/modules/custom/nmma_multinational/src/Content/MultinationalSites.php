<?php

namespace Drupal\nmma_multinational\Content;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\nmma_custom_pages\EntityHelp;

/**
 * Class MultinationalSites.
 *
 * @package Drupal\nmma_multinational\Content
 */
class MultinationalSites {

  /**
   * Access nodes entities.
   *
   * @var \Drupal\node\NodeStorage
   */
  protected $nodeStorage;

  /**
   * A logger factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * The optional cache backend.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cache;

  /**
   * MultinationalSites constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   The entity type manager.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   A logger factory.
   * @param \Drupal\Core\Cache\CacheBackendInterface|null $cache
   *   (optional) A cache bin for storing fetched instagram posts.
   */
  public function __construct(EntityTypeManagerInterface $entity_manager, LoggerChannelFactoryInterface $loggerFactory, CacheBackendInterface $cache = NULL) {
    $this->nodeStorage = $entity_manager->getStorage('node');
    $this->loggerFactory = $loggerFactory;
    $this->cache = $cache;
  }

  /**
   * Retrieve all possible messages / redirects keyed by country.
   *
   * @return array
   *   All the multinational sites nodes.
   *
   * @throws \Exception
   *   Invalid fields exception.
   */
  public function all() {
    $data = [];
    $cacheKey = 'MultinationalSitesAll';
    if ($this->cache && $cached_all = $this->cache->get($cacheKey)) {
      return $cached_all->data;
    }

    $query = $this->nodeStorage->getQuery()
      ->condition('status', 1)
      ->condition('type', 'multinational_site');
    $nids = $query->execute();
    if (!empty($nids)) {
      foreach ($this->nodeStorage->loadMultiple($nids) as $node) {
        $node = _nmma_multinational_ensure_content($node);
        $country = EntityHelp::getTextValue($node, 'field_multinational_country');
        $message = EntityHelp::getTextValue($node, 'field_multinational_message');
        $url = EntityHelp::getLinkUri($node, 'field_multinational_url');
        if (!empty($country) && !empty($message) && !empty($url)) {
          $data[$country] = ['message' => $message, 'url' => $url];
        }
      }
    }

    // If we have a cache, store the response for future use. The cache tag
    // 'node_list' will invalidate this cache key whenever any node is
    // modified or created. Bundle type tags are not available yet
    // https://www.drupal.org/node/2145751.
    if ($this->cache) {
      $this->cache->set($cacheKey, $data, Cache::PERMANENT, ['node_list']);
    }
    return $data;
  }

}
