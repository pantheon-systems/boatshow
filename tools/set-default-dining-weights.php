<?php

/*

A quick drush script to set default weights to 0 for all food and bev items

Usage:

```
vm$ cd /var/www/boatshow/docroot
vm$ drush -l miami php-script ../tools/set-default-dining-weights.php
```
 */

$query = \Drupal::entityQuery('node');
$query->condition('type','dining');
$query->condition('field_weight', NULL, 'IS NULL');

$entity_ids = $query->execute();

foreach ($entity_ids as $entity_id) {
  echo("\r\nupdating ${entity_id}");
  $node = \Drupal\node\Entity\Node::load($entity_id);

  $node->set('field_weight', '0');
  $node->save();
}
