<?php

namespace Drupal\sanjeev_students;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Studentsentity entities.
 *
 * @ingroup sanjeev_students
 */
class StudentsentityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Roll Number');
    $header['name'] = $this->t('Name');
    $header['class_name'] = $this->t('Class Name');
    $header['contact_number'] = $this->t('Contact Number');
    $header['status'] = $this->t('Status');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\sanjeev_students\Entity\Studentsentity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.studentsentity.edit_form',
      ['studentsentity' => $entity->id()]
    );
    $row['class_name'] = $entity->id();
    $row['contact_number'] = $entity->id();
    $row['status'] = $entity->id();
    return $row + parent::buildRow($entity);
  }

}
