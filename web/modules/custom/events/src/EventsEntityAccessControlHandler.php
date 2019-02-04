<?php

namespace Drupal\events;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Events entity entity.
 *
 * @see \Drupal\events\Entity\EventsEntity.
 */
class EventsEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\events\Entity\EventsEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished events entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published events entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit events entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete events entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add events entity entities');
  }

}
