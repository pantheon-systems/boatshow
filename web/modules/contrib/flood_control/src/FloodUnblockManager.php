<?php

namespace Drupal\flood_control;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Flood\FloodInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides Flood Unblock actions.
 */
class FloodUnblockManager implements FloodUnblockManagerInterface {

  use StringTranslationTrait;

  /**
   * The Database Connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The Entity Type Manager Interface.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The Flood Interface.
   *
   * @var \Drupal\Core\Flood\FloodInterface
   */
  protected $flood;

  /**
   * The Immutable Config.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * FloodUnblockAdminForm constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Flood\FloodInterface $flood
   *   The flood interface.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The Config Factory Interface.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The Entity Type Manager Interface.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The Messenger Interface.
   */
  public function __construct(Connection $database, FloodInterface $flood, ConfigFactoryInterface $configFactory, EntityTypeManagerInterface $entityTypeManager, MessengerInterface $messenger) {
    $this->database = $database;
    $this->flood = $flood;
    $this->entityTypeManager = $entityTypeManager;
    $this->config = $configFactory->get('user.flood');
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public function fetchIdentifiers($results) {
    $identifiers = [];

    foreach ($results as $result) {

      // Sets ip as default value and adds to identifiers array.
      $identifiers[$result] = $result;

      // Sets location as value and adds to identifiers array.
      if (function_exists('smart_ip_get_location')) {
        $location = smart_ip_get_location($result);
        $location_string = sprintf(" (%s %s %s)", $location['city'], $location['region'], $location['country_code']);
        $identifiers[$result] = "$location_string ($result)";
      }

      // Sets link to user as value and adds to identifiers array.
      $parts = explode('-', $result);
      if (isset($parts[0]) && isset($parts[1])) {
        $uid = $parts[0];

        /** @var \Drupal\user\Entity\User $user */
        $user = $this->entityTypeManager->getStorage('user')
          ->load($uid);
        if (isset($user)) {
          $user_link = $user->toLink($user->getAccountName());
        }
        else {
          $user_link = $this->t('Deleted user: @user', ['@user' => $uid]);
        }
        $identifiers[$result] = $user_link;
      }

    }
    return $identifiers;
  }

  /**
   * {@inheritdoc}
   */
  public function floodUnblockClearEvent($fid) {
    $txn = $this->database->startTransaction('flood_unblock_clear');
    try {
      $query = $this->database->delete('flood')
        ->condition('fid', $fid);
      $success = $query->execute();
      if ($success) {
        $this->messenger->addMessage($this->t('Flood entries cleared.'), 'status', FALSE);
      }
    }
    catch (\Exception $e) {
      // Something went wrong somewhere, so roll back now.
      $txn->rollback();
      // Log the exception to watchdog.
      watchdog_exception('type', $e);
      $this->messenger->addMessage($this->t('Error: @error', ['@error' => (string) $e]), 'error');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getEvents() {
    return [
      'user.failed_login_ip' => [
        'type' => 'user',
        'label' => $this->t('User failed login IP'),
      ],
      'user.failed_login_user' => [
        'type' => 'user',
        'label' => $this->t('User failed login user'),
      ],
      'user.http_login' => [
        'type' => 'user',
        'label' => $this->t('User failed http login'),
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isBlocked($identifier, $event) {
    $type = $this->getEvents()[$event]['type'];
    switch ($type) {
      case 'user':
        return !$this->flood->isAllowed($event, $this->config->get('user_limit'), $this->config->get('user_window'), $identifier);

      case 'ip':
        return !$this->flood->isAllowed($event, $this->config->get('ip_limit'), $this->config->get('ip_window'), $identifier);
    }
    return FALSE;
  }

}
