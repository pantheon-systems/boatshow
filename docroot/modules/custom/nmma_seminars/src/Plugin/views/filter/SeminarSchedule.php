<?php

namespace Drupal\nmma_seminars\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\ViewExecutable;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

/**
 * Filters by available scheduled dates.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("seminar_schedule")
 */
class SeminarSchedule extends InOperator {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs a new SeminarSchedule object.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $connection) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = $this->t('Allowed dates');
    $this->definition['options callback'] = [$this, 'generateOptions'];
  }

  /**
   * {@inheritdoc}
   */
  public function getValueOptions() {
    $this->valueOptions = $this->generateOptions();
    return $this->valueOptions;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    if (!empty($this->value)) {
      $userTimezone = new \DateTimeZone(drupal_get_user_timezone());
      $dateTime = new \DateTime();
      $dateTime->setTimestamp($this->value[0]);
      $dateTime->setTimeZone($userTimezone);
      $beginOfDayString = $dateTime->format('Y-m-d 00:00:00');
      $beginOfDayObject = \DateTime::createFromFormat('Y-m-d H:i:s', $beginOfDayString);
      $beginOfDay = $beginOfDayObject->format('Y-m-d H:i:s');
      $endOfDayObject = clone $beginOfDayObject;
      $endOfDayObject->add(new \DateInterval('P1D'))->sub(new \DateInterval('PT1S'));
      $endOfDay = $endOfDayObject->format('Y-m-d H:i:s');
      $this->query->addTable('node__field_date', NULL, NULL, 'node__field_date');
      $this->query->addWhereExpression('AND', "DATE_FORMAT((node__field_date.field_date_value), '%Y-%m-%d %H:%i:%s') > DATE_FORMAT('" . $beginOfDay . "', '%Y-%m-%d %H:%i:%s')");
      $this->query->addWhereExpression('AND', "DATE_FORMAT((node__field_date.field_date_value), '%Y-%m-%d %H:%i:%s') < DATE_FORMAT('" . $endOfDay . "', '%Y-%m-%d %H:%i:%s')");
    }
  }

  /**
   * Skip validation if no options have been chosen.
   */
  public function validate() {
    if (!empty($this->value)) {
      parent::validate();
    }
  }

  /**
   * Helper function that generates the options.
   *
   * @return array
   *   Array of available options keyed by their entity id.
   */
  public function generateOptions() {
    // Prepare default variables.
    $options = [];
    $userTimezone = new \DateTimeZone(drupal_get_user_timezone());

    $dates = $this->connection->select('node__field_date', 'f')
      ->fields('f', ['field_date_value'])
      ->condition('bundle', 'seminar')
      ->execute()->fetchCol();
    if (!empty($dates)) {
      foreach ($dates as $date) {
        $date = new \DateTime($date, $userTimezone);
        $beginOfDayString = $date->format('Y-m-d 00:00:00');
        $timeStampFormatted = \DateTime::createFromFormat('Y-m-d H:i:s', $beginOfDayString);
        $options[$timeStampFormatted->getTimeStamp()] = $date->format('l, F j, Y');
      }
      ksort($options);
    }
    return $options;
  }

}
