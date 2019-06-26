<?php

namespace Drupal\nmma_forms\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a base to work off of for address fielded forms.
 */
abstract class AddressBase extends FormBase {

  /**
   * Country code for US.
   *
   * @var int
   */
  const US = 223;

  /**
   * Country code for canda.
   *
   * @var int
   */
  const CANADA = 38;

  /**
   * Retrieve the country options.
   *
   * @return array
   *   A list of countries.
   */
  protected function countries() {
    return [self::US => $this->t('United States'), self::CANADA => $this->t('Canada')];
  }

  /**
   * State options.
   *
   * @var int $country_code
   *   The country code constant.
   * @var string $values
   *   Set 'initials' for initial values and 'id' for the numeric ID.
   *
   * @return array
   *   A list of US states.
   */
  protected function states($country_code, $values = 'initials') {
    switch ($country_code) {
      case self::US:
        $initials = [
          '1' => 'AL',
          '47' => 'AK',
          '2' => 'AZ',
          '3' => 'AR',
          '4' => 'CA',
          '5' => 'CO',
          '6' => 'CT',
          '49' => 'DE',
          '44' => 'DC',
          '7' => 'FL',
          '8' => 'GA',
          '65' => 'GU',
          '9' => 'HI',
          '10' => 'ID',
          '11' => 'IL',
          '12' => 'IN',
          '13' => 'IA',
          '14' => 'KS',
          '15' => 'KY',
          '16' => 'LA',
          '17' => 'ME',
          '18' => 'MD',
          '19' => 'MA',
          '20' => 'MI',
          '21' => 'MN',
          '22' => 'MS',
          '23' => 'MO',
          '50' => 'MT',
          '24' => 'NE',
          '25' => 'NV',
          '26' => 'NH',
          '27' => 'NJ',
          '51' => 'NM',
          '28' => 'NY',
          '29' => 'NC',
          '30' => 'ND',
          '31' => 'OH',
          '32' => 'OK',
          '33' => 'OR',
          '34' => 'PA',
          '35' => 'RI',
          '36' => 'SC',
          '37' => 'SD',
          '38' => 'TN',
          '39' => 'TX',
          '40' => 'UT',
          '41' => 'VT',
          '42' => 'VA',
          '43' => 'WA',
          '45' => 'WV',
          '46' => 'WI',
          '48' => 'WY',
        ];
        break;

      case self::CANADA:
        $initials = [
          '52' => 'AB',
          '53' => 'BC',
          '54' => 'MB',
          '55' => 'NB',
          '56' => 'NL',
          '57' => 'NT',
          '58' => 'NS',
          '59' => 'NU',
          '60' => 'ON',
          '61' => 'PE',
          '62' => 'QC',
          '63' => 'SK',
          '64' => 'YT',
        ];
        break;

      default:
        $initials = [];
        break;

    }
    if ($values === 'id') {
      return $initials;
    }
    return array_combine(array_values($initials), array_values($initials));
  }

  /**
   * Determine if this address is valid.
   *
   * @todo Actually do something to validate the address.
   *
   * @param string $address1
   *   Main address line.
   * @param string $address2
   *   Second line of address.
   * @param string $city
   *   The City.
   * @param string $state
   *   The state 2 letter abv.
   * @param string $postal_code
   *   The zip code.
   * @param string $country
   *   Full country name.
   *
   * @return bool
   *   If a valid address was given.
   */
  protected function validateAddress($address1, $address2, $city, $state, $postal_code, $country) {
    return TRUE;
  }

  /**
   * Ajax callback to rebuild the states drop down.
   *
   * @param array $form
   *   The current form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The state form element being rebuilt.
   */
  protected function updateStates(array $form, FormStateInterface $form_state) {
    $form['state']['#options'] = $this->states($form_state->getValue('country'));
    $form['state']['#options'] = array_merge(['' => '--'], $form['state']['#options']);
    $form_state->unsetValue('country');
    return $form['state'];
  }

}
