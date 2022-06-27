<?php

namespace Drupal\nmma_custom_pages;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;

/**
 * Utility class for working with common entity manipulation tasks.
 */
class EntityHelp {

  /**
   * Retrieve the referenced entity from a reference field.
   *
   * @param \Drupal\Core\Entity\ContentEntityBase $entity
   *   The source entity.
   * @param string $fieldName
   *   The reference field name.
   *
   * @return null|ContentEntityBase
   *   The referenced entity or NULL.
   */
  public static function getFieldEntityReference(ContentEntityBase $entity, $fieldName) {
    if (!self::hasFieldAndValue($entity, $fieldName)) {
      return NULL;
    }
    return $entity
      ->get($fieldName)
      ->first()
      ->get('entity')
      ->getTarget()
      ->getValue();
  }

  /**
   * Retrieve the file reference on a media field.
   *
   * @param \Drupal\media\Entity\Media $file
   *   The media entity.
   *
   * @return null|\Drupal\file\Entity\File
   *   The file entity or NULL.
   */
  public static function getMediaFile(Media $file) {
    if (!self::hasFieldAndValue($file, 'image')) {
      return NULL;
    }
    /** @var \Drupal\file\Entity\File $file */
    $file = self::getFieldEntityReference($file, 'image');
    if (!$file || !($file instanceof File)) {
      return NULL;
    }
    return $file;
  }

  /**
   * Retrieve the text value of a text field.
   *
   * @param \Drupal\Core\Entity\ContentEntityBase $entity
   *   The source entity.
   * @param string $fieldName
   *   The field name that holds the text field.
   *
   * @return null|string
   *   The value of the text field or NULL if the field does not exist or empty.
   *
   * @throws \Exception
   *   On unsupported field type.
   */
  public static function getTextValue(ContentEntityBase $entity, $fieldName) {
    if (!self::hasFieldAndValue($entity, $fieldName)) {
      return NULL;
    }

    $value = $entity
      ->get($fieldName)
      ->first()
      ->getValue();

    $field_type = $entity->get($fieldName)->getFieldDefinition()->getType();
    switch ($field_type) {
      case 'string':
      default:
        if (isset($value['format'])) {
          return check_markup($value['value'], $value['format']);
        }
        elseif (isset($value['value'])) {
          return $value['value'];
        }
        break;

      case 'link':
        return $value['title'];
    }

    throw new \Exception('Unsupported field ' . $field_type . ' for EntityHelp::getTextValue().');
  }

  /**
   * Retrieve the URI value of a link field.
   *
   * @param \Drupal\Core\Entity\ContentEntityBase $entity
   *   The source entity.
   * @param string $fieldName
   *   The field name that holds the text field.
   *
   * @return null|string
   *   The value of the text field or NULL if the field does not exist or empty.
   *
   * @throws \Exception
   *   On unsupported field type.
   */
  public static function getLinkUri(ContentEntityBase $entity, $fieldName) {
    if (!self::hasFieldAndValue($entity, $fieldName)) {
      return NULL;
    }

    $value = $entity
      ->get($fieldName)
      ->first()
      ->getValue();

    $field_type = $entity->get($fieldName)->getFieldDefinition()->getType();
    switch ($field_type) {
      case 'link':
        return $value['uri'];

    }

    throw new \Exception('Unsupported field ' . $field_type . ' for EntityHelp::getTextValue().');
  }

  /**
   * Determine if the field belongs to the entity and it has a value.
   *
   * @param \Drupal\Core\Entity\ContentEntityBase $entity
   *   The entity in question.
   * @param string $fieldName
   *   The field name on the entity.
   *
   * @return bool
   *   True if there and it has a value.
   */
  public static function hasFieldAndValue(ContentEntityBase $entity, $fieldName) {
    if ($entity->hasField($fieldName) && !$entity->get($fieldName)->isEmpty()) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Retrieve the full URL to an image for a field referenced.
   *
   * Supports file or media fields.
   *
   * @param \Drupal\Core\Entity\ContentEntityBase $entity
   *   The source entity.
   * @param string $fieldName
   *   The field name that holds the media entity reference.
   * @param string $imageStyle
   *   Optional field that allows the URL returned to be an image style.
   *
   * @return string|null
   *   The full URL to an image or NULL if reference is empty.
   *
   * @throws \Exception
   *   On unsupported field type.
   */
  public static function getEntityRefImageUrl(ContentEntityBase $entity, $fieldName, $imageStyle = '') {
    $referencedEntity = self::getFieldEntityReference(
      $entity,
      $fieldName
    );
    // If the referenced field was empty, return NULL.
    if (NULL === $referencedEntity) {
      return NULL;
    }
    if ($referencedEntity instanceof Media) {
      $file_entity = self::getMediaFile(
        $referencedEntity
      );
    }
    elseif ($referencedEntity instanceof File) {
      $file_entity = $referencedEntity;
    }
    else {
      throw new \Exception(sprintf('Invalid field reference of %s', get_class($referencedEntity)));
    }
    $image_url = '';
    if (NULL !== $file_entity) {
      $image_url = self::getFileUrl($file_entity, $imageStyle);
    }

    return $image_url;
  }

  /**
   * Retrieve the image URL of an image file.
   *
   * @param \Drupal\file\Entity\File $fileEntity
   *   The image file entity.
   * @param string $imageStyle
   *   Optional field that allows the URL returned to be an image style.
   *
   * @return string
   *   The full URL to an image.
   */
  public static function getFileUrl(File $fileEntity, $imageStyle = '') {
    $image_url = '';
    if (strlen($imageStyle)) {
      /** @var \Drupal\image\Entity\ImageStyle $style */
      $style_entity = \Drupal::entityTypeManager()->getStorage('image_style')->load(
        $imageStyle
      );
      if (NULL !== $style_entity) {
        $image_url = $style_entity->buildUrl($fileEntity->getFileUri());
      }
    }
    else {
      $image_url = $fileEntity->url();
    }

    return $image_url;
  }

}
