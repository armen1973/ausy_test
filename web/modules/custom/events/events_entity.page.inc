<?php

/**
 * @file
 * Contains events_entity.page.inc.
 *
 * Page callback for Events entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Events entity templates.
 *
 * Default template: events.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_events_entity(array &$variables) {
  // Fetch EventsEntity Entity Object.
  $events_entity = $variables['elements']['#events_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
