<?php

namespace Drupal\events\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Events entity entities.
 */
class EventsEntityViewsData extends EntityViewsData {

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
