<?php

namespace Drupal\Tests\nmmacontentaccess\Kernel;

use Drupal\nmmacontentaccess\Entity\NmmaNode;
use Drupal\KernelTests\KernelTestBase;

/**
 * Test basic CRUD operations for our NmmaNode entity type.
 *
 * @group nmmacontentaccess
 * @group examples
 *
 * @ingroup nmmacontentaccess
 */
class NmmaNodeTest extends KernelTestBase {

  protected static $modules = ['nmmacontentaccess', 'options', 'user'];

  /**
   * Basic CRUD operations on a NmmaNode entity.
   */
  public function testEntity() {
    $this->installEntitySchema('nmmacontentaccess_node');
    $entity = NmmaNode::create([
      'name' => 'Name',
      //'first_name' => 'Firstname',
      'user_id' => 0,
      'role' => 'user',
    ]);
    $this->assertNotNull($entity);
    $this->assertEquals(SAVED_NEW, $entity->save());
    $this->assertEquals(SAVED_UPDATED, $entity->set('role', 'administrator')->save());
    $entity_id = $entity->id();
    $this->assertNotEmpty($entity_id);
    $entity->delete();
    $this->assertNull(NmmaNode::load($entity_id));
  }

}
