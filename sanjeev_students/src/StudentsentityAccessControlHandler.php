<?php

namespace Drupal\sanjeev_students;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Studentsentity entity.
 *
 * @see \Drupal\sanjeev_students\Entity\Studentsentity.
 */
class StudentsentityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\sanjeev_students\Entity\StudentsentityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished studentsentity entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published studentsentity entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit studentsentity entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete studentsentity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add studentsentity entities');
  }


}
