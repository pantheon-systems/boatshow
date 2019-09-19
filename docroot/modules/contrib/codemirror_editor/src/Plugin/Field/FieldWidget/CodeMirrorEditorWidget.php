<?php

namespace Drupal\codemirror_editor\Plugin\Field\FieldWidget;

use Drupal\codemirror_editor\CodeMirrorSettingsTrait;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'codemirror_editor' field widget.
 *
 * @FieldWidget(
 *   id = "codemirror_editor",
 *   label = @Translation("CodeMirror"),
 *   field_types = {"string_long"},
 * )
 */
class CodeMirrorEditorWidget extends WidgetBase {

  use CodeMirrorSettingsTrait;

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $settings = [
      'rows' => '5',
      'placeholder' => '',
      'mode' => 'text/html',
    ];
    return $settings + self::getDefaultCodeMirrorSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['rows'] = [
      '#type' => 'number',
      '#title' => $this->t('Rows'),
      '#default_value' => $this->getSetting('rows'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $element['placeholder'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered.'),
    ];
    $element['mode'] = [
      '#title' => $this->t('Language mode'),
      '#type' => 'textfield',
      '#size' => 15,
      '#default_value' => $this->getSetting('mode'),
    ];
    return $element + self::buildCodeMirrorSettingsForm($this->getSettings());
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();
    $summary[] = $this->t('Number of rows: @rows', ['@rows' => $settings['rows']]);
    if ($settings['placeholder'] != '') {
      $summary[] = $this->t('Placeholder: @placeholder', ['@placeholder' => $settings['placeholder']]);
    }
    $summary[] = $this->t('Language mode: @mode', ['@mode' => $this->getSetting('mode')]);
    $summary[] = $this->t('Load toolbar: @toolbar', $this->getSummaryArguments('toolbar'));
    $summary[] = $this->t('Line numbers: @lineNumbers', $this->getSummaryArguments('lineNumbers'));
    $summary[] = $this->t('Fold gutter: @foldGutter', $this->getSummaryArguments('foldGutter'));
    $summary[] = $this->t('Auto close tags: @autoCloseTags', $this->getSummaryArguments('autoCloseTags'));
    $summary[] = $this->t('Style active line: @styleActiveLine', $this->getSummaryArguments('styleActiveLine'));
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $settings = $this->getSettings();
    $settings['mode'] = codemirror_editor_normalize_mode($settings['mode']);

    $element['value'] = $element + [
      '#type' => 'textarea',
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
      '#rows' => $settings['rows'],
      '#placeholder' => $settings['placeholder'],
    ];

    // These options are not relevant to CodeMirror.
    unset($settings['rows'], $settings['placeholder']);
    $element['value']['#codemirror'] = $settings;

    return $element;
  }

}
