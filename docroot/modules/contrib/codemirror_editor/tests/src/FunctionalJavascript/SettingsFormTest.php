<?php

namespace Drupal\Tests\codemirror_editor\FunctionalJavascript;

/**
 * Tests the CodeMirror editor settings form.
 *
 * @group codemirror_editor
 */
class SettingsFormTest extends TestBase {

  /**
   * Test callback.
   */
  public function testSettingsForm() {
    $assert_session = $this->assertSession();
    $page = $this->getSession()->getPage();

    // Make sure the form is not accessible by unprivileged users.
    $default_user = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($default_user);
    $this->drupalGet('admin/config/content/codemirror');
    $assert_session->pageTextContains('Access denied');

    $admin_user = $this->drupalCreateUser(['access content', 'administer codemirror editor']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('admin/config/content/codemirror');
    $assert_session->pageTextContains('CodeMirror configuration');
    $assert_session->checkboxChecked('Load the library from CDN');
    $assert_session->elementExists('xpath', '//select[@name = "theme"]/option[@value = "default" and @selected]');

    $all_checkboxes = $page->findAll('xpath', '//table[@id = "edit-language-modes"]//input[@type = "checkbox"]');
    self::assertCount(11, $all_checkboxes);

    /** @var \Behat\Mink\Element\NodeElement[] $checked_checkboxes */
    $checked_checkboxes = $page->findAll('xpath', '//table[@id = "edit-language-modes"]//input[@type = "checkbox" and @checked]');
    // Only XML mode is enabled by default.
    self::assertCount(1, $checked_checkboxes);
    self::assertEquals('language_modes[xml]', $checked_checkboxes[0]->getAttribute('name'));

    $page->selectFieldOption('Theme', 'cobalt');
    $page->find('xpath', '//summary')->click();
    $page->checkField('language_modes[css]');
    $page->checkField('language_modes[javascript]');
    $page->pressButton('Save configuration');
    $assert_session->pageTextContains('The configuration options have been saved.');

    $this->drupalGet('codemirror-editor-test');
    $this->activeEditor = 1;
    $this->assertEditorOption('theme', 'cobalt');

    // Check loaded modes.
    $result = $this->getSession()
      ->getDriver()
      ->evaluateScript('CodeMirror.modes');
    $expected_modes = [
      'clike',
      'css',
      'html_twig',
      'javascript',
      'null',
      'php',
      'xml',
    ];
    self::assertSame($expected_modes, array_keys($result));
  }

}
