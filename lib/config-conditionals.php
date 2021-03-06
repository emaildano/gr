<?php

namespace Apollo\Config\Condition;

// CUSTOM SIDEBAR TESTS
// ============================================================
/* If the conditional is a standard WP function, add to lib/config
 * Only add to this if a custom conditional is required.        */

function hide_sidebar() {
  if( !is_home() ) {
    return true;
  }
}

// HIDE PAGE HEADER
// ============================================================
/* If this conditional returns true, the page header will not
 * be displayed. See base.php                              */

function hide_page_header() {
  if( is_front_page() ) {
    return false;
  } else {
    return true;
  }
}

// SIDEBAR LAYOUT
// ============================================================
/* Determines which side the sidebar should be on. This
 * function should only return 'R' or 'L'                    */

function sidebar_switch() {

  // if( is_page('blog') ) {
  //   // Return the opposite of existing default
  //   return true;
  // }

}

// THEME SPECIFIC CUSTOM CONDITIONALS
// ============================================================

// If the event is a Tribe Event
// function is_tribe() {
  // if(function_exists('tribe_is_event')) {
  //   if(tribe_is_event())
  //     return true;
  // }
// }
