<?php

/**
 * @file
 * Provide views hook/functions for NMMA Seminars.
 */

/**
 * Implements hook_views_data_alter().
 */
function nmma_seminars_views_data_alter(array &$data) {
  $data['node_field_data']['seminar_schedule'] = [
    'title' => t('Filter Seminars By Date'),
    'filter' => [
      'title' => t('Filter Seminars By Schedule Date'),
      'help' => t('Provides a custom filter for seminars.'),
      'field' => 'field_date',
      'id' => 'seminar_schedule',
    ],
  ];
}
