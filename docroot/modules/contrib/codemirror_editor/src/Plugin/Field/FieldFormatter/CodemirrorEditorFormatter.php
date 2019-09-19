<?php

namespace Drupal\codemirror_editor\Plugin\Field\FieldFormatter;

use Drupal\codemirror_editor\CodeMirrorSettingsTrait;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Codemirror' formatter.
 *
 * @FieldFormatter(
 *   id = "codemirror_editor",
 *   label = @Translation("Codemirror"),
 *   field_types = {
 *     "string_long",
 *     "text_long"
 *   }
 * )
 */
class CodemirrorEditorFormatter extends FormatterBase {

  use CodeMirrorSettingsTrait;

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'mode' => 'text/html',
      'lineNumbers' => TRUE,
      'foldGutter' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();

    $element['mode'] = [
      '#title' => $this->t('Language mode'),
      '#type' => 'textfield',
      '#size' => 15,
      '#default_value' => $settings['mode'],
    ];

    $element['lineNumbers'] = [
      '#title' => $this->t('Line numbers'),
      '#type' => 'checkbox',
      '#default_value' => $settings['lineNumbers'],
    ];

    $element['foldGutter'] = [
      '#title' => $this->t('Fold gutter'),
      '#type' => 'checkbox',
      '#default_value' => $settings['foldGutter'],
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary[] = $this->t('Language mode: @mode', ['@mode' => $this->getSetting('mode')]);
    $summary[] = $this->t('Line numbers: @lineNumbers', $this->getSummaryArguments('lineNumbers'));
    $summary[] = $this->t('Fold gutter: @foldGutter', $this->getSummaryArguments('foldGutter'));
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    $settings = $this->getSettings();
    $settings['mode'] = codemirror_editor_normalize_mode($settings['mode']);
    $settings['readOnly'] = TRUE;
    $settings['toolbar'] = FALSE;

    foreach ($items as $delta => $item) {
      $element[$delta]['#markup'] = new FormattableMarkup(
        '<code data-codemirror="@codemirror" class="cme-code">@value</code>',
        [
          '@codemirror' => json_encode($settings),
          '@value' => "\n$item->value\n",
        ]
      );
    }

    $element['#attached']['library'][] = 'codemirror_editor/formatter';
    return $element;
  }

}
