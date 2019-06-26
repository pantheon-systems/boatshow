<?php

namespace Drupal\nmma_manufacturers\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Provides a block linking to mfr signup form.
 *
 * @Block(
 *   id = "mfr_signup_block",
 *   admin_label = @Translation("Manufacturer Sign Up Block - Non Modal"),
 * )
 */
class MfrSignUpBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * RouteMatch.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $routeMatch;


  /**
   * Calls the get values from URL.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Mfr sign up form block intro contructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $routeMatch
   *   The current page route.
   * @param Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   Request stack.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentRouteMatch $routeMatch, RequestStack $request_stack) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $routeMatch;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match'),
      $container->get('request_stack')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $q = $this->requestStack->getCurrentRequest()->query->all();

    $term = $this->routeMatch->getParameter('taxonomy_term');

    $nmma_id = $term->field_boat_type_nmma_id->value;

    $link_url = Url::fromRoute('nmma_manufacturers.dealers_and_manufacturers_form_page');
    $link_url->setOptions([
      'attributes' => [
        'class' => ['button', 'button--secondary'],
        'data-gtm-tracking' => 'Navigation - Mfr Form Link|Contact A Manufacturer  - Inline',
      ],
      'query' => [
        'typeid' => $nmma_id,
      ],
    ]);

    if (array_key_exists('embedded', $q)) {
      $link_url->setOptions([
        'attributes' => [
          'class' => ['button', 'button--secondary'],
          'data-gtm-tracking' => 'Navigation - Mfr Form Link|Contact A Manufacturer  - Inline',
        ],
        'query' => [
          'typeid' => $nmma_id,
          'embedded' => '1',
        ],
      ]);
    }

    $q = $this->requestStack->getCurrentRequest()->query->all();

    return [
      '#linkbutton' => Link::fromTextAndUrl($this->t('Have a dealer or manufacturer contact me'), $link_url)->toString(),
      '#theme' => 'nmma_manufacturers_signup',
    ];
  }

}
