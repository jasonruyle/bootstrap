<?php
/**
 * @file
 * menu-local-action.vars.php
 */

use Drupal\Component\Utility\String;

/**
 * Overrides theme_menu_local_action().
 *
 * Prepares variables for single local action link templates.
 *
 * Default template: menu-local-action.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - element: A render element containing:
 *     - #link: A menu link array with 'title', 'url', and (optionally)
 *       'localized_options' keys.
 */
function bootstrap_preprocess_menu_local_action(&$variables) {
  $link = $variables['element']['#link'];
  $link += array(
    'localized_options' => array(),
  );
  $link['localized_options']['set_active_class'] = TRUE;

  $icon = _bootstrap_iconize_text($link['title']);
  $options = isset($link['localized_options']) ? $link['localized_options'] : array();

  if (isset($link['url'])) {
    // Turn link into a mini-button and colorize based on title.
    if ($class = _bootstrap_colorize_text($link['title'])) {
      if (!isset($options['attributes']['class'])) {
        $options['attributes']['class'] = array();
      }
      $string = is_string($options['attributes']['class']);
      if ($string) {
        $options['attributes']['class'] = explode(' ', $options['attributes']['class']);
      }
      $options['attributes']['class'][] = 'btn';
      $options['attributes']['class'][] = 'btn-xs';
      $options['attributes']['class'][] = 'btn-' . $class;
      if ($string) {
        $options['attributes']['class'] = implode(' ', $options['attributes']['class']);
      }
    }

    $variables['link'] = array(
      '#type' => 'link',
      '#title' => String::format($icon . '@text', array('@text' => $link['title'])),
      '#options' => $options,
      '#url' => $link['url'],
    );
  }
  else {
    $variables['link'] = array(
      '#type' => 'markup',
      '#value' => $icon . $link['title'],
    );
  }
}
