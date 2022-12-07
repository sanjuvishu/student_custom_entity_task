<?php

/**
 * @file
 * Contains studentsentity.page.inc.
 *
 * Page callback for Studentsentity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Studentsentity templates.
 *
 * Default template: studentsentity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_studentsentity(array &$variables) {
  // Fetch Studentsentity Entity Object.
  $studentsentity = $variables['elements']['#studentsentity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
