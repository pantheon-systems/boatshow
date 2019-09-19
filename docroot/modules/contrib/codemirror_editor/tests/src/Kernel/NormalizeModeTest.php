<?php

namespace Drupal\Tests\codemirror_editor\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests the codemirror_editor_normalize_mode() function.
 *
 * @group codemirror_editor
 */
class NormalizeModeTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['codemirror_editor'];

  /**
   * Test callback.
   *
   * @dataProvider getData
   */
  public function testNormalizeMode($input, $expected_output) {
    $output = codemirror_editor_normalize_mode($input);
    self::assertEquals($expected_output, $output);
  }

  /**
   * Data provider for testNormalizeMode().
   *
   * @return array
   *   Mock data set.
   */
  public function getData() {
    return [
      ['text/x-sql', 'text/x-sql'],
      ['PHP', 'text/x-php'],
      ['html', 'text/html'],
      ['missing/mode', 'missing/mode'],
    ];
  }

}
