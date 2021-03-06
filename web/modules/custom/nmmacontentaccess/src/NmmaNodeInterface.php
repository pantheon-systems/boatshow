<?php

namespace Drupal\nmmacontentaccess;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a NmmaNode entity.
 *
 * We have this interface so we can join the other interfaces it extends.
 *
 * @ingroup nmmacontentaccess
 */
interface NmmaNodeInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
