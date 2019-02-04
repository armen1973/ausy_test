<?php

namespace Drupal\events\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Events entity entities.
 *
 * @ingroup events
 */
interface EventsEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Events entity name.
   *
   * @return string
   *   Name of the Events entity.
   */
  public function getName();

  /**
   * Sets the Events entity name.
   *
   * @param string $name
   *   The Events entity name.
   *
   * @return \Drupal\events\Entity\EventsEntityInterface
   *   The called Events entity entity.
   */
  public function setName($name);

  /**
   * Gets the Events entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Events entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Events entity creation timestamp.
   *
   * @param int $timestamp
   *   The Events entity creation timestamp.
   *
   * @return \Drupal\events\Entity\EventsEntityInterface
   *   The called Events entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Events entity published status indicator.
   *
   * Unpublished Events entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Events entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Events entity.
   *
   * @param bool $published
   *   TRUE to set this Events entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\events\Entity\EventsEntityInterface
   *   The called Events entity entity.
   */
  public function setPublished($published);

}
