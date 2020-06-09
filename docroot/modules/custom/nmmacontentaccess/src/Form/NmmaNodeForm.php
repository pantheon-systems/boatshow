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

    // $form['langcode'] = [
    //   '#title' => $this->t('Language'),
    //   '#type' => 'language_select',
    //   '#default_value' => $entity->getUntranslated()->language()->getId(),
    //   '#languages' => Language::STATE_ALL,
    // ];
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

    // if ($source['path'] == '<front>') {
    //   $form_state->setErrorByName('redirect_source', $this->t('It is not allowed to create a redirect from the front page.'));
    // }
    // if (strpos($source['path'], '#') !== FALSE) {
    //   $form_state->setErrorByName('redirect_source', $this->t('The anchor fragments are not allowed.'));
    // }
    // if (strpos($source['path'], '/') === 0) {
    //   $form_state->setErrorByName('redirect_source', $this->t('The url to redirect from should not start with a forward slash (/).'));
    // }
    //
    // try {
    //   $source_url = Url::fromUri('internal:/' . $source['path']);
    //   $redirect_url = Url::fromUri($redirect['uri']);
    //
    //   // It is relevant to do this comparison only in case the source path has
    //   // a valid route. Otherwise the validation will fail on the redirect path
    //   // being an invalid route.
    //   if ($source_url->toString() == $redirect_url->toString()) {
    //     $form_state->setErrorByName('redirect_redirect', $this->t('You are attempting to redirect the page to itself. This will result in an infinite loop.'));
    //   }
    // }
    // catch (\InvalidArgumentException $e) {
    //   // Do nothing, we want to only compare the resulting URLs.
    // }
    //
    // $parsed_url = UrlHelper::parse(trim($source['path']));
    // $path = isset($parsed_url['path']) ? $parsed_url['path'] : NULL;
    // $query = isset($parsed_url['query']) ? $parsed_url['query'] : NULL;
    // $hash = Redirect::generateHash($path, $query, $form_state->getValue('language')[0]['value']);

    // Search for duplicate.
    $redirects = \Drupal::entityManager()
      ->getStorage('nmmacontentaccess_node')
      ->loadByProperties(['node_id' => $node_id]);

    if (!empty($redirects)) {
      //var_dump($redirects);
      $redirect = array_shift($redirects);
      if ($this->entity->isNew() || $redirect->id() != $this->entity->id()) {
        $form_state->setErrorByName('node_id', $this->t('There is already a content restriction rule for this node'));
      }
    }
  }
}
