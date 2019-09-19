<?php

namespace Drupal\codemirror_editor\Plugin\Filter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Provides a 'CodeMirror' filter.
 *
 * @Filter(
 *   id = "codemirror_editor",
 *   title = @Translation("CodeMirror"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE,
 *   settings = {
 *     "lineNumbers" = true,
 *     "foldGutter" = false
 *   }
 * )
 */
class CodeMirrorEditor extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $form['lineNumbers'] = [
      '#title' => t('Line numbers'),
      '#type' => 'checkbox',
      '#default_value' => $this->settings['lineNumbers'],
    ];

    $form['foldGutter'] = [
      '#title' => t('Fold gutter'),
      '#type' => 'checkbox',
      '#default_value' => $this->settings['foldGutter'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {

    $options = $this->settings;
    $options['readOnly'] = TRUE;
    $options['toolbar'] = FALSE;

    $html_dom = Html::load($text);
    $xpath = new \DOMXPath($html_dom);

    $elements = $xpath->query('//code[@data-mode]');

    foreach ($elements as $element) {
      $html = self::getInnerHtml($element);
      $code_area = $html_dom->createElement('code', Html::escape($html));

      /* @var \DOMElement $element */
      $mode = $element->getAttribute('data-mode');
      $mode = codemirror_editor_normalize_mode($mode);

      $code_area->setAttribute('data-codemirror', json_encode(['mode' => $mode] + $options));
      $code_area->setAttribute('class', 'cme-code');

      $element->parentNode->insertBefore($code_area, $element->nextSibling);
      $element->parentNode->removeChild($element);
    }

    $output = Html::serialize($html_dom);
    $output = trim($output);

    if (count($elements)) {
      $build['#attached']['library'][] = 'codemirror_editor/formatter';
      \Drupal::service('renderer')->render($build);
    }

    return new FilterProcessResult($output);
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $tip_arguments = [
      '@expression' => '<code data-mode="mode">...</code>',
    ];
    return $this->t('Syntax highlight code surrounded by the <code>@expression</code> tags.', $tip_arguments);
  }

  /**
   * Converts the DOM element to an HTML snippet.
   *
   * @param \DOMElement $element
   *   The DOM element to serialize.
   *
   * @return string
   *   The HTML code.
   */
  protected static function getInnerHtml(\DOMElement $element) {
    $innerHTML = '';
    foreach ($element->childNodes as $child) {
      $innerHTML .= $element->ownerDocument->saveHTML($child);
    }
    return $innerHTML;
  }

}
