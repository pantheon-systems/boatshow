<?php

namespace Drupal\codemirror_editor\Plugin\Editor;

use Drupal\codemirror_editor\CodeMirrorSettingsTrait;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Entity\Editor;
use Drupal\editor\Plugin\EditorBase;

/**
 * Defines a CodeMirror text editor.
 *
 * @Editor(
 *   id = "codemirror_editor",
 *   label = @Translation("CodeMirror editor"),
 *   supports_content_filtering = FALSE,
 *   is_xss_safe = FALSE,
 *   supported_element_types = {
 *     "textarea",
 *   }
 * )
 */
class CodeMirrorEditor extends EditorBase {

  use CodeMirrorSettingsTrait;

  /**
   * {@inheritdoc}
   */
  public function getDefaultSettings() {
    return self::getDefaultCodeMirrorSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state, Editor $editor) {

    $settings = $editor->getSettings();

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
   * {@inheritdoc}
   */
  public function getJsSettings(Editor $editor) {
    return $editor->getSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function getLibraries(Editor $editor) {
    return ['codemirror_editor/editor'];
  }

}
