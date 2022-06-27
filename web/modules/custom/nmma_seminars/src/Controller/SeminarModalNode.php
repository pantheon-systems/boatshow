<?php

namespace Drupal\nmma_seminars\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\Renderer;
use Drupal\Component\Utility\Html;

/**
 * Class SeminarModalNode.
 */
class SeminarModalNode extends ControllerBase {

  /**
   * The entityManager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityManager;

  /**
   * Rendered service.
   *
   * @var  \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Constructs a CalendarImport object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The core entity type manager.
   * @param \Drupal\Core\Render\Renderer $renderer
   *   Renderer service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, Renderer $renderer) {
    $this->entityManager = $entity_type_manager;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('renderer')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function content(Request $request, $nid = NULL) {

    // Fall back if no nid is provided.
    if (empty($nid)) {
      return;
    }

    // Load node and render it in modal view mode.
    $view_builder = $this->entityManager->getViewBuilder('node');
    $node = $this->entityManager->getStorage('node')->load($nid);
    $build = $view_builder->view($node, 'modal');
    $output = $this->renderer->render($build);

    // Dialog Options.
    $options = [
      'dialogClass' => 'popup-dialog-class',
      'width' => '50%',
    ];
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand(
      Html::escape($node->getTitle()),
      $output,
      $options
    ));

    return $response;
  }

}
