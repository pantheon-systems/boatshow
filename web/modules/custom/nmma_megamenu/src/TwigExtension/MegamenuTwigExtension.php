<?php

namespace Drupal\nmma_megamenu\TwigExtension;


/**
 * Class MegamenuTwigExtension.
 */
class MegamenuTwigExtension extends \Twig_Extension {


  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('megamenu', [$this, 'nmmaMenu']),
      new \Twig_SimpleFunction('megamenu_region', [$this, 'nmmaMegamenuRegion']),
      new \Twig_SimpleFunction('mm_link', [$this, 'mm_link']),
    ];
  }

   /**
    * {@inheritdoc}
    */
    public function getName() {
      return 'nmma_megamenu.twig.extension';
    }


  /**
   * Returns the render array for Drupal menu.
   *
   * @param string $menu_name
   *   The name of the menu.
   * @param int $level
   *   (optional) Initial menu level.
   * @param int $depth
   *   (optional) Maximum number of menu levels to display.
   * @param bool $expand
   *   (optional) Expand all menu links.
   *
   * @return array
   *   A render array for the menu.
   */
  public function nmmaMenu($menu_name, $level = 1, $depth = 0, $expand = FALSE) {
    /** @var \Drupal\Core\Menu\MenuLinkTreeInterface $menu_tree */
    $menu_tree = \Drupal::service('menu.link_tree');
    $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);

    // Adjust the menu tree parameters based on the block's configuration.
    $parameters->setMinDepth($level);
    // When the depth is configured to zero, there is no depth limit. When depth
    // is non-zero, it indicates the number of levels that must be displayed.
    // Hence this is a relative depth that we must convert to an actual
    // (absolute) depth, that may never exceed the maximum depth.
    if ($depth > 0) {
      $parameters->setMaxDepth(min($level + $depth - 1, $menu_tree->maxDepth()));
    }

    // If expandedParents is empty, the whole menu tree is built.
    if ($expand) {
      $parameters->expandedParents = [];
    }

    $tree = $menu_tree->load($menu_name, $parameters);
    $manipulators = [
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];
    $tree = $menu_tree->transform($tree, $manipulators);
    return $menu_tree->build($tree);
  }

  /**
   * Builds the render array of a given region.
   *
   * @param string $region
   *   The region to build.
   * @param string $theme
   *   (Optional) The name of the theme to load the region. If it is not
   *   provided then default theme will be used.
   *
   * @return array
   *   A render array to display the region content.
   */
  public function nmmaMegamenuRegion($region, $theme = NULL) {
    $entity_type_manager = \Drupal::entityTypeManager();
    $blocks = $entity_type_manager->getStorage('block')->loadByProperties([
      'region' => $region,
      'theme'  => $theme ?: \Drupal::config('system.theme')->get('default'),
    ]);

    $view_builder = $entity_type_manager->getViewBuilder('block');

    $build = [];

    /* @var $blocks \Drupal\block\BlockInterface[] */
    foreach ($blocks as $id => $block) {
      if ($block->access('view')) {
        $block_plugin = $block->getPlugin();
        if ($block_plugin instanceof TitleBlockPluginInterface) {
          $request = \Drupal::request();
          if ($route = $request->attributes->get(RouteObjectInterface::ROUTE_OBJECT)) {
            $block_plugin->setTitle(\Drupal::service('title_resolver')->getTitle($request, $route));
          }
        }
        $build[$id] = $view_builder->view($block);
      }
    }

    //Render the region even if there is no content
    $build['#region'] = $region;
    $build['#theme_wrappers'] = ['region'];

    return $build;
  }


  /**
   * Returns the render array for Drupal menu.
   *
   * @param string $menu_name
   *   The name of the menu.
   * @param int $level
   *   (optional) Initial menu level.
   * @param int $depth
   *   (optional) Maximum number of menu levels to display.
   * @param bool $expand
   *   (optional) Expand all menu links.
   *
   * @return array
   *   A render array for the menu.
   */
  function mm_link($menu_name, $index){

    $level = 1;
    $depth = 0;
    /** @var \Drupal\Core\Menu\MenuLinkTreeInterface $menu_tree */
    $menu_tree = \Drupal::service('menu.link_tree');
    $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);

    // Adjust the menu tree parameters based on the block's configuration.
    $parameters->setMinDepth($level);
    // When the depth is configured to zero, there is no depth limit. When depth
    // is non-zero, it indicates the number of levels that must be displayed.
    // Hence this is a relative depth that we must convert to an actual
    // (absolute) depth, that may never exceed the maximum depth.
    if ($depth > 0) {
      $parameters->setMaxDepth(min($level + $depth - 1, $menu_tree->maxDepth()));
    }

    $tree = $menu_tree->load($menu_name, $parameters);
    $manipulators = [
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];

    $tree = $menu_tree->transform($tree, $manipulators);

    $new_tree = [];
    $i = 1;

    foreach($tree as $key => $menu_item){
      if ($i == $index){
        $new_tree[$key] = $menu_item;
        break;
      }
      $i++;
    }

    $build = $menu_tree->build($new_tree);

    //Pass altered menu tree to custom theme function
    $build['#theme'] = "mm_link";
    $build['#index'] = $index;

    return $build;
  }
}
