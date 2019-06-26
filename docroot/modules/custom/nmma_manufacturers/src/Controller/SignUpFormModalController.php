<?php

namespace Drupal\nmma_manufacturers\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SignUpFormModalController.
 */
class SignUpFormModalController extends ControllerBase {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

  /**
   * The ModalFormExampleController constructor.
   *
   * @param \Drupal\Core\Form\FormBuilder $formBuilder
   *   The form builder.
   */
  public function __construct(FormBuilder $formBuilder) {
    $this->formBuilder = $formBuilder;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The Drupal service container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder')
    );
  }

  /**
   * Creates function wrapper for opening sign up form in modal.
   *
   * @return string
   *   Returns Ajax response string.
   */
  public function mfrSignupFormModal() {
    $form = $this->formBuilder->getForm('Drupal\nmma_manufacturers\Form\DealersAndManufacturers');
    $options = [
      'width' => '80%',
    ];
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand($this->t('Manufacturers Sign Up'), $form, $options));

    return $response;
  }

  /**
   * Creates function wrapper for opening non-modal mfr sign up form.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   *
   * @return array
   *   The controller build array.
   */
  public function mfrSignupForm(Request $request) {
    $id = $request->query->get('Id');
    if (!is_string($id)) {
      $id = 0;
    }
    else {
      $id = substr($id, 0, 5);
    }
    $form = $this->formBuilder()
      ->getForm('Drupal\nmma_manufacturers\Form\DealersAndManufacturers', $id);

    $build = [
      '#theme' => 'nmma_manufacturers_landing_page',
      '#content' => $form,
    ];

    $noindex_meta_tag = [
      '#tag' => 'meta',
      '#attributes' => [
        'name' => 'robots',
        'content' => 'noindex',
      ],
    ];
    $build['#attached']['html_head'][] = [
      $noindex_meta_tag,
      'noindex_embedded',
    ];

    return $build;
  }

  /**
   * Provides mark up for thank you page after submision.
   */
  public function mfrThanks() {
    $link_url = Url::fromRoute('entity.node.canonical', ['node' => '71']);
    $link_url->setOptions([
      'attributes' => [
        'class' => ['button', 'button--secondary'],
        'data-gtm-tracking' => 'Navigation - Back to Boat Finder - Inline',
      ],
    ]);
    $button = Link::fromTextAndUrl($this->t('Back To Boat Finder!'), $link_url)->toString();

    $build = [];
    $content = '<section><div class="col-12-xs col-12-sm col-12-md"><h3>' . $this->t('Thanks') . '</h3>';
    $content .= '<p>' . $this->t('Thank you for signing up to receive information from manufacturers and dealers.') . ' ';
    $content .= $this->t('You should be getting email communications from manufacturers and dealers within the next couple of days.') . ' ';
    $content .= $this->t('In the meantime, please continue to exploring other boat types.');
    $content .= '<br /><br />';
    $content .= $button;
    $content .= '</div></section>';
    $build = [
      '#title' => $this->t('Thanks!'),
      '#markup' => $content,
    ];
    return $build;
  }

  /**
   * Provides mark up for link processor page.
   */
  public function linkProcessor() {
    $response = new Response();
    $content = drupal_get_path('module', 'nmma_manufacturers') . '/includes/linkprocessor.html';
    $handle = fopen($content, 'r');
    $rcontent = fread($handle, filesize($content));
    fclose($handle);
    $response->headers->set('Content-Type', 'text/html; charset=utf-8');
    $response->setContent($rcontent);
    return $response;
  }

}
