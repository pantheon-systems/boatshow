<?php
namespace Drupal\nmma_boating_guide_download\Plugin\WebformHandler;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\webformSubmissionInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


/**
 * Form submission handler.
 *
 * @WebformHandler(
 *   id = "nmma_boating_guide_download_form_handler",
 *   label = @Translation("Boating Guide Download Boat Buyers Guide Handler form handler"),
 *   category = @Translation("Form Handler"),
 *   description = @Translation("Download the DiscoverBoating Boat Buying Guide"),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class NmmaBoatingGuideDownloadHandler extends WebformHandlerBase {

     /**
       * {@inheritdoc}
       */

     public function defaultConfiguration() {
        return [
            'the_file_to_download' => 'public://2020-06/DBBoatBuyingGuide.pdf',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
        $form['the_file_to_download'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Download file'),
            '#description' => $this->t('The Download File'),
            '#default_value' => $this->configuration['the_file_to_download'],
            '#required' => TRUE,
            '#attributes' => array('readonly' => 'readonly'),
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
        parent::validateForm($form, $form_state, $webform_submission);
              $values = $webform_submission->getData();
              // Get the file to download
              $this_download = $this->configuration['the_file_to_download'];

              $bFileExists =  file_exists($this_download);

               if (!$bFileExists ) {
               // It exists so do something with it.
               $form_state->setErrorByName('the_file_to_download', $this->t('file does not exist'));

             } else {
               \Drupal::logger('nmma boating guide download')->notice('thefileexists?');
             }
    }

  /**
   * {@inheritdoc}
   */
  public function confirmForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
    if ($form_state->get('api_submission_success') === TRUE) {

        // Get an array of the values from the submission.
        parent::submitForm($form, $form_state, $webform_submission);

        $values = $webform_submission->getData();

        // Get the file to download
        $this_download = $this->configuration['the_file_to_download'];

        \Drupal::logger('nmma boating guide download')->notice($this_download);
        $response = new BinaryFileResponse(drupal_realpath($this_download));
        $response->setContentDisposition(
          ResponseHeaderBag::DISPOSITION_ATTACHMENT,
          'DBBoatBuyingGuide.pdf'
        );
        drupal_set_message($this->t('Thanks for signing up for your free copy of "Discover Boating Boat Buyers Guide."'));
        $form_state->setResponse($response);

    }
  }
}
