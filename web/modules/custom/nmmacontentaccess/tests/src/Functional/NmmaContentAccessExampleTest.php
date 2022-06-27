<?php

namespace Drupal\Tests\nmmacontentaccess\Functional;

use Drupal\nmmacontentaccess\Entity\NmmaNode;
use Drupal\Tests\examples\Functional\ExamplesBrowserTestBase;
use Drupal\Core\Url;

/**
 * Tests the basic functions of the NmmaNodeAccess module.
 *
 * @ingroup nmmacontentaccess
 *
 * @group nmmacontentaccess
 * @group examples
 */
class NmmaContentAccessExampleTest extends ExamplesBrowserTestBase {

  public static $modules = ['nmmacontentaccess', 'block', 'field_ui'];

  /**
   * Basic tests for NmmaNodeAccess Example.
   */
  public function NmmaContentAccessExample() {
    $assert = $this->assertSession();

    $web_user = $this->drupalCreateUser([
      'add NmmaNodeAccess entity',
      'edit NmmaNodeAccess entity',
      'view NmmaNodeAccess entity',
      'delete NmmaNodeAccess entity',
      'administer NmmaNodeAccess entity',
      'administer nmmacontentaccess_node display',
      'administer nmmacontentaccess_node fields',
      'administer nmmacontentaccess_node form display',
    ]);

    // Anonymous User should not see the link to the listing.
    $assert->pageTextNotContains('NmmaNodeAccess Example');

    $this->drupalLogin($web_user);

    // Web_user user has the right to view listing.
    $assert->linkExists('NmmaNodeAccess Example');

    $this->clickLink('NmmaNodeAccess Example');

    // WebUser can add entity content.
    $assert->linkExists('Add NmmaNode');

    $this->clickLink(t('Add NmmaNode'));

    $assert->fieldValueEquals('name[0][value]', '');
    $assert->fieldValueEquals('name[0][value]', '');
    $assert->fieldValueEquals('name[0][value]', '');
    $assert->fieldValueEquals('name[0][value]', '');

    $user_ref = $web_user->name->value . ' (' . $web_user->id() . ')';
    $assert->fieldValueEquals('user_id[0][target_id]', $user_ref);

    // Post content, save an instance. Go back to list after saving.
    $edit = [
      'name[0][value]' => 'test name',
      //'first_name[0][value]' => 'test first name',
      'node_id[0][value]' => 'node id',
      'role' => 'administrator',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');

    // Entity listed.
    $assert->linkExists('Edit');
    $assert->linkExists('Delete');

    $this->clickLink('test name');

    // Entity shown.
    $assert->pageTextContains('test name');
    //$assert->pageTextContains('test first name');
    $assert->pageTextContains('administrator');
    $assert->linkExists('Add NmmaNode');
    $assert->linkExists('Edit');
    $assert->linkExists('Delete');

    // Delete the entity.
    $this->clickLink('Delete');

    // Confirm deletion.
    $assert->linkExists('Cancel');
    $this->drupalPostForm(NULL, [], 'Delete');

    // Back to list, must be empty.
    $assert->pageTextNotContains('test name');

    // Settings page.
    $this->drupalGet('admin/structure/nmmacontentaccess_node_settings');
    $assert->pageTextContains('NmmaNode Settings');

    // Make sure the field manipulation links are available.
    $assert->linkExists('Settings');
    $assert->linkExists('Manage fields');
    $assert->linkExists('Manage form display');
    $assert->linkExists('Manage display');
  }

  /**
   * Test all paths exposed by the module, by permission.
   */
  public function testPaths() {
    $assert = $this->assertSession();

    // Generate a NmmaNode so that we can test the paths against it.
    $contact = NmmaNode::create([
      'name' => 'somename',
      //'first_name' => 'Joe',
      node_id => '99999'
      'role' => 'administrator',
    ]);
    $contact->save();

    // Gather the test data.
    $data = $this->providerTestPaths($contact->id());

    // Run the tests.
    foreach ($data as $datum) {
      // drupalCreateUser() doesn't know what to do with an empty permission
      // array, so we help it out.
      if ($datum[2]) {
        $user = $this->drupalCreateUser([$datum[2]]);
        $this->drupalLogin($user);
      }
      else {
        $user = $this->drupalCreateUser();
        $this->drupalLogin($user);
      }
      $this->drupalGet($datum[1]);
      $assert->statusCodeEquals($datum[0]);
    }
  }

  /**
   * Data provider for testPaths.
   *
   * @param int $nmmanode_id
   *   The id of an existing NmmaNode entity.
   *
   * @return array
   *   Nested array of testing data. Arranged like this:
   *   - Expected response code.
   *   - Path to request.
   *   - Permission for the user.
   */
  protected function providerTestPaths($nmmanode_id) {
    return [
      [
        200,
        '/nmmacontentaccess_node/' . $nmmanode_id,
        'view contact entity',
      ],
      [
        403,
        '/nmmacontentaccess_node/' . $nmmanode_id,
        '',
      ],
      [
        200,
        '/nmmacontentaccess_node/list',
        'view NmmaNodeAccess entity',
      ],
      [
        403,
        '/nmmacontentaccess_node/list',
        '',
      ],
      [
        200,
        '/nmmacontentaccess_node/add',
        'add NmmaNodeAccess entity',
      ],
      [
        403,
        '/nmmacontentaccess_node/add',
        '',
      ],
      [
        200,
        '/nmmacontentaccess_node/' . $nmmanode_id . '/edit',
        'edit NmmaNodeAccess entity',
      ],
      [
        403,
        '/nmmacontentaccess_node/' . $nmmanode_id . '/edit',
        '',
      ],
      [
        200,
        '/nmmacontentaccess_node/' . $nmmanode_id . '/delete',
        'delete NmmaNodeAccess entity',
      ],
      [
        403,
        '/nmmacontentaccess_node/' . $nmmanode_id . '/delete',
        '',
      ],
      [
        200,
        'admin/structure/nmmacontentaccess_node_settings',
        'administer contact entity',
      ],
      [
        403,
        'admin/structure/nmmacontentaccess_node_settings',
        '',
      ],
    ];
  }

  /**
   * Test add new fields to the contact entity.
   */
  public function testAddFields() {
    $web_user = $this->drupalCreateUser([
      'administer contact entity',
      'administer nmmacontentaccess_node display',
      'administer nmmacontentaccess_node fields',
      'administer nmmacontentaccess_node form display',
    ]);

    $this->drupalLogin($web_user);
    $entity_name = 'nmmacontentaccess_node';
    $add_field_url = 'admin/structure/' . $entity_name . '_settings/fields/add-field';
    $this->drupalGet($add_field_url);
    $field_name = 'test_name';
    $edit = [
      'new_storage_type' => 'list_string',
      'label' => 'test name',
      'field_name' => $field_name,
    ];

    $this->drupalPostForm(NULL, $edit, 'Save and continue');
    $expected_path = $this->buildUrl('admin/structure/' . $entity_name . '_settings/fields/' . $entity_name . '.' . $entity_name . '.field_' . $field_name . '/storage');

    // Fetch url without query parameters.
    $current_path = strtok($this->getUrl(), '?');
    $this->assertEquals($expected_path, $current_path);
  }

  /**
   * Ensure admin and permissioned users can create contacts.
   */
  public function testCreateAdminPermission() {
    $assert = $this->assertSession();
    $add_url = Url::fromRoute('nmmacontentaccess.nmmanode_add');

    // Create a NmmaNode entity object so that we can query it for it's annotated
    // properties. We don't need to save it.
    /* @var $contact \Drupal\nmmacontentaccess\Entity\NmmaNode */
    $contact = NmmaNode::create();

    // Create an admin user and log them in. We use the entity annotation for
    // admin_permission in order to validate it. We also have to add the view
    // list permission because the add form redirects to the list on success.
    $this->drupalLogin($this->drupalCreateUser([
      $contact->getEntityType()->getAdminPermission(),
      'view contact entity',
    ]));

    // Post a contact.
    $edit = [
      'name[0][value]' => 'Test Admin Name',
      //'first_name[0][value]' => 'Admin First Name',
      'node_id[0][value]' => '99998',
      'role' => 'administrator',
    ];
    $this->drupalPostForm($add_url, $edit, 'Save');
    $assert->statusCodeEquals(200);
    $assert->pageTextContains('Test Admin Name');

    // Create a user with 'add NmmaNode entity' permission. We also have to add
    // the view list permission because the add form redirects to the list on
    // success.
    $this->drupalLogin($this->drupalCreateUser([
      'add NmmaNode entity',
      'view NmmaNode entity',
    ]));

    // Post a NmmaNode.
    $edit = [
      'name[0][value]' => 'Mere Mortal Name',
      //'first_name[0][value]' => 'Mortal First Name',
      'node_id[0][value]' => '99997',
      'role' => 'user',
    ];
    $this->drupalPostForm($add_url, $edit, 'Save');
    $assert->statusCodeEquals(200);
    $assert->pageTextContains('Mere Mortal Name');

    // Finally, a user who can only view should not be able to get to the add
    // form.
    $this->drupalLogin($this->drupalCreateUser([
      'view NmmaNode entity',
    ]));
    $this->drupalGet($add_url);
    $assert->statusCodeEquals(403);
  }

}
