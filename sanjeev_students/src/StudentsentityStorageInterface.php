<?php

namespace Drupal\sanjeev_students;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface StudentsentityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Studentsentity revision IDs for a specific Studentsentity.
   *
   * @param \Drupal\sanjeev_students\Entity\StudentsentityInterface $entity
   *   The Studentsentity entity.
   *
   * @return int[]
   *   Studentsentity revision IDs (in ascending order).
   */
  public function revisionIds(StudentsentityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Studentsentity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Studentsentity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\sanjeev_students\Entity\StudentsentityInterface $entity
   *   The Studentsentity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(StudentsentityInterface $entity);

  /**
   * Unsets the language for all Studentsentity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
