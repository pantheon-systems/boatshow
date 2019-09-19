<?php

namespace Drupal\codemirror_editor;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * CodeMirrorLibraryBuilder service.
 */
class CodeMirrorLibraryBuilder {

  const CODEMIRROR_VERSION = '5.37.0';

  const CDN_URL = 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/';

  const LIBRARY_PATH = '/libraries/codemirror/';

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a CodeMirrorLibraryBuilder object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ModuleHandlerInterface $module_handler) {
    $this->configFactory = $config_factory;
    $this->moduleHandler = $module_handler;
  }

  /**
   * Builds a definition for CodeMirror library.
   *
   * @return array
   *   CodeMirror library definition.
   */
  public function build() {

    $settings = $this->configFactory->get('codemirror_editor.settings')->get();

    $library = [
      'remote' => 'https://codemirror.net',
      'version' => self::CODEMIRROR_VERSION,
      'license' => [
        'name' => 'MIT',
        'url' => 'http://codemirror.net/LICENSE',
        'gpl-compatible' => TRUE,
      ],
    ];

    $assets = [
      'js' => [
        'codemirror.min.js',
        'addon/edit/closetag.min.js',
        'addon/fold/foldcode.min.js',
        'addon/fold/foldgutter.min.js',
        'addon/fold/brace-fold.min.js',
        'addon/fold/xml-fold.min.js',
        'addon/fold/comment-fold.min.js',
        'addon/display/fullscreen.min.js',
        'addon/display/placeholder.min.js',
        'addon/mode/overlay.min.js',
        'addon/comment/comment.min.js',
        'addon/selection/active-line.min.js',
      ],
      'css' => [
        'codemirror.min.css',
        'addon/fold/foldgutter.min.css',
        // This file has no minified version on CDN by some reason.
        'addon/display/fullscreen.css',
      ],
    ];

    foreach ($settings['language_modes'] as $mode) {
      $assets['js'][] = "mode/$mode/$mode.min.js";
    }

    // hook_library_info_alter() is not quite convenient here because the
    // implementors have to take care about CDN option.
    $this->moduleHandler->alter('codemirror_editor_assets', $assets);

    if ($settings['cdn']) {
      $prefix = self::CDN_URL . self::CODEMIRROR_VERSION . '/';
      $options = ['type' => 'external'];
    }
    else {
      $prefix = self::LIBRARY_PATH;
      $options = [];
    }

    foreach ($assets['js'] as $file) {
      $library['js'][$prefix . $file] = $options;
    }

    foreach ($assets['css'] as $file) {
      $library['css']['component'][$prefix . $file] = $options;
    }

    if ($settings['theme'] != 'default') {
      $library['css']['theme'][$prefix . 'theme/' . $settings['theme'] . '.min.css'] = $options;
    }

    return $library;
  }

}
