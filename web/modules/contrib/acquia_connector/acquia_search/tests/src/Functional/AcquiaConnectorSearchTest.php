<?php

namespace Drupal\Tests\acquia_search\Functional;

use Drupal\search_api\Entity\Server;
use Drupal\Tests\BrowserTestBase;

/**
 * Tests the functionality of the Acquia Search module.
 *
 * @group Acquia search
 */
class AcquiaConnectorSearchTest extends BrowserTestBase {

  /**
   * Acquia subscription ID.
   *
   * @var string
   */
  protected $id;

  /**
   * Key.
   *
   * @var string
   */
  protected $key;

  /**
   * Salt.
   *
   * @var string
   */
  protected $salt;

  /**
   * Search server.
   *
   * @var string
   */
  protected $server;

  /**
   * Search index.
   *
   * @var string
   */
  protected $index;

  /**
   * Module settings path.
   *
   * @var string
   */
  protected $settingsPath;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'acquia_connector',
    'search_api',
    'search_api_solr',
    'toolbar',
    'acquia_connector_test',
    'node',
    'views',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    // Generate and store a random set of credentials.
    $this->id = $this->randomString(10);
    $this->key = $this->randomString(32);
    $this->salt = $this->randomString(32);
    $this->server = 'acquia_search_server';
    $this->index = 'acquia_search_index';
    $this->settingsPath = 'admin/config/search/search-api';

    // Create a new content type.
    $content_type = $this->drupalCreateContentType();

    // Add a node of the new content type.
    $node_data = [
      'type' => $content_type->id(),
    ];

    $this->drupalCreateNode($node_data);
    $this->connect();
  }

  /**
   * Connect.
   */
  public function connect() {
    \Drupal::configFactory()->getEditable('acquia_connector.settings')->set('spi.ssl_verify', FALSE)->save();
    \Drupal::configFactory()->getEditable('acquia_connector.settings')->set('spi.ssl_override', TRUE)->save();

    $admin_user = $this->createAdminUser();
    $this->drupalLogin($admin_user);

    $edit_fields = [
      'acquia_identifier' => $this->randomString(8),
      'acquia_key' => $this->randomString(8),
    ];

    $submit_button = 'Connect';
    $this->drupalPostForm('admin/config/system/acquia-connector/credentials', $edit_fields, $submit_button);

    \Drupal::service('module_installer')->install(['acquia_search']);
  }

  /**
   * Creates an admin user.
   */
  public function createAdminUser() {
    $permissions = [
      'administer site configuration',
      'access administration pages',
      'access toolbar',
      'administer search_api',
    ];
    return $this->drupalCreateUser($permissions);
  }

  /**
   * Tests Acquia Search environment creation.
   *
   * Tests executed:
   * - Acquia Search environment is saved and loaded.
   * - Acquia Search environment is set as the default environment when created.
   * - The service class is set to AcquiaSearchService.
   * - The environment's URL is built as expected.
   */
  public function testEnvironment() {
    // Connect site on key and id.
    $this->drupalGet('admin/config/search/search-api');
    $environment = Server::load('acquia_search_server');
    // Check if the environment is a valid variable.
    $this->assertTrue($environment, t('Acquia Search environment saved.'), 'Acquia Search');
  }

  /**
   * Tests Environment UI.
   *
   * Tests that the Acquia Search environment shows up in the interface and that
   * administrators cannot delete it.
   *
   * Tests executed:
   * - Acquia Search environment is present in the UI.
   * - Admin user receives 403 when attempting to delete the environment.
   */
  public function testEnvironmentUi() {
    $this->drupalGet($this->settingsPath);
    // Check the Acquia Search Server is displayed.
    $this->assertLinkByHref('/admin/config/search/search-api/server/' . $this->server, 0, t('The Acquia Search Server is displayed in the UI.'));
    // Check the Acquia Search Index is displayed.
    $this->assertLinkByHref('/admin/config/search/search-api/index/' . $this->index, 0, t('The Acquia Search Index is displayed in the UI.'));
    // Delete the environment.
    $this->drupalGet('/admin/config/search/search-api/server/' . $this->server . '/edit');
    $this->clickLink('Delete', 0);
    $this->assertResponse(403, t('The Acquia Search environment cannot be deleted via the UI.'));
  }

  /**
   * Tests Acquia Search Server UI.
   *
   * Test executed:
   * - Check backend server
   * - ??heck all fields on the existence of
   * - Admin user receives 403 when attempting to delete the server.
   */
  public function testAcquiaSearchServerUi() {
    $settings_path = 'admin/config/search/search-api';
    $this->drupalGet($settings_path);
    $this->clickLink('Edit', 0);
    // Check backend server.
    $this->assertText('Backend', t('The Backend checkbox label exists'), 'Acquia Search');
    $this->assertFieldChecked('edit-backend-config-connector-solr-acquia-connector', t('Is used as a Solr Connector: Acquia'), 'Acquia Search');
    // Check field Solr server URI.
    $this->assertText('Solr server URI', t('The Solr server URI label exist'), 'Acquia Search');
    // Check http-protocol.
    $this->assertText('HTTP protocol', t('The HTTP protocol label exists'), 'Acquia Search');
    $this->assertOptionSelected('edit-backend-config-connector-config-scheme', 'http', t('By default selected HTTP protocol'), 'Acquia Search');
    // Check Solr host, port, path.
    $this->assertNoText('Solr host', t('The Solr host label does not exist'), 'Acquia Search');
    $this->assertNoText('Solr port', t('The Solr port label does not exist'), 'Acquia Search');
    $this->assertNoText('Solr path', t('The Solr path label does not exist'), 'Acquia Search');
    // Check Basic HTTP authentication.
    $this->assertNoText('Basic HTTP authentication', t('The basic HTTP authentication label does not exist'), 'Acquia Search');
    // Ckeck Solr version override.
    $this->assertText('Solr version override', t('The selectbox "Solr version label" exist'), 'Acquia Search');
    $this->assertOptionByText('edit-backend-config-connector-config-workarounds-solr-version', 'Determine automatically', t('By default selected Solr version "Determine automatically"'), 'Acquia Search');
    // Ckeck HTTP method.
    $this->assertText('HTTP method', t('The HTTP method label exist'));
    $this->assertOptionSelected('edit-backend-config-connector-config-workarounds-http-method', 'AUTO', t('By default selected AUTO HTTP method'), 'Acquia Search');
    // Server save.
    $this->drupalPostForm('/admin/config/search/search-api/server/' . $this->server . '/edit', [], 'Save');
    // Delete server.
    $this->drupalGet('/admin/config/search/search-api/server/' . $this->server . '/delete');
    $this->assertResponse(403, t('The Acquia Search Server cannot be deleted via the UI.'));
  }

  /**
   * Tests Acquia Search Server UI.
   *
   * Test executed:
   * - ??heck all fields on the existence of
   * - Check fields used for indexing
   * - Check save index
   * - Admin user receives 403 when attempting to delete the index.
   */
  public function testAcquiaSearchIndexUi() {
    $settings_path = 'admin/config/search/search-api';
    $this->drupalGet($settings_path);
    $this->clickLink('Edit', 1);
    // Check field data types.
    $this->assertText('Datasources', t('The Data types label exist'), 'Acquia Search');
    // Check default selected server.
    $this->assertFieldChecked('edit-server-acquia-search-server', t('By default selected Acquia Search Server'), 'Acquia Search');
    // Check fields used for indexing.
    $this->drupalGet('/admin/config/search/search-api/index/' . $this->index . '/fields');
    $this->assertOptionSelected('edit-fields-body-type', 'text', t('Body used for searching'), t('Acquia Search'));
    $this->assertOptionSelected('edit-fields-title-type', 'text', t('Title used for searching'), 'Acquia Search');
    // Save index.
    $this->drupalPostForm('/admin/config/search/search-api/index/' . $this->index . '/edit', [], 'Save');
    // Delete index.
    $this->drupalGet('/admin/config/search/search-api/index/' . $this->index . '/delete');
    $this->assertResponse(403, t('The Acquia Search Server cannot be deleted via the UI.'));
  }

}
