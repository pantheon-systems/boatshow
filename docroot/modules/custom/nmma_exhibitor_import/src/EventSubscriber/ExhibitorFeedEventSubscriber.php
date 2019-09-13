<?php

/**
 * @file
 * Contains Drupal\nmma_exhibitor_import\EventSubscriber\ExhibitorFeedEventSubscriber
 */

namespace Drupal\nmma_exhibitor_import\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\feeds\Event\FeedsEvents;
use Drupal\feeds\Event\EntityEvent;
use Drupal\feeds\Event\ProcessEvent;
use Drupal\feeds\Event\ParseEvent;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

class ExhibitorFeedEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [];
    $events[FeedsEvents::PROCESS][] = ['onProcess', 1000];
    $events[FeedsEvents::PARSE][] = ['onParse', 1000];
    $events[FeedsEvents::PROCESS_ENTITY_PREVALIDATE][] = ['onProcessEntityPrevalidate', 1000];
    $events[FeedsEvents::PROCESS_ENTITY_PRESAVE][] = ['onProcessEntityPresave', 1000];
    $events[FeedsEvents::PROCESS_ENTITY_POSTSAVE][] = ['onProcessEntityPostsave', 1000];
    return $events;
  }

  public function onParse (ParseEvent $event) {
  }

  public function onProcess(ProcessEvent $event) {
    $item = $event->getItem();

    // Copy and flatten booths data before feeds tries to add it to the text field, this helps to prevent triggering a notice
    $booths = $item->get('booths');
    $item->set('booths', json_encode($booths));
    $item->set('booths_array', $booths);
  }

  public function onProcessEntityPrevalidate(EntityEvent $event) {
  }


  public function onProcessEntityPresave(EntityEvent $event) {
    $item = $event->getItem();
    $exhibitorEntity = $event->getEntity();

    // Foreach booth in API Data -> booth -> number
    $feedBooths = $item->get('booths_array');
    $boothNodes = [];

    // Conver feed booths (simple associative arrays) to booth nodes
    foreach ($feedBooths as $feedBooth) {
      $boothNodes[] = $this->boothNodeFromBoothNumber($feedBooth['booth'], $feedBooth['building']);
    }

    $boothNodesWithParagraphs = [];

    // Loop through existing paragraphs
    foreach ($exhibitorEntity->get('field_exhibitor_location')->referencedEntities() as $paragraph) {
      $paragraphBoothId = $paragraph->field_exhbtr_lctn_booth[0]->target_id;

      $foundBooth = FALSE;
      foreach ($boothNodes as $boothNode) {
        if ($boothNode->id() == $paragraphBoothId) {
          $boothNodesWithParagraphs[] = $boothNode;
          $foundBooth = TRUE;
          break;
        }
      }

      // Paragraph exists which has a booth which did not come in over the feed, set field_enabled to false
      if (!$foundBooth) {
        $paragraph->field_enabled = 0;
      }
      else {
        $paragraph->field_enabled = 1;
      }

      $paragraph->save();
    }

    // Custom array diff based on object IDs
    $boothNodesWithoutParagraphs = array_udiff($boothNodes, $boothNodesWithParagraphs, function ($obj_a, $obj_b) {
      return $obj_a->id() - $obj_b->id();
    });

    foreach ($boothNodesWithoutParagraphs as $boothNode) {
      $paragraph = Paragraph::create([
        'type' => 'exhibitor_location',
        'field_exhbtr_lctn_booth' => [
          [
            'target_id' => $boothNode->id()
          ]
        ],
        'field_enabled' => '1'
      ]);

      $paragraph->save();

      $exhibitorEntity->field_exhibitor_location->appendItem($paragraph);
    }

    // $exhibitorEntity->save(); // Not necessary to save here, as entity will be saved after this event is fired
  }

  public function onProcessEntityPostSave(EntityEvent $event) {
  }

  protected function boothNodeFromBoothNumber ($boothNumber, $boothBuilding) {
    // EntityQuery booth nodes looking for the booth number
    $query = \Drupal::entityQuery('node');
      $query->condition('status', 1);
      $query->condition('type', 'booth');
      $query->condition('title', $boothNumber);
      $exhibitorEntity_ids = $query->execute();

    // If booth node exists, use it
    if (count($exhibitorEntity_ids)) {
      $booth = Node::load(reset($exhibitorEntity_ids));
    }
    // If booth node does not exist, create it
    else {
      $booth = Node::create([
        'type' => 'booth',
        'title' => $boothNumber,
        'field_booth_location' => $boothBuilding
      ]);

      $booth->save();
    }

    return $booth;
  }

}
