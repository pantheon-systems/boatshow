<?php

namespace Drupal\nmmacontentaccess\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\nmmacontentaccess\NmmaNodeInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Defines the ContentEntityExample entity.
 *
 * @ingroup nmmacontentaccess
 *
 * This is the main definition of the entity type. From it, an EntityType object
 * is derived. The most important properties in this example are listed below.
 *
 * id: The unique identifier of this entity type. It follows the pattern
 * 'moduleName_xyz' to avoid naming conflicts.
 *
 * label: Human readable name of the entity type.
 *
 * handlers: Handler classes are used for different tasks. You can use
 * standard handlers provided by Drupal or build your own, most probably derived
 * from the ones provided by Drupal. In detail:
 *
 * - view_builder: we use the standard controller to view an instance. It is
 *   called when a route lists an '_entity_view' default for the entity type.
 *   You can see this in the entity.nmmacontentaccess_node.canonical
 *   route in the nmmacontentaccess.routing.yml file. The view can be
 *   manipulated by using the standard Drupal tools in the settings.
 *
 * - list_builder: We derive our own list builder class from EntityListBuilder
 *   to control the presentation. If there is a view available for this entity
 *   from the views module, it overrides the list builder if the "collection"
 *   key in the links array in the Entity annotation below is changed to the
 *   path of the View. In this case the entity collection route will give the
 *   view path.
 *
 * - form: We derive our own forms to add functionality like additional fields,
 *   redirects etc. These forms are used when the route specifies an
 *   '_entity_form' or '_entity_create_access' for the entity type. Depending on
 *   the suffix (.add/.default/.delete) of the '_entity_form' default in the
 *   route, the form specified in the annotation is used. The suffix then also
 *   becomes the $operation parameter to the access handler. We use the
 *   '.default' suffix for all operations that are not 'delete'.
 *
 * - access: Our own access controller, where we determine access rights based
 *   on permissions.
 *
 * More properties:
 *
 *  - base_table: Define the name of the table used to store the data. Make sure
 *    it is unique. The schema is automatically determined from the
 *    BaseFieldDefinitions below. The table is automatically created during
 *    installation.
 *
 *  - entity_keys: How to access the fields. Specify fields from
 *    baseFieldDefinitions() which can be used as keys.
 *
 *  - links: Provide links to do standard tasks. The 'edit-form' and
 *    'delete-form' links are added to the list built by the
 *    entityListController. They will show up as action buttons in an additional
 *    column.
 *
 *  - field_ui_base_route: The route name used by Field UI to attach its
 *    management pages. Field UI module will attach its Manage Fields,
 *    Manage Display, and Manage Form Display tabs to this route.
 *
 * There are many more properties to be used in an entity type definition. For
 * a complete overview, please refer to the '\Drupal\Core\Entity\EntityType'
 * class definition.
 *
 * The following construct is the actual definition of the entity type which
 * is read and cached. Don't forget to clear cache after changes.
 *
 * @ContentEntityType(
 *   id = "nmmacontentaccess_node",
 *   label = @Translation("NmmaNode entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\nmmacontentaccess\Entity\Controller\NodeListBuilder",
 *     "form" = {
 *       "default" = "Drupal\nmmacontentaccess\Form\NmmaNodeForm",
 *       "delete" = "Drupal\nmmacontentaccess\Form\NmmaNodeDeleteForm",
 *     },
 *     "access" = "Drupal\nmmacontentaccess\NmmaNodeAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "nmmanode",
 *   admin_permission = "administer nmmanode entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/nmmacontentaccess_node/{nmmacontentaccess_node}",
 *     "edit-form" = "/nmmacontentaccess_node/{nmmacontentaccess_node}/edit",
 *     "delete-form" = "/nmmanode/{nmmacontentaccess_node}/delete",
 *     "collection" = "/nmmacontentaccess_node/list"
 *   },
 *   field_ui_base_route = "nmmacontentaccess.nmmanode_settings",
 * )
 *
 * The 'links' above are defined by their path. For core to find the
 * corresponding route, the route name must follow the correct pattern:
 *
 * entity.<entity_type>.<link_name>
 *
 * Example: 'entity.nmmacontentaccess_node.canonical'.
 *
 * See the routing file at nmmacontentaccess.routing.yml for the
 * corresponding implementation.
 *
 * The NmmaNode class defines methods and fields for the nmmanode entity.
 *
 * Being derived from the ContentEntityBase class, we can override the methods
 * we want. In our case we want to provide access to the standard fields about
 * creation and changed time stamps.
 *
 * Our interface (see NmmaNodeInterface) also exposes the EntityOwnerInterface.
 * This allows us to provide methods for setting and providing ownership
 * information.
 *
 * The most important part is the definitions of the field properties for this
 * entity type. These are of the same type as fields added through the GUI, but
 * they can by changed in code. In the definition we can define if the user with
 * the rights privileges can influence the presentation (view, edit) of each
 * field.
 *
 * The class also uses the EntityChangedTrait trait which allows it to record
 * timestamps of save operations.
 */
class NmmaNode extends ContentEntityBase implements NmmaNodeInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the NmmaNode entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the NmmaNode entity.'))
      ->setReadOnly(TRUE);

      $fields['node_id'] = BaseFieldDefinition::create('entity_reference')
        ->setLabel(t('Content Node Name'))
        ->setDescription(t('The name of the content node'))
        ->setRevisionable(TRUE)
        ->setRequired(TRUE)
        ->setSetting('target_type', 'node')
        ->setSetting('handler', 'default')
        ->setSetting('handler_settings', [
          'target_bundles' => [
            'article' => 'article',
            'component_page' => 'component_page'
            ]
          ])
        ->setTranslatable(FALSE)
        ->setDisplayOptions('view', [
          'label' => 'inline',
          'type' => 'entity_reference_label',
          'weight' => 1,
        ])
        ->setCardinality(1)
        ->setDisplayOptions('form', [
          'type' => 'entity_reference_autocomplete',
          'weight' => 0,
          'settings' => [
            'match_operator' => 'CONTAINS',
            'size' => '60',
            'autocomplete_type' => 'tags',
            'placeholder' => '',
          ],
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

      $fields['roles'] = BaseFieldDefinition::create('entity_reference')
        ->setLabel(t('User Roles'))
        ->setDescription(t('User roles that are allowd to edit the content'))
        ->setRevisionable(TRUE)
        ->setSetting('target_type', 'user_role')
        ->setSetting('handler', 'default')
        ->setCardinality(FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED)
        ->setTranslatable(FALSE)
        ->setDisplayOptions('view', [
          'label' => 'inline',
          'type' => 'entity_reference_label',
          'weight' => 5,
        ])
        ->setDisplayOptions('form', [
          'type' => 'options_buttons',
          'weight' => 5,
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);
    // $fields['langcode'] = BaseFieldDefinition::create('language')
    //   ->setLabel(t('Language code'))
    //   ->setDescription(t('The language code of ContentEntityExample entity.'));
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
