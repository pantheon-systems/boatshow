<?php

namespace Drupal\nmma_boatfinder_endpoint\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\taxonomy\Entity\Term;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;

/**
 * Provides a NMMA Resource.
 *
 * @RestResource(
 *   id = "nmma_boatfinder_resource",
 *   label = @Translation("NMMA Boatfinder Resource"),
 *   uri_paths = {
 *     "canonical" = "/nmma_boatfinder_endpoint/nmma_resource"
 *   }
 * )
 */
class NMMAResource extends ResourceBase {

  /**
   * Responds to entity GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Object with response.
   */
  public function get() {
    $response['BoatTypes'] = $this->formatBoatTerms();
    $response['Activities'] = $this->formatTerms('activities');
    $response['PropulsionTypes'] = $this->formatTerms('engine_types');
    return new ResourceResponse($response);
  }

  /**
   * Method to get boat finder IDs.
   *
   * @return object
   *   Object collection of entities
   */
  private function getTermIds(string $bundle = 'boat_types') {
    // Or $bundle='my_bundle_type';.
    $query = \Drupal::entityQuery('taxonomy_term');
    $query->condition('vid', $bundle);
    $entities = $query->execute();
    return $entities;
  }

  /**
   * Method to load multiple terms.
   *
   * @return object
   *   Object collection of terms
   */
  private function getTerms($bundle) {
    $ids = $this->getTermIds($bundle);
    $terms = Term::loadMultiple($ids);
    return $terms;
  }

  /**
   * Method to format the boat type terms for the JSON object.
   *
   * @return array
   *   Array of formatted terms.
   */
  private function formatBoatTerms() {
    $boat_terms = $this->getTerms('boat_types');
    $formatted_terms = [];
    foreach ($boat_terms as $boat_term) {
      if ($boat_term->field_boat_visible_in_finder->value == '1') {
        $term_id = $boat_term->tid->value;
        $title = $boat_term->name->value;
        $aliasManager = \Drupal::service('path.alias_manager');
        $alias = $aliasManager->getAliasByPath('/taxonomy/term/' . $term_id);
        $formatted_term['Id'] = (int) $term_id;
        $formatted_term['Name'] = $title;
        $formatted_term['Slug'] = $this->slugMaker($title);
        $formatted_term['PluralName'] = $boat_term->field_boat_type_plural->value;
        $formatted_term['BoatDetailsUrl'] = $alias;
        $tsr_img = $boat_term->get('field_boat_type_tsr_image')->getValue();
        if ($tsr_img) {
          $media = Media::load($tsr_img[0]['target_id']);
          $image_file = $media->get('image')->getValue();
          $file = File::load($image_file[0]['target_id']);
          $image_path = $file->getFileUri();
          $style = \Drupal::entityTypeManager()
            ->getStorage('image_style')
            ->load('cropped_grid_item');
          $formatted_term['Image'] = $style->buildUrl($image_path);
        }
        $formatted_term['Activities'] = [];
        if (!empty($boat_term->field_boat_type_activity_type)) {
          $formatted_term['Activities'] = $this->getRelations($boat_term->field_boat_type_activity_type);
        }
        $formatted_term['Attributes'] = $this->getAttributes($boat_term);
        if (!empty($boat_term->field_boat_type_engine_type)) {
          $formatted_term['PropulsionTypes'] = $this->getRelations($boat_term->field_boat_type_engine_type);
        }
        $formatted_terms[] = $formatted_term;
      }
    }
    return $formatted_terms;
  }

  /**
   * Method to format the propulsion type terms for the JSON object.
   *
   * @return array
   *   Array of formatted terms.
   */
  private function formatTerms($bundle) {
    $terms = $this->getTerms($bundle);
    $formatted_terms = [];

    foreach ($terms as $term) {
      $term_id = $term->tid->value;
      $title = $term->name->value;
      $description = $this->sanitizeString($term->description->value);
      $formatted_term['Id'] = (int) $term_id;
      $formatted_term['Name'] = $title;
      $formatted_term['Slug'] = $this->slugMaker($title);
      $formatted_term['ShortDescription'] = $description;
      $formatted_terms[] = $formatted_term;
    }
    return $formatted_terms;
  }

  /**
   * Helper method to format the Activity Field object into a useful array.
   *
   * @param object $reference_field
   *   Object that contains the field information.
   *
   * @return array
   *   Array that is formatted for the JSON response
   */
  private function getRelations($reference_field) {
    $full_referenced = [];
    foreach ($reference_field as $referenced) {
      $referenced_ids[] = $referenced->target_id;
    }
    if (isset($referenced_ids)) {
      foreach ($referenced_ids as $referenced_id) {
        $referenced_loaded = Term::load($referenced_id);
        $referenced_name = $referenced_loaded->getName();
        $full_referenced[] = [
          'name' => $referenced_name,
          'Id' => (int) $referenced_id,
        ];
      }
    }
    return $full_referenced;
  }

  /**
   * Get the attributes from the term object.
   *
   * @param object $term
   *   Term object.
   *
   * @return array
   *   The array formatted for the JSON return.
   */
  private function getAttributes($term) {
    // Attributes:  Maximum capacity, trailerable, Min length, Max length,
    // Min Price, Max Price.
    $attributes = [];
    if (isset($term->field_boat_type_passengers->value)) {
      $attributes[] = [
        'Name' => 'Maximum Capacity',
        'Value' => $term->field_boat_type_passengers->value,
        'Id' => (int) '1',
      ];
    }
    if (isset($term->field_boat_type_trailerable->value)) {
      if ($term->field_boat_type_trailerable->value == TRUE) {
        $trailerable = 'True';
      }
      else {
        $trailerable = 'False';
      }
      $attributes[] = [
        'Name' => 'Trailerable',
        'Value' => $trailerable,
        'Id' => (int) '2',
      ];
    }
    if (isset($term->field_boat_type_max_length->value)) {
      $attributes[] = [
        'Name' => 'Maximum Length',
        'Value' => $term->field_boat_type_max_length->value,
        'Id' => (int) '3',
      ];
    }
    if (isset($term->field_boat_type_min_length->value)) {
      $attributes[] = [
        'Name' => 'Minimum Length',
        'Value' => $term->field_boat_type_min_length->value,
        'Id' => (int) '4',
      ];
    }
    $attributes[] = [
      'Name' => 'Minimum Price',
      'Value' => '0',
      'Id' => (int) '6',
    ];
    $attributes[] = [
      'Name' => 'Maximum Price',
      'Value' => '100000000',
      'Id' => (int) '7',
    ];

    return $attributes;
  }

  /**
   * Helper method to clean up rich text.
   *
   * @param string $string
   *   Unsanitized string, usually from a rich text field.
   *
   * @return string
   *   Sanitized string for the JSON object.
   */
  private function sanitizeString($string) {
    $string = strip_tags($string);
    $string = trim($string);
    return $string;
  }

  /**
   * Helper method to create a machine friendly slug from the title.
   *
   * @param string $title
   *   Title of the term.
   *
   * @return string
   *   Slugified title.
   */
  private function slugMaker($title) {
    $needles = [' ', '/', '.'];
    $lowercase = mb_strtolower($title);
    $slug = str_replace($needles, '-', $lowercase);
    return $slug;
  }

}
