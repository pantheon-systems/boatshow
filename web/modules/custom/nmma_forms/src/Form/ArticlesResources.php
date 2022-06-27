<?php

namespace Drupal\nmma_forms\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\taxonomy\TermStorageInterface;

/**
 * Provides the NMMA Articles and Resources search form.
 *
 * @internal
 */
class ArticlesResources extends FormBase {

  /**
   * Term storage.
   *
   * @var \Drupal\taxonomy\TermStorageInterface
   */
  protected $termStorage;

  /**
   * Articles and resources constructor.
   *
   * @param \Drupal\taxonomy\TermStorageInterface $termStorage
   *   The term storage.
   */
  public function __construct(TermStorageInterface $termStorage) {
    $this->termStorage = $termStorage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')->getStorage('taxonomy_term')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'articles_resources_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['wrapper'] = [
      '#prefix' => '<div class="flex-container">',
      '#suffix' => '</div>',
    ];
    $topic_tids = $this->termStorage->getQuery()
      ->condition('vid', 'activities')
      ->execute();
    $topics_terms = $this->termStorage->loadMultiple($topic_tids);
    $topics = [];
    /** @var \Drupal\taxonomy\Entity\Term $term */
    foreach ($topics_terms as $term) {
      $topics[$term->id()] = $term->getName();
    }
    $form['wrapper']['topicSelect'] = [
      '#type' => 'select',
      '#title' => $this->t('Topic'),
      '#label_attributes' => ['class' => ['text-strong']],
      '#options' => $topics,
      '#empty_value' => '',
      '#empty_option' => $this->t('All Topics'),
      '#prefix' => '<div class="col-12-xs col-12-sm col-6-md">',
      '#suffix' => '</div>',
      '#attributes' => [
        'class' => ['form-select'],
        'onchange' => ['this.form.submit()'],
      ],
      '#chosen' => TRUE,
    ];
    $form['wrapper']['topicKeyword'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keyword Refine'),
      '#placeholder' => $this->t('e.g. Freshwater Fishing'),
      '#prefix' => '<div class="col-12-xs col-12-sm col-6-md submit-input-field">',
      '#label_attributes' => [
        'class' => ['text-strong'],
        'onkeyup' => "jQuery('.articles-and-resources-gtm').attr('data-gtm-tracking', 'Article - Search - ' + this.value);",
      ],
    ];
    $form['wrapper']['submit'] = [
      '#type' => 'submit',
      '#value' => 'submit',
      '#suffix' => '</div>',
      '#attributes' => [
        'data-twig-suggestion' => 'search_button',
        'class' => ['articles-and-resources-gtm', 'articles-resources-search-button'],
        'data-gtm-tracking' => 'Article - Search - ',
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $keywords = $form_state->getValue('topicKeyword');
    $topic = $form_state->getValue('topicSelect');
    $params = [];

    if ($keywords) {
      $params['keywords'] = $keywords;
    }
    if ($topic) {
      $params['field_article_activity'] = $topic;
    }

    list($view_id, $display_id) = ['search', 'page_1'];
    $route_name = "view.$view_id.$display_id";
    $form_state->setRedirect($route_name, $params);

    // Hide the main status message:
    drupal_get_messages('status');
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $keywords = $form_state->getValue('topicKeyword');
    $topic = $form_state->getValue('topicSelect');
    $params = [];

    if (!empty($keywords)) {
      $params['keywords'] = $keywords;
    }
    if (!empty($topic)) {
      $params['field_article_activity'] = $topic;
    }

    if (empty($params)) {
      $form_state->setErrorByName('topicKeyword', $this->t('Please enter at least one search term.'));
    }
  }

}
