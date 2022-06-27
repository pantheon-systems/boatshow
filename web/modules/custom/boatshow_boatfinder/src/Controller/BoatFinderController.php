<?php

namespace Drupal\boatshow_boatfinder\Controller;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Defines a controller to render a single boat.
 */
class BoatFinderController extends ControllerBase {

  use StringTranslationTrait;

  /**
   * The core cache interface.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cache;

  /**
   * The cache ID for the title.
   *
   * @var string
   */
  protected $cid;

  /**
   * The core time interface.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * Constructs a Boat Finder controller.
   *
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The core cache interface.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The core time interface.
   */
  public function __construct(CacheBackendInterface $cache, TimeInterface $time) {
    // Inject service dependencies.
    // @see https://www.drupal.org/docs/8/api/services-and-dependency-injection/services-and-dependency-injection-in-drupal-8
    $this->cache = $cache;
    $this->cid = 'boatshow_boatfinder_title_';
    $this->time = $time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Standard container dependency injection.
    // @see https://docs.acquia.com/article/lesson-83-dependency-injection
    return new static(
      $container->get('cache.default'),
      $container->get('datetime.time')
    );
  }

  /**
   * The view callback for the page that renders a single boat.
   *
   * @param string $code
   *   The boat code returned from the remote API.
   *
   * @return string
   *   The boat detail page render array.
   */
  public function boatView($code) {
    $output = '';

    // Build the URL to the remote API.
    $context = $this->getContext();
    $remote_url = "http://showsearch.proximity-innovations.net/api/v1/proximityboat/boatdetails/$code";

    // Get search results.
    $json = file_get_contents($remote_url, FALSE, $context);
    $result = json_decode($json);

    // Process the API result and build the output.
    if (isset($result, $result->result, $result->result->boatDisplayDetails)) {
      if (!empty($result->result->boatDisplayDetails)) {
        $details = (array) $result->result->boatDisplayDetails[0];
      }
    }

    // Invalid boat code, throw a 404.
    if (empty($details)) {
      throw new NotFoundHttpException();
    }

    // Valid boat code, continue processing.
    if (!empty($details)) {
      // Save title.
      $this->cache->set($this->cid . $code, $details['displayName'], $this->time->getCurrentTime() + (60 * 60 * 24));

      // Build images output.
      $images = '';
      if (!empty($details['images'])) {
        $image = $details['images'][0]->primary;
        $images = '<div class="images-wrapper">' . '<img src="' . $image . '">' . '</div>';
      }

      // Build details output.
      $output .= '<div class="container"><div class="boat-details">';
      $output .=   '<h1>' . $details['displayName'] . '</h1>';
      $output .=   $images;
      $output .=   '<div class="boat-details-text">';
      $output .=     '<div class="description">';
      $output .=       $details['description'];
      $output .=     '</div>';
      $output .=     '<div class="details">';
      $output .=       '<div class="details-section main">';
      $output .=         '<div class="details-header">' . $this->t('Details:') . '</div>';
      $output .=         '<div class="details-field field--make-model">';
      $output .=           '<div class="label">' . $this->t('Make/Model:') . '</div>';
      $output .=           '<div class="field">' . $details['displayName'] . '</div>';
      $output .=         '</div>';
      $output .=         '<div class="details-field field--engine">';
      $output .=           '<div class="label">' . $this->t('Engine:') . '</div>';
      $output .=           '<div class="field">' . $details['engineName'] . '</div>';
      $output .=         '</div>';
      $output .=         '<div class="details-field field--boat-type">';
      $output .=           '<div class="label">' . $this->t('Boat Type:') . '</div>';
      $output .=           '<div class="field">' . $details['productCategory'] . '</div>';
      $output .=         '</div>';
      $output .=       '</div>';

      $output .=       '<div class="details-section specifications">';
      $output .=         '<div class="details-header">' . $this->t('Specifications:') . '</div>';
      $output .=         '<div class="details-field">';
      $output .=           '<div class="label">' . $this->t('Length:') . '</div>';
      $output .=           '<div class="field">' . $details['length'] . '</div>';
      $output .=         '</div>';
      $output .=         '<div class="details-field">';
      $output .=           '<div class="label">' . $this->t('Exterior Color:') . '</div>';
      $output .=           '<div class="field">' . $details['exteriorColor'] . '</div>';
      $output .=         '</div>';

      if (!empty($details['keyAdditionalSpecs'])) {
        foreach ($details['keyAdditionalSpecs'] as $value) {
          $output .=     '<div class="details-field">';
          $output .=       '<div class="label">' . $this->t($value->specName) . ':</div>';
          $output .=       '<div class="field">' . $value->specValue . '</div>';
          $output .=     '</div>';
        }
      }
      if (!empty($details['keyFeatures'])) {
        foreach ($details['keyFeatures'] as $value) {
          $output .=     '<div class="details-field">';
          $output .=       '<div class="label">' . $this->t('Feature') . ':</div>';
          $output .=       '<div class="field">' . $value->featureName . '</div>';
          $output .=     '</div>';
        }
      }
      $output .=       '</div>';

      if (!empty($details['dealer'])) {
        $dealer = (array) $details['dealer'];

        $output .=     '<div class="details-section dealer">';
        $output .=       '<div class="details-header">' . $this->t('About Exhibitor') . '</div>';
        $output .=       '<div class="details-field name">';
        $output .=         '<div class="field">' . $dealer['dealerName'] . '</div>';
        $output .=       '</div>';

        if (!empty($dealer['addresses']) && !is_null($dealer['addresses'][0]->city)) {
          $output .=     '<div class="details-field address">';
          $output .=       '<div class="field">';
          $output .=         $dealer['addresses'][0]->street1 . '<br />';
          $output .=         $dealer['addresses'][0]->street2 . '<br />';
          $output .=         $dealer['addresses'][0]->city . ', ' . $dealer['addresses'][0]->state . ' ' . $dealer['addresses'][0]->postalCode;
          $output .=       '</div>';
          $output .=     '</div>';
        }
        if (!empty($dealer['phones']) && !is_null($dealer['phones'][0]->prefix)) {
          $output .=     '<div class="details-field phones">';
          $output .=       '<div class="field">';
          $output .=         '(' . $dealer['phones'][0]->areaCode . ') ' . $dealer['phones'][0]->prefix . '-' . $dealer['phones'][0]->lineNumber;
          $output .=       '</div>';
          $output .=     '</div>';
        }
        if (!empty($dealer['website'])) {
          $output .=     '<div class="details-field website">';
          $output .=       '<div class="field"><a href="http://' . $dealer['website'] . '">' . $dealer['website'] . '</a></div>';
          $output .=     '</div>';
        }
        if (!empty($details['showLocation'])) {
          $output .=     '<div class="details-field booth">';
          $output .=       '<div class="field">' . $this->t('Booth: ') . '<strong>' . $details['showLocation'] . '</strong></div>';
          $output .=     '</div>';
        }
      }
      $output .=       '</div>';
      $output .=     '</div>';
      $output .=   '</div>';
      $output .= '</div></div>';
    }

    // Return the output.
    $build['#markup'] = $output;
    return $build;
  }

  /**
   * The _title_callback for the page that renders a single boat.
   *
   * @param string $code
   *   The boat code returned from the remote API.
   *
   * @return string
   *   The page title.
   */
  public function boatTitle($code) {
    $title = 'Boat';
    if ($cache = $this->cache->get($this->cid . $code)) {
      $title = $cache->data;
    }
    return $title;
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

}
