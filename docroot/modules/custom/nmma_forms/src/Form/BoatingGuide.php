<?php

namespace Drupal\nmma_forms\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\taxonomy\TermStorageInterface;
use Drupal\nmma_custom_pages\EntityHelp;
use GuzzleHttp\Client;
use Drupal\Component\Serialization\Json;

/**
 * Provides the NMMA Boating Guide form.
 *
 * @internal
 */
class BoatingGuide extends AddressBase {

  /**
   * Allows access to messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Term storage.
   *
   * @var \Drupal\taxonomy\TermStorageInterface
   */
  protected $termStorage;

  /**
   * A guzzle http client object.
   *
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * BoatingGuide constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\taxonomy\TermStorageInterface $termStorage
   *   The term storage.
   * @param \GuzzleHttp\Client $httpClient
   *   A guzzle http client instance.
   */
  public function __construct(MessengerInterface $messenger, TermStorageInterface $termStorage, Client $httpClient) {
    $this->messenger = $messenger;
    $this->termStorage = $termStorage;
    $this->client = $httpClient;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('entity_type.manager')->getStorage('taxonomy_term'),
      $container->get('http_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'boating_guide_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#prefix'] = '<div id="boating-guide-form-wrapper">';
    $form['#suffix'] = '</div>';
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name@req', ['@req' => '*']),
      '#required' => TRUE,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];
    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name@req', ['@req' => '*']),
      '#required' => TRUE,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];
    $form['address1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address Line 1@req', ['@req' => '*']),
      '#required' => TRUE,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];
    $form['address2'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address Line 2'),
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];
    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country@req', ['@req' => '*']),
      '#options' => $this->countries(),
      '#default_value' => self::US,
      '#ajax' => [
        'callback' => '::updateStates',
        'wrapper' => 'states-wrapper',
        'effect' => 'fade',
        'event' => 'change',
      ],
      '#prefix' => '<div class="half-width">',
      '#suffix' => '</div>',
    ];

    $country_code = $form_state->isValueEmpty('country') || $form_state->getValue('country') == self::US ? self::US : self::CANADA;
    $form['state'] = [
      '#type' => 'select',
      '#title' => $this->t('State@req', ['@req' => '*']),
      '#options' => $this->states($country_code),
      '#empty_value' => '',
      '#empty_option' => 'Select State',
      '#required' => TRUE,
      '#prefix' => '<div id="states-wrapper" class="half-width">',
      '#suffix' => '</div><div class="blank"></div>',
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City@req', ['@req' => '*']),
      '#required' => TRUE,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];
    $form['zip_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Zip Code@req', ['@req' => '*']),
      '#required' => TRUE,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
      'error' => [
        '#type' => 'markup',
        '#markup' => '',
      ],
    ];
    $form['zip_code_error'] = [
      '#type' => 'markup',
      '#markup' => '',
    ];
    $form['email_address'] = [
      '#type' => 'email',
      '#title' => $this->t('Email Address@req', ['@req' => '*']),
      '#required' => TRUE,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];
    $form['phone_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone Number'),
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];

    $agree_boat_types_title = $this->t('I would like to be contacted by manufacturers or dealers to learn more about boat types and their uses.');
    $form['agree_boat_types'] = [
      '#type' => 'checkbox',
      '#title' => $agree_boat_types_title,
      '#attributes' => [
        'data-gtm-tracking' => 'Form - OptIn - ' . strip_tags($agree_boat_types_title),
      ],
      '#prefix' => '<div class="full-width">',
      '#suffix' => '</div>',
    ];

    $agreed['own_a_boat'] = [
      '#type' => 'radios',
      '#title' => $this->t('Do you own a boat?'),
      '#options' => [
        'yes' => $this->t('I already have a boat'),
        'no' => $this->t("I don't have a boat"),
      ],
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];

    $activities_tids = $this->termStorage->getQuery()
      ->condition('vid', 'activities')
      ->condition('field_activity_visible', 1)
      ->execute();
    $activities_terms = $this->termStorage->loadMultiple($activities_tids);
    $activities = [];
    /** @var \Drupal\taxonomy\Entity\Term $term */
    foreach ($activities_terms as $term) {
      // Since this info is being passed to a third party that used the old
      // IDs, use that instead of the new term ID if possible.
      $id = EntityHelp::getTextValue($term, 'field_activity_nmma_internal_id');
      if (NULL === $id) {
        $id = $term->id();
      }
      $activities[$id] = $term->getName();
    }
    $agreed['activities'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Which boating activity are you interested in?'),
      '#options' => $activities,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];

    $agreed['interested_in_specific_boat_types'] = [
      '#type' => 'radios',
      '#title' => $this->t('Do you know which boat type you are interested in?'),
      '#options' => [
        'yes' => $this->t('Yes'),
        'no' => $this->t('No'),
      ],
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];

    $boat_types_tids = $this->termStorage->getQuery()
      ->condition('vid', 'boat_types')
      ->condition('field_boat_visible_in_finder', '1')
      ->execute();
    $boat_types_terms = $this->termStorage->loadMultiple($boat_types_tids);
    $boat_types = [];
    /** @var \Drupal\taxonomy\Entity\Term $term */
    foreach ($boat_types_terms as $term) {
      // Since this info is being passed to a third party that used the old
      // IDs, use that instead of the new term ID if possible.
      $id = EntityHelp::getTextValue($term, 'field_boat_type_nmma_id');
      if (NULL === $id) {
        $id = $term->id();
      }
      $boat_types[$id] = $term->getName();
    }
    $agreed['boat_types_container'] = [
      '#type' => 'container',
      '#attributes' => ['requires_state' => 1],
      'boat_types' => [
        '#type' => 'checkboxes',
        '#options' => $boat_types,
      ],
      '#prefix' => '<div>',
      '#suffix' => '</div>',
      '#states' => [
        'visible' => [
          // Only show boat types if they are interested in a boat type.
          ':input[name="interested_in_specific_boat_types"]' => ['value' => 'yes'],
        ],
      ],
    ];

    $when_purchase_options = [
      $this->t('As soon as possible'),
      $this->t('In the next 3 months'),
      $this->t('In the next 6 months'),
      $this->t('In about a year from now'),
      $this->t('Someday in the future'),
      $this->t("I don't know"),
    ];
    $when_purchase_options = array_combine($when_purchase_options, $when_purchase_options);
    $agreed['when_purchase'] = [
      '#type' => 'select',
      '#title' => $this->t('When do you plan to purchase a new boat?'),
      '#empty_value' => '',
      '#empty_option' => '--',
      '#options' => $when_purchase_options,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];

    $form['agreed_container'] = [
      '#type' => 'container',
      '#attributes' => ['requires_state' => 1],
      '#states' => [
        'visible' => [
          // Only show boat types if they are interested in a boat type.
          ':input[name="agree_boat_types"]' => ['checked' => TRUE],
        ],
      ],
    ];

    // Add all the elements that are part of the 'agreed container' so that
    // they can be easily shown / hidden by the agreed checkbox.
    $form['agreed_container'] = array_merge($form['agreed_container'], $agreed);

    $agree_newsletter_title = $this->t('I agree to receive Discover Boating’s newsletter with news, updates and promotions. You can withdraw your consent at any time. Please refer to our @privacy_policy or @contact_us for more details.',
      [
        '@privacy_policy' => Link::createFromRoute($this->t('privacy policy'), 'entity.node.canonical', ['node' => 17906], ['attributes' => ['target' => '_blank']])->toString(),
        '@contact_us' => Link::createFromRoute($this->t('contact us'), 'entity.node.canonical', ['node' => 20326], ['attributes' => ['target' => '_blank']])->toString(),
      ]
    );
    $form['agree_newsletter'] = [
      '#type' => 'checkbox',
      '#title' => $agree_newsletter_title,
      '#attributes' => [
        'data-gtm-tracking' => 'Form - OptIn - ' . strip_tags($agree_newsletter_title),
      ],
      '#prefix' => '<div class="full-width">',
      '#suffix' => '</div>',
    ];

    $form['agree_privacy'] = [
      '#type' => 'checkbox',
      '#title' => $this->t(
        'I have read and agree with the @privacy_policy.',
        [
          '@privacy_policy' => Link::createFromRoute($this->t('Discover Boating Privacy Policy'), 'entity.node.canonical', ['node' => 17906], ['attributes' => ['target' => '_blank']])
            ->toString(),
        ]),
      '#required' => TRUE,
      '#prefix' => '<div class="full-width">',
      '#suffix' => '</div>',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Sign Up',
      '#attributes' => [
        'data-gtm-tracking' => 'Form - Beginners Guide|Dealers & Manufacturers  - Submit',
      ],
      '#prefix' => '<div class="submit-container full-width">',
      '#suffix' => '<p>By signing up, you agree to receive information from marine manufacturers or dealers with news, updates and promotions.<br/><span class="text-small">You can withdraw your consent at any time. Please refer to our <a href="/privacy-policy" target="_blank">privacy policy</a> or <a href="/contact" target="_blank">contact us</a> for more details.</span></p></div>',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!$form_state->isValueEmpty('agree_boat_types')) {
      if ($form_state->isValueEmpty('own_a_boat')) {
        $form_state->setErrorByName('own_a_boat', $this->t('Indicate if you own a boat'));
      }
      if (empty(array_filter($form_state->getValue('activities')))) {
        $form_state->setErrorByName('activities', $this->t('Indicate what activities you are interested in'));
      }
      if ($form_state->getValue('interested_in_specific_boat_types') !== 'no') {
        if ($form_state->isValueEmpty('interested_in_specific_boat_types')) {
          $form_state->setErrorByName('interested_in_specific_boat_types', $this->t('Indicate if you are interested in a specific boat type'));
        }
        elseif (empty(array_filter($form_state->getValue('boat_types')))) {
          $form_state->setErrorByName('boat_types', $this->t('Indicate preferred boat types'));
        }
      }
      if ($form_state->isValueEmpty('when_purchase')) {
        $form_state->setErrorByName('when_purchase', $this->t('Indicate when you plan to purchase a new boat'));
      }
    }

    if (FALSE === $this->validateAddress(
      $form_state->getValue('address1'),
      $form_state->getValue('address2'),
      $form_state->getValue('city'),
      $form_state->getValue('state'),
      $form_state->getValue('zip_code'),
      $form_state->getValue('country')
    )) {
      $form_state->setErrorByName('address1', $this->t('The address given could not be validated.'));
    }

    // If all normal form validation has succeeded, send request to NMMA, then
    // set more validation errors or success.
    if (!empty($form_state->getErrors())) {
      return;
    }

    $result = $this->client->post('https://offln.discoverboating.com/marketing/beginnersguideISO.aspx', [
      'body' => $this->buildPostBody($form_state),
      'headers' => [
        'Accept' => 'text/javascript, text/html, application/xml, text/xml, */*',
        'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
      ],
      'http_errors' => FALSE,
    ]);
    $string_content = $result->getBody()->getContents();
    if (200 === $result->getStatusCode()) {
      $content = Json::decode($string_content);
      if (NULL === $content) {
        $this->logger('boating_guide_lead_submission')->error('The results of the request were not proper JSON: @content.', ['@content' => $string_content]);
        $form_state->setErrorByName('first_name', $this->t('An error occurred when attempting to process your request.'));
      }
      else {
        if (!empty($content['errors'])) {
          foreach ($content['errors'] as $error) {
            switch ($error) {
              case 'You must read and agree with Discover Boating Privacy Policy':
                $element_name = 'agree_privacy';
                break;

              case 'This address cannot be validated':
                $element_name = 'address1';
                break;

              case 'Indicate what activities you are interested in':
                $element_name = 'activities';
                break;

              case 'Indicate when do you plan to purchase a new boat':
                $element_name = 'when_purchase';
                break;

              case 'Indicate prefered boat types':
                $element_name = 'boat_types';
                break;

              case "Specify if you know the type of the boat you're going to buy":
                $element_name = 'interested_in_specific_boat_types';
                break;

              case 'Indicate if you own a boat':
                $element_name = 'own_a_boat';
                break;

              default:
                $element_name = 'address1';
                break;

            }
            $form_state->setErrorByName($element_name, $error);
            drupal_set_message($error, 'error');
          }
        }
      }
    }
    else {
      $form_state->setErrorByName('first_name', $this->t('An error occurred when attempting to process your request.'));
      $this->logger('boating_guide_lead_submission')->error('An error was returned: @content.', ['@content' => $string_content]);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('Thanks for signing up for your free copy of "A Beginner’s Guide to Boating."'));
    $this->logger('boating_guide_lead_submission')
      ->debug($this->t('A lead has been submitted: <pre>@lead</pre>.', ['@lead' => print_r($this->getLead($form_state), 1)]));
    if (!$form_state->isValueEmpty('agree_newsletter')) {
      $this->logger('boating_guide_email_subscription')
        ->debug($this->t('Email subscription: <pre>@email</pre>.', ['@email' => print_r($this->getEmail($form_state), 1)]));
    }
    // $form_state->setRedirectUrl($this->getRedirect());
  }

  /**
   * Get the form redirect.
   *
   * @return \Drupal\Core\Url
   *   The form redirect.
   */
  protected function getRedirect() {
    return Url::fromRoute('<front>');
  }

  /**
   * Build the request that we send to the old DB form.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The post body string.
   */
  protected function buildPostBody(FormStateInterface $form_state) {
    $body = [
      'FirstName' => ucfirst(trim($form_state->getValue('first_name'))),
      'LastName' => ucfirst(trim($form_state->getValue('last_name'))),
      'Address1' => trim($form_state->getValue('address1')),
      'Address2' => trim($form_state->getValue('address2')),
      'Country' => $form_state->getValue('country'),
      'City' => trim($form_state->getValue('city')),
      'State' => $form_state->getValue('state'),
      'ZipCode' => trim($form_state->getValue('zip_code')),
      'Email' => strtolower($form_state->getValue('email_address')),
      'Phone' => strtolower($form_state->getValue('phone_number')),
      'Option3' => $form_state->getValue('agree_privacy') ? 'on' : '',
    ];
    if ($form_state->getValue('agree_newsletter')) {
      $body['Option1'] = 'on';
    }
    if ($form_state->getValue('agree_boat_types')) {
      $body['Option2'] = 'on';
      if ($form_state->getValue('own_a_boat')) {
        $body['OwnABoat'] = $form_state->getValue('own_a_boat') === 'yes' ? 'true' : 'false';
      }
      $activities = implode(',', array_filter(array_values($form_state->getValue('activities'))));
      if (!empty($activities)) {
        $body['Activities'] = $activities;
      }
      $which = $form_state->getValue('interested_in_specific_boat_types') === 'yes' ? TRUE : FALSE;
      if ($form_state->getValue('interested_in_specific_boat_types')) {
        $body['Which'] = $which ? 'true' : 'false';
        $boat_types = implode(',', array_filter(array_values($form_state->getValue('boat_types'))));
        if ($which && !empty($boat_types)) {
          $body['ProductCategories'] = $boat_types;
        }
      }
      $body['When'] = $form_state->getValue('when_purchase');
    }
    return http_build_query($body, '', '&');
  }

  /**
   * Retrieve the users address.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The users address.
   */
  protected function getAddress(FormStateInterface $form_state) {
    return [
      'Address' => trim($form_state->getValue('address1')),
      'Address2' => trim($form_state->getValue('address2')),
      'City' => trim($form_state->getValue('city')),
      'State' => $form_state->getValue('state'),
      'PostalCode' => trim($form_state->getValue('zip_code')),
      'CountryId' => $form_state->getValue('country'),
      'Country' => (int) $form_state->getValue('country') === self::US ? 'US' : 'CA',
    ];
  }

  /**
   * Retrieve the values needed to submit a lead.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The values needed to submit a lead.
   */
  protected function getLead(FormStateInterface $form_state) {
    $opt_in_manufactures = (bool) $form_state->getValue('agree_boat_types');
    $lead = [
      'FirstName' => ucfirst(trim($form_state->getValue('first_name'))),
      'LastName' => ucfirst(trim($form_state->getValue('last_name'))),
      'Email' => strtolower($form_state->getValue('email_address')),
      'Phone' => strtolower($form_state->getValue('phone_number')),
      'Address' => $this->getAddress($form_state),
      'OptInManufacturers' => $opt_in_manufactures,
      'VisitorId' => '',
      'Status' => $opt_in_manufactures ? 'hot' : 'cold',
    ];
    if ($opt_in_manufactures) {
      $lead['Demographic_153'] = $form_state->getValue('own_a_boat') === 'yes' ? 1 : 0;
      $lead['Activities'] = array_filter($form_state->getValue('activities'));
      $lead['ProductCategories'] = array_filter($form_state->getValue('boat_types'));
      $lead['Demographic_154'] = $form_state->getValue('when_purchase');
    }
    return $lead;
  }

  /**
   * Retrieve the values need to submit an email.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   Values needed to subscribe to email list.
   */
  protected function getEmail(FormStateInterface $form_state) {
    $address = $this->getAddress($form_state);
    $lead = $this->getLead($form_state);
    return [
      'email' => $lead['Email'],
      'firstName' => $lead['FirstName'],
      'lastName' => $lead['LastName'],
      'address' => trim($address['Address'] . ' ' . $address['Address2']),
      'city' => $address['City'],
      'state' => $address['State'],
      'postalCode' => $address['PostalCode'],
      'country' => (int) $address['CountryId'] === self::US ? 'United States' : 'Canada',
      'LIST_ID' => $address['CountryId'],
    ];
  }

}
