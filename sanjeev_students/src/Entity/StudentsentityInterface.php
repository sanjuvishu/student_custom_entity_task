<?php

namespace Drupal\sanjeev_students\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Studentsentity entities.
 *
 * @ingroup sanjeev_students
 */
interface StudentsentityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Studentsentity name.
   *
   * @return string
   *   Name of the Studentsentity.
   */
  public function getName();

  /**
   * Sets the Studentsentity name.
   *
   * @param string $name
   *   The Studentsentity name.
   *
   * @return \Drupal\sanjeev_students\Entity\StudentsentityInterface
   *   The called Studentsentity entity.
   */
  public function setName($name);

  /**
   * Gets the Studentsentity name.
   *
   * @return string
   *   Name of the Studentsentity.
   */
  public function getContactNumber();

  /**
   * Sets the Studentsentity name.
   *
   * @param string $name
   *   The Studentsentity name.
   *
   * @return \Drupal\sanjeev_students\Entity\StudentsentityInterface
   *   The called Studentsentity entity.
   */
  public function setContactNumber($contact_number);



  /**
   * Gets the Studentsentity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Studentsentity.
   */
  public function getCreatedTime();

  /**
   * Sets the Studentsentity creation timestamp.
   *
   * @param int $timestamp
   *   The Studentsentity creation timestamp.
   *
   * @return \Drupal\sanjeev_students\Entity\StudentsentityInterface
   *   The called Studentsentity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Studentsentity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Studentsentity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\sanjeev_students\Entity\StudentsentityInterface
   *   The called Studentsentity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Studentsentity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Studentsentity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\sanjeev_students\Entity\StudentsentityInterface
   *   The called Studentsentity entity.
   */
  public function setRevisionUserId($uid);

}
