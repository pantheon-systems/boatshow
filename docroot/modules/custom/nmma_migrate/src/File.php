<?php

namespace Drupal\nmma_migrate;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File as FileEntity;
use Drupal\Core\Messenger\MessengerInterface;
use Drush\Drupal\DrupalUtil;

/**
 * The NMMA migrate file service.
 *
 * @package Drupal\nmma_migrate
 */
class File {

  /**
   * Access media entities.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $mediaStorage;

  /**
   * Access the language manager service.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The messenger service.
   *
   * @var \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  protected $messenger;

  /**
   * Constructs a NmmaMigrateCommands object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   The entity type manager.
   *   The diff entity comparison service.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   Get the default language.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   *   If media media is not available.
   */
  public function __construct(EntityTypeManagerInterface $entity_manager, LanguageManagerInterface $language_manager, MessengerInterface $messenger) {
    $this->mediaStorage = $entity_manager->getStorage('media');
    $this->languageManager = $language_manager;
    $this->messenger = $messenger;
  }

  /**
   * Retrieve a remote image, save as file, attach to a media entity and return.
   *
   * This function is unique per path on disk, so if the same directory and
   * file name is given, the file and media entity will be re-used.
   *
   * @param string $remote_url
   *   The pull path of an image to retrieve.
   * @param string $alt
   *   The alt tag to save.
   * @param string $title
   *   The title tag to save.
   * @param string $destination_directory
   *   The directory to save to (pubic://some-dir/sub-dir).
   * @param string $destination_filename
   *   The file name to store as (my-file.jpg).
   *
   * @return \Drupal\media\Entity\Media
   *   Returns a Media entity on success.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException|\Exception
   *   Throws an exception on an error.
   */
  public function remoteImageToMediaImage($remote_url, $alt, $title, $destination_directory, $destination_filename) : Media {
    $file = $this->remoteImageToFile($remote_url, $destination_directory, $destination_filename);
    // If there is already a media entity with this file attached to it,
    // no need to update.
    $query = $this->mediaStorage->getQuery()
      ->condition('bundle', 'image')
      ->condition('image', $file->id());
    $entity_ids = $query->execute();
    if (!empty($entity_ids)) {
      $lastMediaId = array_pop($entity_ids);
      $imageMedia = $this->mediaStorage->load($lastMediaId);
    }
    else {
      // Create media entity with saved file.
      $imageMedia = Media::create([
        'bundle' => 'image',
        'uid' => 1,
        'langcode' => $this->languageManager
          ->getDefaultLanguage()
          ->getId(),
        'status' => 1,
        'image' => [
          'target_id' => $file->id(),
          'alt' => $alt,
          'title' => $title,
        ],
      ]);
      $imageMedia->save();
    }
    return $imageMedia;
  }

  /**
   * Retrieve a remote image and save as file.
   *
   * This function is unique per path on disk, so if the same directory and
   * file name is given, the file and media entity will be re-used.
   *
   * @param string $remote_url
   *   The pull path of an image to retrieve.
   * @param string $destination_directory
   *   The directory to save to (pubic://some-dir/sub-dir).
   * @param string $destination_filename
   *   The file name to store as (my-file.jpg).
   *
   * @return \Drupal\file\Entity\File
   *   Returns a File entity on success.
   *
   * @throws \Exception
   *   Throws an exception on an error.
   */
  public function remoteImageToFile($remote_url, $destination_directory, $destination_filename) : FileEntity {
    // Ensure that the directory has a trailing slash.
    $destination_directory = rtrim($destination_directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    if (FALSE !== strstr($destination_filename, DIRECTORY_SEPARATOR)) {
      throw new \Exception('The destination filename should not contain any directory separators, those should be in the destination directory.');
    }
    /** @var \Drupal\file\Entity\File|FALSE $file */
    $file = system_retrieve_file($remote_url, $destination_directory . $destination_filename, TRUE, FILE_EXISTS_REPLACE);
    if (FALSE == $file) {
      $messages = '';
      /** @var \Drupal\Core\Render\Markup $error */
      foreach ($this->messenger->messagesByType('error') as $error) {
        $messages .= DrupalUtil::drushRender($error) . "\n";
      }
      throw new \Exception(t('You might need to create the directory @dir manually in order to save files. Message: @message', ['@dir' => $destination_directory, '@message' => $messages]));
    }
    return $file;
  }

}
