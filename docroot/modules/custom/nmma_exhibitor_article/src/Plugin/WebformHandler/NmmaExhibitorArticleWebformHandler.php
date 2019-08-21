<?php

namespace Drupal\nmma_exhibitor_article\Plugin\WebformHandler;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\webform\WebformInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\webformSubmissionInterface;
use Drupal\webform\Entity\WebformSubmission;


/**
 * Create a new Article node from a webform submission.
 *
 * @WebformHandler(
 *   id = "exhibitor_article_from_webform",
 *   label = @Translation("Exhibitor Article on Submit"),
 *   category = @Translation("Content"),
 *   description = @Translation("Creates a new Exhibitor News Article node from Webform Submissions."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */

class NmmaExhibitorArticleWebformHandler extends WebformHandlerBase {

  public function submitForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {

    // Get an array of form field values.
    $submission_array = $webform_submission->getData();

    $title = $submission_array['article_title'];
    $body = $submission_array['article_body']['value'];
    $featured_image_file_id = $submission_array['featured_image'];

    $media_value = [];

    if (!empty($featured_image_file_id)) {
      $media = \Drupal\media\Entity\Media::create([
        'bundle' => 'image',
        'name' => 'Featured image from webform_submission '. $webform_submission->id(),
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
      'type' => 'article',
      'title' => $title,
      'status' => 0,
      'field_article_image' => $media_value,
      'field_article_type' => [
        [
          'target_id' => 1521 //Exhibitor term
        ]
      ],
      'field_article_body' => [
        'value' => $body,
        'format' => 'restricted' //This can be updated by the content editor later
      ],
      'created' => strtotime($submission_array['article_date'])
    ]);

    $node->setUnpublished();

    // Save the node.
    $node->save();

    $submission_array['created_nid'] = $node->id();
    $webform_submission->setData($submission_array);
  }

}
