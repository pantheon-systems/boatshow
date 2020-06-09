<?php

namespace Drupal\nmmacontentaccess\Form;

use Drupal\node\Entity\Node;
use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a form for deleting a nmmacontentaccess entity.
 *
 * @ingroup nmmacontentaccess
 */
class NmmaNodeDeleteForm extends ContentEntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    if ($this->entity->node_id[0]) {
      $see = Node::load($this->entity->node_id[0]->getValue()['target_id'])->get('title')->value;
    } else {
      $see = 'zzzzz';
    }
    return $this->t('Are you sure you want to delete entity %name?', ['%name' => $see]);
  }

  /**
   * {@inheritdoc}
   *
   * If the delete command is canceled, return to the NmmaNode list.
   */
  public function getCancelUrl() {
    return new Url('entity.nmmacontentaccess_node.collection');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   *
   * Delete the entity and log the event. logger() replaces the watchdog.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $entity->delete();

    // $this->logger('nmmacontentaccess')->notice('@type: deleted %title.',
    //   [
    //     '@type' => $this->entity->bundle(),
    //     '%title' => $this->entity->label(),
    //   ]);
    $form_state->setRedirect('entity.nmmacontentaccess_node.collection');
  }

}
