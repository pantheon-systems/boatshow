<?php

namespace Drupal\nmma_custom_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Controller\TitleResolver;
use Drupal\Core\Controller\TitleResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\Core\Url;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Class StoriesOfDiscovery.
 */
class CustomPagesController extends ControllerBase {

  /**
   * Node storage.
   *
   * @var \Drupal\node\NodeStorageInterface
   */
  protected $nodeStorage;

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * The title resolver service.
   *
   * @var \Drupal\Core\Controller\TitleResolverInterface
   */
  protected $titleResolver;

  /**
   * CustomPagesController constructor.
   *
   * @param \Drupal\node\NodeStorageInterface $nodeStorage
   *   The node storage.
   * @param \Drupal\Core\Form\FormBuilderInterface $formBuilder
   *   The form builder.
   * @param \Drupal\Core\Controller\TitleResolverInterface $titleResolver
   *   The title resolver service.
   */
  public function __construct(NodeStorageInterface $nodeStorage, FormBuilderInterface $formBuilder, TitleResolverInterface $titleResolver) {
    $this->nodeStorage = $nodeStorage;
    $this->formBuilder = $formBuilder;
    $this->titleResolver = $titleResolver;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')->getStorage('node'),
      $container->get('form_builder'),
      $container->get('title_resolver')
    );
  }

  /**
   * Menu callback for 'storiesofdiscovery'.
   *
   * This is a clone of https://www.discoverboating.com/storiesofdiscovery.
   * The dom for the non-header/footer portions is now stored in
   * templates/stores-of-discovery.html.twig. The images were saved locally in
   * assets/sod.
   */
  public function storiesOfDiscovery() {
    return ['page' => ['#theme' => 'stories_of_discovery']];
  }

  /**
   * Menu callback for 'articles-and-resources'.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return array
   *   A renderable array.
   */
  public function articlesAndResources(Request $request, RouteMatchInterface $route_match) {
    $content = [];

    // Retrieve all the data for the page.
    $video_library = $this->nodeStorage->getQuery()
      ->condition('type', 'video')
      ->condition('status', 1)
      ->sort('created', 'DESC')
      ->range(0, 2)
      ->execute();

    $featured = $this->nodeStorage->getQuery()
      ->condition('field_article_featured', 1)
      ->condition('type', 'article')
      ->condition('status', 1)
      ->sort('created', 'DESC')
      ->range(0, 1)
      ->execute();

    $most_popular = $this->nodeStorage->getQuery()
      ->condition('field_article_popular', 1)
      ->condition('type', 'article')
      ->condition('status', 1)
      ->sort('created', 'DESC')
      ->range(0, 2)
      ->execute();

    // This is the normal amount of articles and videos if there is a featured
    // article, video library, and most popular.
    $articles_and_videos_count = 7;
    if (empty($featured) && !empty($video_library)) {
      $articles_and_videos_count += 2;
    }
    if (empty($most_popular)) {
      $articles_and_videos_count++;
    }

    $articles_and_videos = $this->nodeStorage->getQuery()
      ->condition('type', ['article', 'video'], 'in')
      ->condition('nid', $featured, 'NOT IN')
      ->condition('status', 1)
      ->sort('created', 'DESC')
      ->range(0, $articles_and_videos_count)
      ->execute();

    $rowCnt = 1;
    $itemsPerRow = [$rowCnt => 0];
    if (!empty($featured)) {
      $featured_article = $this->nodeStorage->load(reset($featured));
      $content['row' . $rowCnt]['#content'][] = [
        '#theme' => 'article_block_large',
        '#entity' => $featured_article,
        // If there are no videos, span the entire page.
        '#full' => empty($video_library),
      ];
      $itemsPerRow[$rowCnt] += empty($video_library) ? 3 : 2;
    }

    if (!empty($video_library)) {
      $video_entities = $this->nodeStorage->loadMultiple($video_library);
      $content['row' . $rowCnt]['#content'][] = [
        '#theme' => 'article_block_stack',
        '#entities' => $video_entities,
        '#title' => $this->t('From the'),
        '#link_text' => 'Video Library',
        '#link_url' => Url::fromRoute('entity.node.canonical', ['node' => '17896'])->toString(),
      ];
      $itemsPerRow[$rowCnt]++;
    }

    foreach ($articles_and_videos as $article_and_video) {
      if ($itemsPerRow[$rowCnt] === 3) {
        $rowCnt++;
        $itemsPerRow[$rowCnt] = 0;
      }
      $entity = $this->nodeStorage->load($article_and_video);
      if ($rowCnt === 3 && $itemsPerRow[$rowCnt] == 1) {
        $item = [
          '#theme' => 'article_block_large',
          '#entity' => $entity,
          '#full' => FALSE,
        ];
        $itemsPerRow[$rowCnt] += 2;
      }
      else {
        $item = [
          '#theme' => 'article_block_small',
          '#entity' => $entity,
        ];
        $itemsPerRow[$rowCnt]++;
      }
      $content['row' . $rowCnt]['#content'][] = $item;
    }

    if (!empty($most_popular)) {
      $most_popular_entities = $this->nodeStorage->loadMultiple($most_popular);
      // If the bottom row is filled, add a new row.
      if ($itemsPerRow[$rowCnt] === 3) {
        $rowCnt++;
        $itemsPerRow[$rowCnt] = 0;
      }
      $content['row' . $rowCnt]['#content'][] = [
        '#theme' => 'article_block_stack',
        '#entities' => $most_popular_entities,
        '#title' => $this->t('Most Popular Posts'),
      ];
      $itemsPerRow[$rowCnt]++;
    }
    foreach ($content as &$row) {
      $row['#theme'] = 'flex_container';
    }
    return [
      '#theme' => 'articles_and_resources',
      '#content' => $content,
      '#title' => $this->titleResolver->getTitle($request, $route_match->getRouteObject()),
      '#search_form' => $this->formBuilder
        ->getForm('Drupal\nmma_forms\Form\ArticlesResources'),
    ];
  }

  /**
   * Menu callback for 'videos'.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return array
   *   A renderable array.
   */
  public function videos(Request $request, RouteMatchInterface $route_match) {
    $content = [];

    // Retrieve all the data for the page.
    $featured = $this->nodeStorage->getQuery()
      ->condition('field_video_feature', 1)
      ->condition('type', 'video')
      ->condition('status', 1)
      ->sort('created', 'DESC')
      ->range(0, 1)
      ->execute();

    $query = $this->nodeStorage->getQuery()
      ->condition('type', 'video')
      ->condition('status', 1)
      ->sort('created', 'DESC')
      ->range(0, 9);

    if (!empty($featured)) {
      $query->condition('nid', $featured, 'NOT IN');
    }

    $video_nids = $query->execute();

    $rowCnt = 1;

    if (!empty($featured)) {
      $featured_video = $this->nodeStorage->load(reset($featured));
      $content['row' . $rowCnt]['#content'][] = [
        '#theme' => 'article_block_large',
        '#entity' => $featured_video,
        '#full' => TRUE,
      ];
      $rowCnt++;
    }

    foreach ($video_nids as $video_nid) {
      if (!empty($content['row' . $rowCnt]) && count($content['row' . $rowCnt]['#content']) === 3) {
        $rowCnt++;
      }
      $entity = $this->nodeStorage->load($video_nid);
      $content['row' . $rowCnt]['#content'][] = [
        '#theme' => 'article_block_small',
        '#entity' => $entity,
      ];
    }

    foreach ($content as &$row) {
      $row['#theme'] = 'flex_container';
    }
    return [
      '#theme' => 'articles_and_resources',
      '#content' => $content,
      '#title' => $this->titleResolver->getTitle($request, $route_match->getRouteObject()),
      '#search_form' => $this->formBuilder
        ->getForm('Drupal\nmma_forms\Form\Videos'),
    ];
  }

}
