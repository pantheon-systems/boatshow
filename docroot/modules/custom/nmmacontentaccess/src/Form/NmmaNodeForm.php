<?php

namespace Drupal\nmmacontentaccess\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the nmmacontentaccess entity edit forms.
 *
 * @ingroup nmmacontentaccess
 */
class NmmaNodeForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\nmmacontentaccess\Entity\NmmaNode */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.nmmacontentaccess_node.collection');
    $entity = $this->getEntity();
    $entity->save();
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    //$source = $form_state->getValue(['redirect_source', 0]);
    $node_id = $form_state->getValue(['node_id', 0]);


    // Search for duplicate.
    $restrictions = \Drupal::entityManager()
      ->getStorage('nmmacontentaccess_node')
      ->loadByProperties(['node_id' => $node_id]);

    if (!empty($restrictions)) {
      $restrictIt = array_shift($restrictions);
      if ($this->entity->isNew() || $restrictIt->id() != $this->entity->id()) {

        $form_state->setErrorByName('node_id', $this->t('There is already a content restriction rule for this node'));
      }
    }
  }
}
