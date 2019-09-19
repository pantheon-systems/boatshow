<?php

namespace Drupal\codemirror_editor\Form;

use Drupal\Core\Cache\CacheTagsInvalidatorInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * CodeMirror editor settings form.
 */
class SettingsForm extends ConfigFormBase {
  /**
   * The cache tags invalidator.
   *
   * @var \Drupal\Core\Cache\CacheTagsInvalidatorInterface
   */
  protected $cacheTagsInvalidator;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'codemirror_editor_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['codemirror_editor.settings'];
  }

  /**
   * Constructs a \Drupal\system\ConfigFormBase object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Cache\CacheTagsInvalidatorInterface $cache_tags_invalidator
   *   The cache tags invalidator.
   */
  public function __construct(ConfigFactoryInterface $config_factory, CacheTagsInvalidatorInterface $cache_tags_invalidator) {
    parent::__construct($config_factory);
    $this->cacheTagsInvalidator = $cache_tags_invalidator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('cache_tags.invalidator')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $settings = $this->config('codemirror_editor.settings')->get();

    $form['cdn'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Load the library from CDN'),
      '#default_value' => $settings['cdn'],
    ];

    $codemirror_themes = static::getCodeMirrorThemes();
    $form['theme'] = [
      '#type' => 'select',
      '#title' => $this->t('Theme'),
      '#options' => $codemirror_themes,
      '#default_value' => $settings['theme'],
    ];

    $form['language_modes_wrapper'] = [
      '#type' => 'details',
      '#title' => $this->t('Installed language modes'),
    ];

    $options = [];
    $modes = codemirror_editor_load_modes();
    foreach ($modes as $mode_name => $mode) {
      $url = Url::fromUri(
        sprintf('https://codemirror.net/mode/%s/index.html', $mode_name),
        ['attributes' => ['target' => '_blank']]
      );
      $options[$mode_name] = [
        'label' => Link::fromTextAndUrl($mode['label'], $url),
        'mime_types' => implode(', ', array_keys($mode['mime_types'])),
        'dependencies' => isset($mode['dependencies']) ? implode(', ', $mode['dependencies']) : '',
      ];
    }

    $header = [
      'label' => $this->t('Mode'),
      'mime_types' => $this->t('Mime types'),
      'dependencies' => $this->t('Dependencies'),
    ];

    $form['language_modes_wrapper']['language_modes'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $options,
      '#default_value' => array_fill_keys($settings['language_modes'], TRUE),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    // Add dependencies.
    $modes = codemirror_editor_load_modes();
    $submitted_modes = array_values(array_filter($values['language_modes']));
    foreach ($submitted_modes as $mode_name) {
      if (isset($modes[$mode_name]['dependencies'])) {
        $submitted_modes = array_merge($submitted_modes, $modes[$mode_name]['dependencies']);
      }
    }

    $this->config('codemirror_editor.settings')
      ->set('cdn', $values['cdn'])
      ->set('theme', $values['theme'])
      ->set('language_modes', array_unique($submitted_modes))
      ->save();

    // Invalidate discovery caches to rebuild asserts.
    $this->cacheTagsInvalidator->invalidateTags(['library_info']);

    parent::submitForm($form, $form_state);
  }

  /**
   * Returns available CodeMirror themes.
   *
   * @return array
   *   CodeMirror themes.
   */
  protected static function getCodeMirrorThemes() {
    return [
      'default' => 'Default',
      '3024-day' => '3024 day',
      '3024-night' => '3024 night',
      'abcdef' => 'ABCDEF',
      'ambiance' => 'Ambiance',
      'base16-dark' => 'Base16 dark',
      'base16-light' => 'Base16 light',
      'bespin' => 'Bespin',
      'blackboard' => 'Black board',
      'cobalt' => 'Cobalt',
      'colorforth' => 'Color forth',
      'darcula' => 'Darcula',
      'dracula' => 'Dracula',
      'duotone-dark' => 'Duotone dark',
      'eclipse' => 'Eclipse',
      'elegant' => 'Elegant',
      'erlang-dark' => 'Erlang dark',
      'gruvbox-dark' => 'Gruvbox dark',
      'hopscotch' => 'Hopscotch',
      'icecoder' => 'Ice coder',
      'idea' => 'Idea',
      'isotope' => 'Isotope',
      'lesser-dark' => 'Lesser dark',
      'liquibyte' => 'Liquibyte',
      'lucario' => 'Lucario',
      'material' => 'Material',
      'mbo' => 'MBO',
      'mdn-like' => 'MDN like',
      'midnight' => 'Midnight',
      'monokai' => 'Monokai',
      'neat' => 'Neat',
      'neo' => 'Neo',
      'night' => 'Night',
      'oceanic-next' => 'Oceanic next',
      'panda-syntax' => 'Panda syntax',
      'paraiso-dark' => 'Paraiso dark',
      'paraiso-light' => 'Paraiso light',
      'pastel-on-dark' => 'Pastel on dark',
      'railscasts' => 'Rails casts',
      'rubyblue' => 'Ruby blue',
      'seti' => 'Seti',
      'shadowfox' => 'Shadow fox',
      'solarized-dark' => 'Solarized dark',
      'solarized-light' => 'Solarized light',
      'the-matrix' => 'The matrix',
      'tomorrow-night-bright' => 'Tomorrow night bright',
      'tomorrow-night-eighties' => 'Tomorrow night eighties',
      'ttcn' => 'TTCN',
      'twilight' => 'Twilight',
      'vibrant-ink' => 'Vibrant ink',
      'xq-dark' => 'XQ dark',
      'xq-light' => 'XQ light',
      'yeti' => 'Yeti',
      'zenburn' => 'Zenburn',
    ];

  }

}
