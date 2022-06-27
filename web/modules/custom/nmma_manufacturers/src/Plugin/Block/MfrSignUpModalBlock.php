<?php

namespace Drupal\nmma_manufacturers\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBuilderInterface;

/**
 * Provides a 'MfrSignUpBlock' block.
 *
 * @Block(
 *  id = "mfr_sign_up_modal_block",
 *  admin_label = @Translation("Manufacturer's Sign Up Block (Opens as Modal)"),
 * )
 */
class MfrSignUpModalBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Drupal\Core\Form\FormBuilderInterface definition.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * Constructs a new MfrModalBlock object.
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
  public function build() {

    $link_url = Url::fromRoute('nmma_manufacturers.sign_up_form_modal');
    $link_url->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--secondary'],
        'data-gtm-tracking' => 'Navigation - Mfr Form Link|Contact A Manufacturer  - Inline',
      ],
    ]);

    return [
      '#theme' => 'nmma_manufacturers_signup',
      '#modalbutton' => Link::fromTextAndUrl($this->t('Get In Touch With Manufacturers'), $link_url)->toString(),
    ];
  }

}
