<?php

namespace Drupal\Tests\migrate_tools\Kernel;

use Drupal\Tests\migrate\Kernel\MigrateTestBase;
use Drupal\migrate_tools\MigrateExecutable;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Tests that a missing source row is removed.
 *
 * @group migrate
 */
class MigrateRollbackMissingTest extends MigrateTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'field',
    'migrate_plus',
    'migrate_tools',
    'taxonomy',
    'text',
    'user',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->installEntitySchema('user');
    $this->installEntitySchema('taxonomy_vocabulary');
    $this->installEntitySchema('taxonomy_term');
    $this->installConfig(['taxonomy']);
  }

  /**
   * Tests rolling back configuration and content entities.
   */
  public function testRollbackMissingData() {
    // We use vocabularies to demonstrate importing and rolling back
    // configuration entities.
    $vocabulary_data_rows = [
      1 => ['id' => '1', 'name' => 'categories', 'weight' => '2'],
      2 => ['id' => '2', 'name' => 'tags', 'weight' => '1'],
      3 => ['id' => '3', 'name' => 'trees', 'weight' => '-1'],
    ];

    /** @var \Drupal\migrate\Plugin\MigrationInterface $vocabulary_migration */
    $vocabulary_migration = $this->createMigration('import', $vocabulary_data_rows);
    $executable = new MigrateExecutable($vocabulary_migration, $this);
    $executable->import();

    foreach ([1, 2, 3] as $vid) {
      /** @var \Drupal\taxonomy\Entity\Vocabulary $vocabulary */
      $vocabulary = Vocabulary::load($vid);
      $this->assertTrue($vocabulary);
    }

    // Remove vocabulary 2 from the data source, and update the migration.
    unset($vocabulary_data_rows[2]);
    $vocabulary_migration = $this->createMigration('import', $vocabulary_data_rows);
    $vocabulary_id_map = $vocabulary_migration->getIdMap();

    // Rollback.
    $rollback_executable = new MigrateExecutable($vocabulary_migration, $this);
    $rollback_executable->rollbackMissingItems();

    // Test that vocabulary 2 has been rolled back.
    $vocabulary = Vocabulary::load(2);
    $this->assertFalse($vocabulary);
    $map_row = $vocabulary_id_map->getRowBySource(['id' => 2]);
    $this->assertNull($map_row['destid1']);

    // Test that vocabulary 1 and 3 have not been rolled back.
    foreach ([1, 3] as $vid) {
      $vocabulary = Vocabulary::load($vid);
      $this->assertTrue($vocabulary);
      $map_row = $vocabulary_id_map->getRowBySource(['id' => $vid]);
      $this->assertNotNull($map_row['destid1']);
    }
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
        'plugin' => 'syncable_embedded_data',
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

    /** @var \Drupal\migrate\Plugin\MigrationInterface $vocabulary_migration */
    $vocabulary_migration = \Drupal::service('plugin.manager.migration')
      ->createStubMigration($definition);
    return $vocabulary_migration;
  }

}
