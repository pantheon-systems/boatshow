<?php

namespace Drupal\nmma_megamenu_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBuilderInterface;

/**
 * Provides a 'DiscoverBoating' block.
 *
 * @Block(
 *  id = "discover_boating",
 *  admin_label = @Translation("Discover Boating Megamenu Block"),
 * )
 */
class DiscoverBoating extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Form\FormBuilderInterface definition.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * Constructs a new BoatingMapFormBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder interface.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    FormBuilderInterface $form_builder
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildDbMenuForm() {
    $form = $this->formBuilder->getForm('Drupal\nmma_go_boating_map\Form\GoBoatingInline');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#inlineform' => $this->buildDBMenuForm(),
      '#theme' => 'nmma_megamenu_discoverboating',
    ];
  }

}
