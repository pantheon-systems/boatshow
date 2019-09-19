<?php

namespace Drupal\codemirror_editor;

/**
 * Provides a helper to for CodeMirror plugin settings.
 */
trait CodeMirrorSettingsTrait {

  /**
   * Returns the default settings for CodeMirror plugin.
   *
   * @return array
   *   A list of default settings, keyed by the setting name.
   */
  protected static function getDefaultCodeMirrorSettings() {
    return [
      'toolbar' => TRUE,
      'lineNumbers' => FALSE,
      'foldGutter' => FALSE,
      'autoCloseTags' => TRUE,
      'styleActiveLine' => FALSE,
    ];
  }

  /**
   * Returns a form to configure settings for the CodeMirror plugin.
   *
   * @param array $settings
   *   The plugin settings.
   *
   * @return array
   *   The form definition for the plugin settings.
   */
  protected static function buildCodeMirrorSettingsForm(array $settings) {

    $form['toolbar'] = [
      '#title' => t('Load toolbar'),
      '#type' => 'checkbox',
      '#default_value' => $settings['toolbar'],
    ];

    $form['lineNumbers'] = [
      '#title' => t('Line numbers'),
      '#type' => 'checkbox',
      '#default_value' => $settings['lineNumbers'],
    ];

    $form['foldGutter'] = [
      '#title' => t('Fold gutter'),
      '#type' => 'checkbox',
      '#default_value' => $settings['foldGutter'],
    ];

    $form['autoCloseTags'] = [
      '#title' => t('Auto close tags'),
      '#type' => 'checkbox',
      '#default_value' => $settings['autoCloseTags'],
    ];

    $form['styleActiveLine'] = [
      '#title' => t('Style active line'),
      '#type' => 'checkbox',
      '#default_value' => $settings['styleActiveLine'],
    ];

    return $form;
  }

  /**
   * Gets a summary message replacement form a given plugin setting.
   *
   * @param string $setting
   *   Plugin setting to format.
   *
   * @return array
   *   Summary message arguments.
   */
  protected function getSummaryArguments($setting) {
    return ["@$setting" => $this->getSetting($setting) ? $this->t('Yes') : $this->t('No')];
  }

}
