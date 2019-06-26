<?php

namespace Drupal\nmma_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides a 'NMMA Sponsors' Block.
 *
 * @Block(
 *   id = "sponsors_block",
 *   admin_label = @Translation("Sponsors List"),
 *   category = @Translation("Sponsors List"),
 * )
 */
class SponsorsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Entity manager service.
   *
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityManager;

  /**
   * Constructs a AsideNavBlock object.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The core entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Prepare default variables.
    $build = [];
    $sponsors = [];
    $featuredItem = [];

    $featured = $this->entityManager->getStorage('taxonomy_term')
      ->loadByProperties([
        'vid' => 'sponsors',
        'field_featured' => TRUE,
      ]);

    // Retrieve featured item logo.
    if (!empty($featured)) {
      $featuredTerm = reset($featured);
      if (!$featuredTerm->get('field_logo')->isEmpty()) {
        $fileUri = $featuredTerm->get('field_logo')->entity->getFileUri();
        $featuredItem = [
          'image' => file_create_url($fileUri),
          'alt' => $featuredTerm->get('field_logo')->getValue[0]['alt'],
          'title' => $featuredTerm->get('field_logo')->getValue[0]['title'],
        ];
        if (!$featuredTerm->get('field_link_to_sponsor')->isEmpty()) {
          $featuredItem['url'] = $featuredTerm->get('field_link_to_sponsor')
            ->first()->getUrl();
        }
      }
    }

    // Retrieve sponsors term from sponsors vocabulary.
    $items = $this->entityManager->getStorage('taxonomy_term')
      ->loadTree('sponsors', 0, NULL, TRUE);

    // Fall back if there is are not terms for this vocabulary.
    if (empty($items)) {
      return $build;
    }

    // Prepare sponsors items.
    foreach ($items as $key => $term) {
      // Skip featured items.
      if (!empty($term->get('field_featured')->getValue()[0]['value'])) {
        continue;
      }
      if (!$term->get('field_logo')->isEmpty()) {
        $fileUri = $term->get('field_logo')->entity->getFileUri();
        $values = $term->get('field_logo')->getValue();
        $sponsors[$key] = [
          'image' => file_create_url($fileUri),
          'alt' => $values[0]['alt'],
          'title' => $values[0]['title'],
        ];
        if (!$term->get('field_link_to_sponsor')->isEmpty()) {
          $sponsors[$key]['url'] = $term->get('field_link_to_sponsor')
            ->first()->getUrl();
        }
      }
    }

    $build = [
      '#theme' => 'sponsors_block',
      '#items' => $sponsors,
      '#featured' => $featuredItem,
    ];

    return $build;
  }

}
