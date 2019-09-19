<?php

namespace Drupal\Tests\codemirror_editor\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * A test for codemirror_editor_library_info_build().
 *
 * @group codemirror_editor
 */
class LibraryBuilderTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['codemirror_editor', 'codemirror_editor_test'];

  /**
   * CodeMirror library definition when CDN option is 'Off'.
   *
   * @var array
   */
  protected $localFixture = [
    'remote' => 'https://codemirror.net',
    'version' => '5.37.0',
    'license' => [
      'name' => 'MIT',
      'url' => 'http://codemirror.net/LICENSE',
      'gpl-compatible' => TRUE,
    ],
    'js' => [
      '/libraries/codemirror/codemirror.min.js' => [],
      '/libraries/codemirror/mode/xml/xml.min.js' => [],
      '/libraries/codemirror/mode/clike/clike.min.js' => [],
      '/libraries/codemirror/mode/php/php.min.js' => [],
      '/libraries/codemirror/mode/css/css.min.js' => [],
      '/libraries/codemirror/addon/fold/foldcode.min.js' => [],
      '/libraries/codemirror/addon/fold/foldgutter.min.js' => [],
      '/libraries/codemirror/addon/fold/brace-fold.min.js' => [],
      '/libraries/codemirror/addon/fold/xml-fold.min.js' => [],
      '/libraries/codemirror/addon/fold/comment-fold.min.js' => [],
      '/libraries/codemirror/addon/display/fullscreen.min.js' => [],
      '/libraries/codemirror/addon/display/placeholder.min.js' => [],
      '/libraries/codemirror/addon/mode/overlay.min.js' => [],
      '/libraries/codemirror/addon/edit/closetag.min.js' => [],
      '/libraries/codemirror/addon/comment/comment.min.js' => [],
      '/libraries/codemirror/addon/selection/active-line.min.js' => [],
    ],
    'css' => [
      'component' => [
        '/libraries/codemirror/codemirror.min.css' => [],
        '/libraries/codemirror/addon/fold/foldgutter.min.css' => [],
        '/libraries/codemirror/addon/display/fullscreen.css' => [],
      ],
    ],
  ];

  /**
   * CodeMirror library definition when CDN option is 'On'.
   *
   * @var array
   */
  protected $remoteFixture = [
    'remote' => 'https://codemirror.net',
    'version' => '5.37.0',
    'license' => [
      'name' => 'MIT',
      'url' => 'http://codemirror.net/LICENSE',
      'gpl-compatible' => TRUE,
    ],
    'js' => [
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/codemirror.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/mode/xml/xml.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/mode/clike/clike.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/mode/php/php.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/mode/css/css.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/fold/foldcode.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/fold/foldgutter.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/fold/brace-fold.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/fold/xml-fold.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/fold/comment-fold.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/display/fullscreen.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/display/placeholder.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/mode/overlay.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/edit/closetag.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/comment/comment.min.js' => ['type' => 'external'],
      'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/selection/active-line.min.js' => ['type' => 'external'],
    ],
    'css' => [
      'component' => [
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/codemirror.min.css' => ['type' => 'external'],
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/fold/foldgutter.min.css' => ['type' => 'external'],
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/addon/display/fullscreen.css' => ['type' => 'external'],
      ],
    ],
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->installConfig(['codemirror_editor']);
  }

  /**
   * Test callback.
   */
  public function testLibraryBuild() {

    $expected_build = [
      'codemirror' => $this->remoteFixture,
      'codemirror_5' => $this->remoteFixture,
    ];
    self::assertEquals($expected_build, codemirror_editor_library_info_build());

    $settings = [
      'cdn' => FALSE,
      'theme' => 'cobalt',
      'language_modes' => ['xml'],
    ];

    \Drupal::configFactory()
      ->getEditable('codemirror_editor.settings')
      ->setData($settings)
      ->save();

    $expected_build = [
      'codemirror' => $this->localFixture,
      'codemirror_5' => $this->localFixture,
    ];
    $expected_build['codemirror']['css']['theme']['/libraries/codemirror/theme/cobalt.min.css'] = [];
    $expected_build['codemirror_5']['css']['theme']['/libraries/codemirror/theme/cobalt.min.css'] = [];
    self::assertEquals($expected_build, codemirror_editor_library_info_build());
  }

}
