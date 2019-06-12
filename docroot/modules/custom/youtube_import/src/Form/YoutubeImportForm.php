<?php

namespace Drupal\youtube_import\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\DateTime\DateFormatter;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\State\StateInterface;
use Drupal\Core\Link;

/**
 * Implements the YoutubeImport admin settings form.
 */
class YoutubeImportForm extends ConfigFormBase {

  protected $date;

  /**
   * Manipulate state.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Access fields.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;


  /**
   * Access user entities.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $userStorage;

  /**
   * YoutubeImportForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\State\StateInterface $state
   *   Provides access to state.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Access to entities.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   Access to entity fields.
   * @param \Drupal\Core\DateTime\DateFormatter $date
   *   Access to the date formatter.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function __construct(ConfigFactoryInterface $config_factory, StateInterface $state, EntityTypeManagerInterface $entity_type_manager, EntityFieldManagerInterface $entity_field_manager, DateFormatter $date) {
    parent::__construct($config_factory);
    $this->state = $state;
    $this->userStorage = $entity_type_manager->getStorage('user');
    $this->entityFieldManager = $entity_field_manager;
    $this->date = $date;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'youtube_import_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('youtube_import.settings');

    // A flag to see if there is a youtube field.
    $has_youtube_field = FALSE;

    // Create the field for the API key.
    $form['apikey'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('YouTube API key.'),
      '#default_value' => $config->get('apikey'),
    ];

    // Create the field for the username.
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('YouTube user name or your channel ID'),
      '#description' => $this->t('This value is only used to get the playlist id. If you know the playlist id, you may leave this blank but be sure to fill in one or the other'),
      '#default_value' => $config->get('username'),
    ];

    // Create the field for the playlist id.
    $form['playlistid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('YouTube play list ID.'),
      '#description' => $this->t('You may leave this blank if you have entered the YouTube username and it will be automatically updated to the "uploads" playlist of that user.'),
      '#default_value' => $config->get('playlistid'),
    ];

    // Create the frequency setting.
    $form['frequency'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Cron Frequency'),
      '#description' => $this->t('Enter 0 to disable the cron job. Enter the time in seconds to have it run during cron.'),
      '#default_value' => $config->get('frequency'),
    ];

    // Create the content type drop down.
    $form['contenttype'] = [
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => $this->t('Content Type'),
      '#options' => node_type_get_names(),
      '#default_value' => $config->get('contenttype'),
      '#description' => $this->t('Select the content type that videos should import to'),
    ];

    // Get the usernames from the Drupal database.
    $ids = $this->userStorage->getQuery()
      ->condition('status', 1)
      ->execute();

    $user_data = $this->userStorage->loadMultiple($ids);

    $users = [];

    /** @var \Drupal\user\Entity\User $user_d */
    foreach ($user_data as $user_d) {
      // Get user id.
      $uid = $user_d->get('uid')->getValue();
      // Get value of id.
      $uid = $uid[0]['value'];

      // Get user name.
      $name = $user_d->get('name')->getValue();
      // Get value of id.
      $name = $name[0]['value'];

      $users[$uid] = $name;
    }

    // Author selection drop down.
    $form['drupal_user'] = [
      '#type' => 'select',
      '#title' => $this->t('Author'),
      '#options' => $users,
      '#default_value' => $config->get('drupal_user'),
      '#required' => FALSE,
      '#description' => $this->t('YouTube import will default to the current user or the user selected here.'),
    ];

    if ($config->get('apikey') && $config->get('playlistid')) {

      // Generate url.
      $url = Url::fromRoute('youtube_import.run_now');

      // If there is a lastrun date, lets display it.
      $lastrun = $this->state->get('youtube_import.lastrun', 0);
      $lastrun_text = '';
      if ($lastrun > 0) {
        $lastrun_text = ' (' . $this->t('Last run: @date', ['@date' => $this->date->format((int) $lastrun, 'long')]) . ')';
      }

      // Create the run link html.
      $form['youtube_import_run_link'] = [
        '#prefix' => '<p>',
        '#markup' => Link::fromTextAndUrl($this->t('Click here to run the import now'), $url)->toString() . $lastrun_text,
        '#suffix' => '</p>',
      ];

    }

    // If there is no content type, then we can't select fields.
    if (!empty($config->get('contenttype'))) {

      // Just a heading to let the user know this is the mapping section.
      $form['mapheading'] = [
        '#type' => 'markup',
        '#markup' => '<h2>' . $this->t('Field Mapping') . '</h2>',
      ];

      $fieldinfo = $this->entityFieldManager
        ->getFieldDefinitions('node', $config->get('contenttype'));

      // Initialize an array for the field names and labels as well as add the
      // ones that do not show up.
      $fields = ['title' => $this->t('Title'), 'created' => 'Created'];

      // Loop through the fields and add them to our more useful array.
      foreach ($fieldinfo as $key => $value) {
        // Need to mark youtube fields as they are always included.
        if ($value->getDataType() == 'youtube') {
          $fields[$key] = $value['label'] . '*';
          $has_youtube_field = TRUE;
        }
        else {
          $fields[$key] = $value->getLabel();
        }
      }

      // Get the properties that we can pull from YouTube.
      $properties = [
        '' => $this->t('None'),
        'title' => $this->t('Title'),
        'description' => $this->t('Description'),
        'publishedAt' => $this->t('Published Date'),
        'thumbnails' => $this->t('Thumbnail Image'),
        'id' => $this->t('Video ID'),
        'url' => $this->t('Share URL'),
        'duration' => $this->t('Duration'),
        'dimension' => $this->t('Dimension'),
        'definition' => $this->t('Definition'),
        'viewCount' => $this->t('Number of Views'),
        'likeCount' => $this->t('Number of Likes'),
        'dislikeCount' => $this->t('Number of dislikes'),
        'favoriteCount' => $this->t('Number of Favorites'),
        'commentCount' => $this->t('Number of comments'),
      ];

      // Create our indefinite field element.
      $form['mapping'] = [
        '#tree' => TRUE,
      ];

      // Loop through each of the fields in the content type and create a
      // mapping drop down for each.
      foreach ($fields as $fieldname => $label) {
        // YouTube fields are added automatically.
        if (strpos($label, '*') !== FALSE) {
          $form['mapping'][$fieldname] = [
            '#type' => 'select',
            '#title' => $this->t("@l <small>@f</small>", [
              '@f' => $fieldname,
              '@l' => $label,
            ]),
            '#options' => $properties,
            '#value' => 'url',
            '#disabled' => TRUE,
          ];
        }
        else {
          // Create the mapping dropdown.
          $form["mapping"][$fieldname] = [
            '#type' => 'select',
            '#title' => $this->t("@l <small>@f</small>", [
              '@f' => $fieldname,
              '@l' => $label,
            ]),
            '#options' => $properties,
            '#default_value' => isset($config->get('mapping')[$fieldname]) ? $config->get('mapping')[$fieldname] : NULL,
          ];
        }
      }

      // If there is a youtube field, need to explain *.
      if ($has_youtube_field) {
        $form['youtube_markup'] = [
          '#type' => 'markup',
          '#prefix' => '<p>',
          '#markup' => $this->t('YouTube fields are automatically added to the mapping.'),
          '#suffix' => '</p>',
        ];
      }

    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    if (empty($values['username']) && empty($values['playlistid'])) {
      $form_state->setError($form, $this->t('The username and playlist id cannot both be blank.'));
      $form_state->setError($form);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Get form state values.
    $values = $form_state->getValues();

    // Get the youtube settings list (non mapping stuff).
    $setting_keys = [
      'username',
      'drupal_user',
      'apikey',
      'playlistid',
      'frequency',
      'contenttype',
    ];

    // Loop through the form values and see which matches we can find.
    foreach ($setting_keys as $key) {

      // Set the value or clear it depending on user submission.
      if (array_key_exists($key, $values)) {
        $settings[$key] = $values[$key];
      }
      else {
        $settings[$key] = '';
      }
    }

    // Loop through the user updated mapping fields.
    if (array_key_exists('mapping', $values)) {
      foreach ($values['mapping'] as $key => $value) {
        // Set the mapping value.
        $settings['mapping'][$key] = $value;
      }
    }

    // If the username was set and the playlist wasn't, let's get the default.
    if (empty($settings['playlistid'])) {
      $settings['playlistid'] = youtube_import_playlist_id($settings['username'], $settings['apikey']);
    }

    // Determine the level of success.
    if (!empty($settings['playlistid'])) {
      // Inform the user.
      drupal_set_message($this->t('YouTube Import settings saved successfully.'));
    }
    else {
      drupal_set_message($this->t('Unable to set the play list ID.'), 'error');
    }

    $this->config('youtube_import.settings')->setData($settings)->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return [
      'youtube_import.settings',
    ];
  }

}
