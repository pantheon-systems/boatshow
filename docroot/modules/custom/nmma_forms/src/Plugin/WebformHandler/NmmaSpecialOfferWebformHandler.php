<?php

namespace Drupal\nmma_forms\Plugin\WebformHandler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\webformSubmissionInterface;

/**
 * Create a new Special Offer node from a webform submission.
 *
 * @WebformHandler(
 *   id = "special_offer_from_webform",
 *   label = @Translation("Special Offer on Submit"),
 *   category = @Translation("Content"),
 *   description = @Translation("Creates a new Special Offer node from Webform Submissions."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
class NmmaSpecialOfferWebformHandler extends WebformHandlerBase {

  public function submitForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {

    // Get an array of form field values.
    $submission_array = $webform_submission->getData();

    $title = $submission_array['special_offer_title'];
    $description = $submission_array['special_offer_description']['value'];
    $offer_type = $submission_array['special_offer_type'];
    $featured_image_file_id = $submission_array['featured_image'];
    $booth = $submission_array['special_offer_booth_location'];
    $exhibitor_id = $submission_array['exhibitor_name'];

    $media_value = [];

    if (!empty($featured_image_file_id)) {
      $media = \Drupal\media\Entity\Media::create([
        'bundle' => 'image',
        'name' => 'Special Offer Featured image from webform_submission '. $webform_submission->id(),
        'uid' => \Drupal::currentUser()->id(),
        'image' => [
          'target_id' => $featured_image_file_id,
        ],
      ]);

      $media->save();

      $media_value[] = [
        'target_id' => $media->id()
      ];
    }

    // Create the node.
    $node = Node::create([
      'type' => 'special_offer',
      'title' => $title,
      'status' => 0,
      'field_logo' => $media_value,
      'field_offer_type' => $offer_type,
      'field_booth' => $booth,
      'field_exhibitor' => [
        'target_id' => $exhibitor_id
      ],
      'body' => [
        'value' => $description,
        'format' => 'restricted' //This can be updated by the content editor later
      ],
    ]);

    $node->setUnpublished();

    // Save the node.
    $node->save();

    $submission_array['created_nid'] = $node->id();
    $webform_submission->setData($submission_array);
  }

  /**
   * {@inheritdoc}
   *
   *  Validate offer_type field to make sure it's one of the available options
   */
  public function validateForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
    $offer_type = $form_state->getValue('special_offer_type');

    if (!in_array($offer_type, ['job', 'deal'])) {
      $form_state->setErrorByName('special_offer_type', $this->t('Offer type not valid.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    $submission_data = $webform_submission->getData();
    if (isset($submission_data['created_nid'])) {
      $node = Node::load($submission_data['created_nid']);

      if ($node instanceof \Drupal\node\NodeInterface && $node->hasField('field_webform_submission_id')) {
        $node->set('field_webform_submission_id', $webform_submission->id());
        $node->save();
      }
    }
  }
}
