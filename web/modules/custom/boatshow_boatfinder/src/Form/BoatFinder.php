<?php

namespace Drupal\boatshow_boatfinder\Form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Component\Utility\Html;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Site\Settings;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the BoatFinder search form.
 *
 * @internal
 */
class BoatFinder extends FormBase implements ContainerInjectionInterface {

  /**
   * The core cache interface.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cache;

  /**
   * The core time interface.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * The core logger channel interface.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * Constructs a Boat Finder form.
   *
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The core cache interface.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The core time interface.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The core logger factory.
   */
  public function __construct(CacheBackendInterface $cache, TimeInterface $time, LoggerChannelFactoryInterface $logger_factory) {
    // Inject service dependencies.
    // @see https://www.drupal.org/docs/8/api/services-and-dependency-injection/services-and-dependency-injection-in-drupal-8
    $this->cache = $cache;
    $this->time = $time;
    $this->logger = $logger_factory->get('boatshow_boatfinder');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Standard container dependency injection.
    // @see https://docs.acquia.com/article/lesson-83-dependency-injection
    return new static(
      $container->get('cache.default'),
      $container->get('datetime.time'),
      $container->get('logger.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'boatfinder';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['wrapper'] = [
      '#prefix' => '<div class="container">',
      '#suffix' => '</div>',
    ];
    $form['wrapper']['make'] = [
      '#prefix' => '<div class="search-form"><div class="search-form-row">',
      '#type' => 'select',
      '#title' => $this->t('Manufacturer'),
      '#options' => $this->getMakes(),
      '#default_value' => $this->getDefault($form_state, 'make'),
      '#ajax' => array(
        'event' => 'change',
        'callback' => [$this, 'ajaxMakeChanged'],
        'wrapper' => 'boatfinder-model-wrapper',
      ),
    ];
    $form['wrapper']['model'] = [
      '#prefix' => '<div id="boatfinder-model-wrapper">',
      '#type' => 'select',
      '#title' => $this->t('Model'),
      '#options' => $this->getModels($form, $form_state),
      '#default_value' => $this->getDefault($form_state, 'model'),
      '#suffix' => '</div></div>',
    ];
    $form['wrapper']['type'] = [
      '#prefix' => '<div class="search-form-row">',
      '#type' => 'select',
      '#title' => $this->t('Boat type'),
      '#options' => $this->getTypes(),
      '#default_value' => $this->getDefault($form_state, 'type'),
    ];
    $show_length = FALSE;
    if ($show_length) {
      $form['wrapper']['length'] = [
        '#type' => 'select',
        '#title' => $this->t('Length'),
        '#options' => [
          '' => '',
          '0 - 20' => $this->t('Up to 20 feet'),
          '20 - 30' => $this->t('20 to 30 feet'),
          '30 - 40' => $this->t('30 to 40 feet'),
          '40 - 50' => $this->t('40 to 50 feet'),
          '50 - 999' => $this->t('Over 50 feet'),
        ],
        '#default_value' => $this->getDefault($form_state, 'length'),
      ];
    }
    $form['wrapper']['certified'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('NMMA Certified'),
      '#default_value' => $this->getDefault($form_state, 'certified'),
      '#suffix' => '</div>',
    ];
    $form['wrapper']['submit']['search'] = [
      '#prefix' => '<div class="search-form-row">',
      '#type' => 'submit',
      '#button_type' => 'cta-alt',
      '#value' => $this->t('Search'),
    ];
    $form['wrapper']['submit']['clear'] = [
      '#type' => 'submit',
      '#value' => $this->t('Clear'),
      '#button_type' => 'secondary',
      '#suffix' => '</div></div>',
    ];
    $form['wrapper']['results'] = [
      '#prefix' => '<div class="search-results-grid">',
      '#type' => 'markup',
      '#markup' => $this->getDefault($form_state, 'results'),
      '#suffix' => '</div>',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $button = $form_state->getValue('op');
    if ($button->render() == $this->t('Search')) {
      // Get context and search code and start URL build.
      $context = $this->getContext();
      $searchId = $this->getSearchId();
      $remote_url = "http://showsearch.proximity-innovations.net/api/v1/ProximityBoat/boatdetailedsearch?searchId=$searchId";

      // Get form values and finish URL build.
      $fields = [
        'year' => 'year',
        'make' => 'make',
        'model' => 'model',
        'type' => 'productcategory',
        'length' => 'length',
        'certified' => 'certified',
      ];
      foreach ($fields as $key => $name) {
        $value = $form_state->getValue($key);
        if ($value) {
          $remote_url = $remote_url . '&' . $name . '=' . urlencode($value);
        }
      }

      // Get search results.
      $json = file_get_contents($remote_url, FALSE, $context);
      $results = json_decode($json);
      $this->logErrors($results);

      // Process search results.
      $output = $this->processResults($results);

      // Display search results.
      $form_state->setValue('results', $output);
      $form_state->setRebuild();
    }
    else {
      // Restart the search with a new form.
      $form_state->setRedirect('boatshow_boatfinder.search');
    }
  }

  /**
   * Get city-specific search ID.
   */
  public function getSearchId() {
    return Settings::get('boatshow.city.searchId');
  }

  /**
   * Get basic authentication context.
   */
  public function getContext() {
    $username = 'AvionosKey';
    $password = 'A0E6FA91-762D-4760-9E62-EFF4285F1BF3';

    // Create a stream.
    $options = [
      'http' => [
        'method' => 'GET',
        'header' => 'Authorization: Basic ' . base64_encode("$username:$password"),
      ],
    ];

    $context = stream_context_create($options);
    return $context;
  }

  /**
   * Get a default value.
   */
  public function getDefault(FormStateInterface $form_state, $field) {
    return $form_state->getValue($field);
  }

  /**
   * Process returned parameters.
   */
  public function processParameters($results, $type) {
    $parameters = [];
    $parameters[''] = '';
    if (isset($results, $results->result, $results->result->{$type})) {
      if (!empty($results->result->{$type})) {
        foreach ($results->result->{$type} as $parameter) {
          if (!empty($parameter->name)) {
            $parameters[$parameter->name] = $parameter->name;
          }
        }
      }
    }
    return $parameters;
  }

  /**
   * Process returned search results.
   */
  public function processResults($results) {
    // Check for data.
    if (!isset($results, $results->result, $results->result->boatDetailedSearchList)) {
      return '<div class"search-results-wrapper">' . $this->t('No results, please try a different search.') . '</div>';
    }
    if (empty($results->result->boatDetailedSearchList)) {
      return '<div class"search-results-wrapper">' . $this->t('No results, please try a different search.') . '</div>';
    }

    // Output the search results.
    $results = $results->result->boatDetailedSearchList;
    $output = '<div class"search-results-wrapper">';
    foreach ($results as $result_obj) {
      $result = (array) $result_obj;

      // Defaults.
      if ($result['length'] == 0) {
        $result['length'] = '';
      }

      // Thumbnail image.
      $image = $result['thumbnail'];

      // Setup link.
      $link_open = '<a href="/boatfinder/boat/' . $result['code'] . '">';
      $link_close = '</a>';

      // Output the result.
      if (!empty($result['productCertified'])) {
        $output .= '<div class="search-result search-result-certified">';
      }
      else {
        $output .= '<div class="search-result">';
      }
      $output .=   $link_open . '<img src="' . $image . '">' . $link_close;
      $output .=   '<div class="search-result-text">';
      $output .=     '<div class="boat-name">';
      $output .=       $link_open . $result['displayName'] . $link_close;
      $output .=     '</div>';
      $output .=     '<div class="boat-length">';
      $output .=       $result['length'];
      $output .=     '</div>';
      if (!empty($result['showLocation'])) {
        $output .=     '<div class="booth">';
        $output .=       $result['showLocation'];
        $output .=     '</div>';
      }
      $output .=     '<div class="boat-link">';
      $output .=       $link_open . ' > ' . $link_close;
      $output .=     '</div>';
      $output .=   '</div>';
      $output .= '</div>';
    }
    $output .= '</div>';

    return $output;
  }

  /**
   * Get list of manufacturers.
   */
  public function getMakes() {
    $count = 0;
    $cid = 'boatshow_boatfinder_makes';
    if ($cache = $this->cache->get($cid)) {
      $json = $cache->data;
      $results = json_decode($json);
      $parameters = $this->processParameters($results, 'makes');
      $count = count($parameters);
    }
    if (!$count) {
      // Get the list of manufacturers from the API.
      $context = $this->getContext();
      $searchId = $this->getSearchId();
      $remote_url = "http://showsearch.proximity-innovations.net/api/v1/proximityboat/search/$searchId/parameters/makes";
      $json = file_get_contents($remote_url, FALSE, $context);
      $results = json_decode($json);
      $this->logErrors($results);
      $parameters = $this->processParameters($results, 'makes');
      $this->cache->set($cid, $json, $this->time->getCurrentTime() + (60 * 60 * 24));
    }
    return $parameters;
  }

  /**
   * Get the list of models for a manufacturer.
   */
  public function getModels(array $form, FormStateInterface $form_state) {
    $input = $form_state->getUserInput();
    $make = !empty($input['make']) ? Html::escape($input['make']) : 'null';
    $count = 0;
    $cid = 'boatshow_boatfinder_models_' . $make;
    if ($cache = $this->cache->get($cid)) {
      $json = $cache->data;
      $results = json_decode($json);
      $parameters = $this->processParameters($results, 'models');
      $count = count($parameters);
    }
    if (!$count) {
      // Get the list of manufacturers from the API.
      $context = $this->getContext();
      $searchId = $this->getSearchId();
      $remote_url = "http://showsearch.proximity-innovations.net/api/v1/proximityboat/search/$searchId/parameters/models?make=" . urlencode($make);
      $json = file_get_contents($remote_url, FALSE, $context);
      $results = json_decode($json);
      $this->logErrors($results);
      $parameters = $this->processParameters($results, 'models');
      if (count($parameters) == 1) {
        $parameters['null'] = 'Select a manufacturer first';
      }
      $this->cache->set($cid, $json, $this->time->getCurrentTime() + (60 * 60 * 24));
    }
    return $parameters;
  }

  /**
   * Return the part of the form to update when a manufacturer is selected.
   */
  public function ajaxMakeChanged(array $form, FormStateInterface $form_state) {
    return $form['wrapper']['model'];
  }

  /**
   * Get list of manufacturers.
   */
  public function getTypes() {
    $count = 0;
    $cid = 'boatshow_boatfinder_types';
    if ($cache = $this->cache->get($cid)) {
      $json = $cache->data;
      $results = json_decode($json);
      $parameters = $this->processParameters($results, 'productCategories');
      $count = count($parameters);
    }
    if (!$count) {
      // Get the list of manufacturers from the API.
      $context = $this->getContext();
      $searchId = $this->getSearchId();
      $remote_url = "http://showsearch.proximity-innovations.net/api/v1/proximityboat/search/$searchId/parameters/categories";
      $json = file_get_contents($remote_url, FALSE, $context);
      $results = json_decode($json);
      $this->logErrors($results);
      $parameters = $this->processParameters($results, 'productCategories');
      $this->cache->set($cid, $json, $this->time->getCurrentTime() + (60 * 60 * 24));
    }
    return $parameters;
  }

  /**
   * Log errors.
   */
  protected function logErrors($results) {
    if (!empty($results->hasError)) {
      $this->logger->error('Proximity API error @code: @message', [
        '@code' => $results->httpStatusCode,
        '@message' => $results->messages->description,
      ]);
    }
  }

}
