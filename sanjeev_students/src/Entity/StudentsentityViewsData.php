<?php

namespace Drupal\sanjeev_students\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Studentsentity entities.
 */
class StudentsentityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
