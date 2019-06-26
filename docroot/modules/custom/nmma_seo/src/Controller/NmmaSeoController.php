<?php

namespace Drupal\nmma_seo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Class StoriesOfDiscovery.
 */
class NmmaSeoController extends ControllerBase {

  /**
   * Node storage.
   *
   * @var \Drupal\node\NodeStorageInterface
   */
  protected $nodeStorage;

  /**
   * CustomPagesController constructor.
   *
   * @param \Drupal\node\NodeStorageInterface $nodeStorage
   *   The node storage.
   */
  public function __construct(NodeStorageInterface $nodeStorage) {
    $this->nodeStorage = $nodeStorage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')->getStorage('node')
    );
  }

  /**
   * Handles redirects for articles.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A redirect.
   */
  public function articles(Request $request, RouteMatchInterface $route_match) {
    $id = $request->get('id');
    if (is_string($id) && strlen($id)) {
      $nids = $this->nodeStorage->getQuery()
        ->condition('type', 'article')
        ->condition('field_article_nmma_id', $id)
        ->range(0, 1)
        ->execute();
    }
    if (!empty($nids)) {
      $nid = reset($nids);
      $response = new RedirectResponse(Url::fromRoute('entity.node.canonical', ['node' => $nid])->toString(), 301);
      return $response;
    }
    // Return a 404. We could send to an article landing page instead, maybe.
    $response = new RedirectResponse(Url::fromRoute('<front>')->toString(), 301);
    return $response;
  }

  /**
   * Handles redirects to the boat finder.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A redirect.
   */
  public function boatFinder(Request $request, RouteMatchInterface $route_match) {
    $response = new RedirectResponse(Url::fromRoute('entity.node.canonical', ['node' => 71])->toString(), 301);
    return $response;
  }

  /**
   * Handles redirects to the accessories page.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A redirect.
   */
  public function accessories(Request $request, RouteMatchInterface $route_match) {
    // @todo This URL does not exist yet, come back to change to the owning/
    // accessories node.
    $response = new RedirectResponse(Url::fromRoute('<front>')->toString(), 301);

    return $response;
  }

  /**
   * Handles redirects to the homepage.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A redirect.
   */
  public function homepage(Request $request, RouteMatchInterface $route_match) {
    $response = new RedirectResponse(Url::fromRoute('<front>')->toString(), 301);
    return $response;
  }

  /**
   * Handles redirects to the brands page.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A redirect.
   */
  public function brands(Request $request, RouteMatchInterface $route_match) {
    $response = new RedirectResponse(Url::fromRoute('entity.node.canonical', ['node' => 17816])->toString(), 301);
    return $response;
  }

  /**
   * Handles redirects to the certified dealers page.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A redirect.
   */
  public function certifiedDealers(Request $request, RouteMatchInterface $route_match) {
    $response = new RedirectResponse(Url::fromRoute('entity.node.canonical', ['node' => 17886])->toString(), 301);
    return $response;
  }

  /**
   * Handles redirects to the articles and resources.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A redirect.
   */
  public function articlesAndResources(Request $request, RouteMatchInterface $route_match) {
    $response = new RedirectResponse(Url::fromRoute('nmma_custom_pages.articles_and_resources')->toString(), 301);
    return $response;
  }

}
