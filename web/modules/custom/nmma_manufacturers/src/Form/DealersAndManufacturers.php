<?php

namespace Drupal\nmma_manufacturers\Form;

use Drupal\nmma_forms\Form\AddressBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Component\Serialization\Json;

/**
 * Class DealersAndManufacturers.
 */
class DealersAndManufacturers extends AddressBase {

  /**
   * A guzzle http client object.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * Calls the get values from URL.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * BoatingGuide constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   Request object (GET).
   * @param \GuzzleHttp\Client $http_client
   *   The http_client.
   */
  public function __construct(RequestStack $request_stack, Client $http_client) {
    $this->httpClient = $http_client;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('http_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dealers_and_manufacturers';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $nmma_id = 0) {
    $form['#prefix'] = $this->mfrFormPrefix();
    $form['#suffix'] = '</div>';
    $form['nmma_id'] = [
      '#type' => 'value',
      '#value' => $nmma_id,
    ];
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#required' => TRUE,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];
    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#required' => TRUE,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];
    $form['address1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address 1'),
      '#required' => TRUE,
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];
    $form['address2'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address 2'),
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
      '#empty_option' => 'State',
      '#required' => TRUE,
      '#prefix' => '<div id="states-wrapper" class="half-width">',
      '#suffix' => '</div><div class="blank"></div>',
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
    ];
    $form['zip_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Zip Code'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];
    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone Number'),
    ];
    $form['own_a_boat'] = [
      '#type' => 'radios',
      '#title' => $this->t('Do you own a boat?'),
      '#options' => [
        'yes' => $this->t('Of Course'),
        'no' => $this->t("Not Yet"),
      ],
      '#required' => TRUE,
      '#prefix' => '<div class="half-width">',
      '#suffix' => '</div>',
    ];

    $when_purchase_options = [
      'AsSoonAsPossible' => $this->t('As soon as possible'),
      'InNext3Months' => $this->t('In the next 3 months'),
      'InNext6Months' => $this->t('In the next 6 months'),
      'InAYear' => $this->t('In about a year from now'),
      'Someday' => $this->t('Someday in the future'),
      'NotSure' => $this->t("I don't know"),
    ];
    $form['when_purchase'] = [
      '#type' => 'select',
      '#title' => $this->t('When do you plan to purchase a new boat?'),
      '#empty_value' => '',
      '#empty_option' => '--',
      '#options' => $when_purchase_options,
      '#prefix' => '<div class="half-width no-pad">',
      '#suffix' => '</div>',
    ];

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

    $form['categoryId'] = [
      '#type' => 'hidden',
      '#default_value' => $this->requestStack->getCurrentRequest()->query->get('typeid'),
    ];

    $form['IsContactDealer'] = [
      '#type' => 'hidden',
      '#default_value' => '1',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
      '#attributes' => [
        'data-gtm-tracking' => 'Form - Dealer Sign Up|Boat Types  - Submit',
      ],
      '#prefix' => '<div class="submit-container full-width">',
      '#suffix' => '<p>By clicking SEND, you agree to receive information from marine manufacturers or dealers with news, updates and promotions.<br/><span class="text-small">You can withdraw your consent at any time. Please refer to our <a href="/privacy-policy" target="_blank">privacy policy</a> or <a href="/contact" target="_blank">contact us</a> for more details.</span></p></div>',
    ];

    honeypot_add_form_protection(
      $form,
      $form_state,
      ['honeypot']
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->isValueEmpty('when_purchase')) {
      $form_state->setErrorByName('when_purchase', $this->t('Indicate when you plan to purchase a new boat.'));
    }
    if (!is_numeric($form_state->getValue('categoryId'))) {
      $form_state->setErrorByName('first_name', $this->t('An error occurred when attempting to process your request.'));
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

    $result = $this->httpClient->post('https://offln.discoverboating.com/marketing/beginnersguideISO.aspx', [
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
        $this->logger('dealer_contact_submission')->error('The results of the request were not proper JSON: @content.', ['@content' => $string_content]);
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
      $this->logger('dealer_contact_submission')->error('An error was returned: @content.', ['@content' => $string_content]);
    }

    $this->logger('dealer_contact_submission')->info('Submission Result: @content.', ['@content' => $string_content]);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->logger('dealer_contact_submission')
      ->debug($this->t('A dealer contact request was submitted: <pre>@request</pre>.', ['@request' => print_r($this->getContactRequest($form_state), 1)]));

    $form_state->setRedirect('nmma_manufacturers.dealers_and_manufacturers_form_thanks');
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
      'Email' => strtolower($form_state->getValue('email')),
      'PhoneNumber' => strtolower($form_state->getValue('phone_number')),
      'IsContactDealer' => $form_state->getValue('IsContactDealer'),
      'CategoryId' => trim($form_state->getValue('categoryId')),
      'Option3' => $form_state->getValue('agree_privacy') ? 'on' : '',
    ];
    if ($form_state->getValue('agree_newsletter')) {
      $body['Option1'] = 'on';
    }
    $body['OwnershipStatus'] = 'NeverOwned';
    if ($form_state->getValue('own_a_boat') === 'yes') {
      $body['OwnershipStatus'] = 'OwnNow';
    }

    $body['PurchasingTermEstimate'] = $form_state->getValue('when_purchase');
    $encoded_values = http_build_query($body, '', '&');
    $this->logger('dealer_contact_submission')->debug($this->t('A dealer contact request was submitted: <pre>@request</pre>.', ['@request' => print_r($encoded_values, 1)]));

    return $encoded_values;
  }

  /**
   * Returns form prefix.
   */
  private function mfrFormPrefix() {
    $prefix = '<div id="mfr-contact-form-wrapper">';
    $prefix .= '<section class="section-header">';
    $prefix .= '<h2>' . $this->t('Have a dealer or manufacturer contact me') .
      '</h2>';
    $prefix .= '<p>' . $this->t('Sign up here and get in touch with a boat dealer or manufacturer in your area.') . '</p>';
    $prefix .= '</section>';
    return $prefix;
  }

  /**
   * Ajax callback to rebuild the states dropdown.
   *
   * @param array $form
   *   The current form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The form element being rebuilt.
   */
  public function updateStates(array $form, FormStateInterface $form_state) {
    $form['state']['#options'] = $this->states($form_state->getValue('country'));
    $form['state']['#options'] = array_merge(['' => 'State'], $form['state']['#options']);
    $form_state->unsetValue('country');
    return $form['state'];
  }

  /**
   * Formats contact details for logging.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form values in.
   *
   * @return array
   *   Contact array for parsing in logs.
   */
  public function getContactRequest(FormStateInterface $form_state) {
    $body = [
      'FirstName' => ucfirst(trim($form_state->getValue('first_name'))),
      'LastName' => ucfirst(trim($form_state->getValue('last_name'))),
      'Address1' => trim($form_state->getValue('address1')),
      'Address2' => trim($form_state->getValue('address2')),
      'Country' => $form_state->getValue('country'),
      'City' => trim($form_state->getValue('city')),
      'State' => $form_state->getValue('state'),
      'ZipCode' => trim($form_state->getValue('zip_code')),
      'Email' => strtolower($form_state->getValue('email')),
      'PhoneNumber' => strtolower($form_state->getValue('phone_number')),
      'IsContactDealer' => '1',
      'CategoryId' => trim($form_state->getValue('categoryId')),
      'Option3' => $form_state->getValue('agree_privacy') ? 'on' : '',
    ];
    if ($form_state->getValue('agree_newsletter')) {
      $body['Option1'] = 'on';
    }
    $body['OwnershipStatus'] = 'NeverOwned';
    if ($form_state->getValue('own_a_boat') === 'yes') {
      $body['OwnershipStatus'] = 'OwnNow';
    }

    $body['PurchasingTermEstimate'] = $form_state->getValue('when_purchase');
    return $body;
  }

}
