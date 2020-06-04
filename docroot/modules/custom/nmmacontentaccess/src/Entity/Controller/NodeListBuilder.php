<?php

namespace Drupal\nmmacontentaccess\Entity\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a list controller for nmmacontentaccess entity.
 *
 * @ingroup nmmacontentaccess
 */
class NodeListBuilder extends EntityListBuilder {

  /**
   * The url generator.
   *
   * @var \Drupal\Core\Routing\UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('url_generator')
    );
  }

  /**
   * Constructs a new NodeListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The url generator.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, UrlGeneratorInterface $url_generator) {
    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;
  }

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  public function render() {
    $build['description'] = [
      '#markup' => $this->t('NmmaNodeAccess Example implements a NmmaNodeAccess node model. These NmmaNodeAccess nodes are fieldable entities. You can manage the fields on the <a href="@adminlink">NmmaNodeAccess content nodes admin page</a>.  GOING TO REMOVE THIS TEXT ALTOGETHER.  CORY/JAMES, WOULD YOU MIND CONTRIBUTING TO WHAT THE TEXT SHOULD BE?', [
        '@adminlink' => $this->urlGenerator->generateFromRoute('nmmacontentaccess.nmmanode_settings'),
      ]),
    ];
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the NmmaNode list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    //$header['id'] = $this->t('NmmaNodeID');
    //$header['name'] = $this->t('Name');
    $header['node_id'] = $this->t('Node');
    //$header['role'] = $this->t('Role');
    //$header['roles'] = $this->t('Roles');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\nmmacontentaccess\Entity\NmmaNode */
    //$row['id'] = $entity->id();
    //$row['name'] = $entity->toLink()->toString();
    if (Node::load($entity->node_id[0]->getValue()['target_id'])->get('title')->value) {
      $row['node_id'] = Node::load($entity->node_id[0]->getValue()['target_id'])->get('title')->value;
    } else {
      $row['node_id'] = '';
    }
    //$row['node_id'] = $entity->node_id->values['target_id'];
    //$row['role'] = $entity->role->value;
    //$row['roles'] = 'sdfasdf';
    //var_dump($entity->node_id[0]->getValue()['target_id']);
    return $row + parent::buildRow($entity);
  }

}
