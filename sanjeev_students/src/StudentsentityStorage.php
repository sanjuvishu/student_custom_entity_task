<?php

namespace Drupal\sanjeev_students;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\sanjeev_students\Entity\StudentsentityInterface;

/**
 * Defines the storage handler class for Studentsentity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Studentsentity entities.
 *
 * @ingroup sanjeev_students
 */
class StudentsentityStorage extends SqlContentEntityStorage implements StudentsentityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(StudentsentityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {studentsentity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {studentsentity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(StudentsentityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {studentsentity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('studentsentity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
