<?php

/*
Usage:

```
vm$ cd /var/www/boatshow/docroot
vm$ drush -l miami php-script ../tools/page-bricks.php > /vagrant/brick-report.csv
```
 */

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use \Drupal\eck\Entity\EckEntity;

$type_definitions = [

  [
    'entity_type' => 'block_content',
    'field_name' => 'field_custom_block_bricks'
  ],
  [
    'entity_type' => 'brick',
    'field_name' => 'field_brick_accordion_item'
  ],
  [
    'entity_type' => 'colossal_menu_link',
    'field_name' => 'field_bricks'
  ],
  [
    'entity_type' => 'node',
    'field_name' => 'field_body',
  ],
  [
    'entity_type' => 'node',
    'field_name' => 'field_body_blocks',
  ],
  [
    'entity_type' => 'node',
    'field_name' => 'field_component_bricks',

  ],
  [
    'entity_type' => 'node',
    'field_name' => 'field_test_brick',
  ]
];

foreach ($type_definitions as $type_definition) {

  $query = \Drupal::entityQuery($type_definition['entity_type']);
  $query->condition($type_definition['field_name'], NULL, 'IS NOT NULL');

  $entity_ids = $query->execute();

  foreach ($entity_ids as $entity_id) {
    $entity = \Drupal::entityTypeManager()
      ->getStorage($type_definition['entity_type'])
      ->load($entity_id);

    $bricks_on_entity = $entity->{$type_definition['field_name']}->getValue();

    foreach($bricks_on_entity as $brick_eref) {
      $brickEntity = EckEntity::load($brick_eref['target_id']);

      if (!$brickEntity) continue;

      $csvData[] = [
        'id' => $brickEntity->id(),
        'bundle' => $brickEntity->bundle(),
        'css_classes' => $brick_eref['options']['css_class'],
        // 'view_mode' => $brick_eref['options']['view_mode'],
        'layout' => $brick_eref['options']['layout'],
        'on' => $type_definition['entity_type'] . ':' . $entity->id() . ':' . $type_definition['field_name']
      ];
    }
  }
}

$serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

// encoding contents in CSV format
$csvOut = $serializer->encode($csvData, 'csv');

echo $csvOut;
