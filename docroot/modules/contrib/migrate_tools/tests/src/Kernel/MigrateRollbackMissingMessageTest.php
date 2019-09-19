<?php

namespace Drupal\Tests\migrate_tools\Kernel;

use Drupal\Tests\migrate\Kernel\MigrateTestBase;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_tools\MigrateExecutable;

/**
 * Tests messages are added when trying to rollback items missing from source.
 *
 * @group migrate
 */
class MigrateRollbackMissingMessageTest extends MigrateTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['migrate_tools'];

  /**
   * The stub migration used in the tests.
   *
   * @var \Drupal\migrate\Plugin\MigrationInterface
   */
  protected $migration;

  /**
   * The migrate executable used on tests.
   *
   * @var \Drupal\migrate_tools\MigrateExecutable
   */
  protected $migrateExecutable;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    // We use vocabularies to demonstrate importing and rolling back
    // configuration entities.
    $vocabulary_data_rows = [
      1 => ['id' => '1', 'name' => 'categories', 'weight' => '2'],
    ];

    $this->migration = $this->createMigration('import', $vocabulary_data_rows);
    $this->migrateExecutable = new MigrateExecutable($this->migration, $this);
  }

  /**
   * Tests non-syncable error message is added.
   */
  public function testNonSyncableSource() {
    // Rollback.
    $this->startCollectingMessages();
    $this->migrateExecutable->rollbackMissingItems();

    $count = 0;
    foreach ($this->migrateMessages as $type => $messages) {
      foreach ($messages as $message) {
        $count++;
        $this->assertEqual("Migration 'import' does not support rolling back items missing from the source", $message->render());
        $this->assertEqual($type, 'error');
      }
    }
    // There should be only the one message.
    $this->assertEqual($count, 1);
  }

  /**
   * Tests non-idle error message is added.
   */
  public function testNotIdle() {
    $this->migration->setStatus(MigrationInterface::STATUS_STOPPING);
    $this->startCollectingMessages();
    // Rollback.
    $this->migrateExecutable->rollbackMissingItems();

    $count = 0;
    foreach ($this->migrateMessages as $type => $messages) {
      foreach ($messages as $message) {
        $count++;
        $this->assertEqual("Migration 'import' is busy with another operation: " . $this->migration->getStatusLabel(), $message->render());
        $this->assertEqual($type, 'error');
      }
    }
    // There should be only the one message.
    $this->assertEqual($count, 1);
  }

  /**
   * Helper to create a vocabulary migration with given data.
   *
   * @param string $id
   *   An migration id.
   * @param array $data
   *   Data for the embedded data source plugin for a vocabulary migration.
   *
   * @return \Drupal\migrate\Plugin\MigrationInterface
   *   A vocabulary migration stub.
   */
  protected function createMigration($id, array $data) {
    $ids = ['id' => ['type' => 'integer']];
    $definition = [
      'id' => $id,
      'migration_tags' => ['Import and rollback test'],
      'source' => [
        'plugin' => 'embedded_data',
        'data_rows' => $data,
        'ids' => $ids,
      ],
      'process' => [
        'vid' => 'id',
        'name' => 'name',
        'weight' => 'weight',
      ],
      'destination' => ['plugin' => 'entity:taxonomy_vocabulary'],
    ];

    $this->migration = \Drupal::service('plugin.manager.migration')
      ->createStubMigration($definition);
    return $this->migration;
  }

}
