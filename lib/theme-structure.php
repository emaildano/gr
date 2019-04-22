<?php

namespace Apollo\Admin\Structure;

// NAV
// ============================================================
// Create a nav menu with very basic markup.
// Deletes all CSS classes and id's, except for those listed in the array below

function custom_wp_nav_menu_classes($classes, $item) {

  $shrunken_classes = array_intersect($classes, [
    // List of allowed menu classes
    'current-page-item',
    'current-page-ancestor',
    'current-menu-parent',
    'current-menu-ancestor',
    'current-menu-item'
  ] );

  // Replace existing classes with new ones
  $classes = $shrunken_classes;

  $menu_title = strtolower($item->title);
  $menu_title = preg_replace("/[^a-z0-9_\s-]/", "", $menu_title); // Make alphanumeric
  $menu_title = preg_replace("/[\s-]+/", " ", $menu_title);       // Clean up multiple dashes or whitespaces
  $menu_title = preg_replace("/[\s_]/", "-", $menu_title);        // Convert whitespaces and underscore to dash

  $classes[] = 'menu-' . $menu_title;

  return $classes;
}

add_filter('nav_menu_css_class', __NAMESPACE__ . '\\custom_wp_nav_menu_classes', 10, 2);

function strip_wp_nav_menu($var) {
  // Return to nothing
  return '';
}
add_filter('nav_menu_item_id', __NAMESPACE__ . '\\strip_wp_nav_menu');
add_filter('page_css_class', __NAMESPACE__ . '\\strip_wp_nav_menu');


// Replace class names with shorter ones
function current_to_active($text){
  $replace = array(
    //List of menu item classes that should be changed to "active"
    'current-menu-item' => 'active',
    'current-page-item' => 'active',
    'current-menu-parent'   => 'active',
    'current-page-ancestor' => 'ancestor',
    'current-menu-ancestor' => 'ancestor',
  );

  $text = str_replace( array_keys($replace), $replace, $text );



  return $text;

}

add_filter ('wp_nav_menu', __NAMESPACE__ . '\\current_to_active');


// Delete empty classes
function strip_empty_classes($menu) {
    $menu = preg_replace('/ class=""/','',$menu);
    return $menu;
}
add_filter ('wp_nav_menu', __NAMESPACE__ . '\\strip_empty_classes');



