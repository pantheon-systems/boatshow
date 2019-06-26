<?php

/**
 * @file
 * Contains nmma_custom_pages theme functions.
 */

use Drupal\node\Entity\Node;
use Drupal\nmma_custom_pages\EntityHelp;
use Drupal\Core\Url;

/**
 * Implements template_preprocess_article_block_large().
 */
function template_preprocess_article_block_large(&$variables) {
  if (empty($variables['entity'])) {
    return;
  }
  $entity = $variables['entity'];
  if ($entity instanceof Node) {
    switch ($entity->getType()) {
      case 'article':
        _nmma_custom_pages_preprocess_article($entity, $variables);
        break;

      case 'video':
        _nmma_custom_pages_preprocess_video($entity, $variables);
        break;

      default:
        unset($variables['entity']);

    }
  }
}

/**
 * Implements template_preprocess_article_block_large().
 */
function template_preprocess_article_block_small(&$variables) {
  if (empty($variables['entity'])) {
    return;
  }
  $entity = $variables['entity'];
  if ($entity instanceof Node) {
    switch ($entity->getType()) {
      case 'article':
        _nmma_custom_pages_preprocess_article($entity, $variables);
        break;

      case 'video':
        _nmma_custom_pages_preprocess_video($entity, $variables);
        break;

      default:
        unset($variables['entity']);

    }
  }
}

/**
 * A common preprocess function items on the articles and resources page.
 *
 * @param \Drupal\node\Entity\Node $entity
 *   The node.
 * @param array $variables
 *   The variables being preprocessed.
 */
function _nmma_custom_pages_preprocess(Node $entity, array &$variables) {
  $variables['title'] = EntityHelp::getTextValue($entity, 'title');
  $url = Url::fromRoute('entity.node.canonical', ['node' => $entity->id()]);
  $variables['url'] = $url->toString();
  $created = EntityHelp::getTextValue($entity, 'created');
  /** @var \Drupal\Core\Datetime\DateFormatter $date */
  $date = \Drupal::service('date.formatter');
  $variables['created'] = $date->format($created, 'custom', 'M j Y');
}

/**
 * A preprocess function for articles on the articles and resources page.
 *
 * @param \Drupal\node\Entity\Node $entity
 *   The node.
 * @param array $variables
 *   The variables being preprocessed.
 */
function _nmma_custom_pages_preprocess_article(Node $entity, array &$variables) {
  _nmma_custom_pages_preprocess($entity, $variables);
  $image = EntityHelp::getEntityRefImageUrl($entity, 'field_article_tsr_image');
  if (empty($image)) {
    $image = EntityHelp::getEntityRefImageUrl($entity, 'field_article_image');
  }
  $variables['image'] = $image;
  $variables['author'] = EntityHelp::getTextValue($entity, 'field_article_author');
}

/**
 * A preprocess function for videos on the articles and resources page.
 *
 * @param \Drupal\node\Entity\Node $entity
 *   The node.
 * @param array $variables
 *   The variables being preprocessed.
 */
function _nmma_custom_pages_preprocess_video(Node $entity, array &$variables) {
  _nmma_custom_pages_preprocess($entity, $variables);
  $media_video = EntityHelp::getFieldEntityReference($entity, 'field_video_url');
  $image = NULL;
  if (NULL !== $media_video) {
    $image = EntityHelp::getEntityRefImageUrl($media_video, 'thumbnail', 'cropped_grid_item');
  }
  $variables['image'] = $image;
  $video_id = $entity->get('field_video_video_id')->value;
  $variables['video_id'] = $video_id;
}

/**
 * Implements template_preprocess_article_block_stack().
 */
function template_preprocess_article_block_stack(&$variables) {
  $variables['content'] = [];
  if (empty($variables['entities'])) {
    return;
  }
  foreach ($variables['entities'] as $entity) {
    $variables['content'][] = ['#theme' => 'article_block_stack_item', '#entity' => $entity];
  }
}

/**
 * Implements template_preprocess_article_block_stack_item().
 */
function template_preprocess_article_block_stack_item(&$variables) {
  if (empty($variables['entity'])) {
    return;
  }
  $entity = $variables['entity'];
  if ($entity instanceof Node) {
    switch ($entity->getType()) {
      case 'video':
        _nmma_custom_pages_preprocess_video($entity, $variables);
        $variables['gtm_category'] = 'Video';
        break;

      case 'article':
        _nmma_custom_pages_preprocess_article($entity, $variables);
        $variables['gtm_category'] = 'Article';
        break;

      default:
        unset($variables['entity']);

    }
  }
}

/**
 * Implements template_preprocess_video_in_modal().
 */
function template_preprocess_video_in_modal(&$variables) {

}
