<?php

namespace Apollo\Extend\Util;

// BODY CLASSES
// ============================================================

function add_custom_body_classes( $classes ) {
  global $post;

  // Add Non-Development Env Class
  if(WP_ENV === 'development') {
    $classes[] = 'development-env';
  }

  // Front Page
  if(is_front_page()) {
    $classes[] = 'front-page';
  }

  // Pages
  if( is_page() ) {
    $classes[] = 'page-' . $post->post_name;
  }

  if( is_post_type_archive() ) {
    global $wp_query;
    $classes[] = $wp_query->query['post_type'] . '-archive';
  }

  if ( get_post_type() === 'post' && !is_search() ) {
    $classes[] = 'news-page';
  }


  return $classes;
}
add_filter( 'body_class', __NAMESPACE__ . '\\add_custom_body_classes' );


// Add Active class to archives link in sidebar
function theme_get_archives_link ( $link_html ) {
    global $wp;
    static $current_url;
    if ( empty( $current_url ) ) {
        $current_url = add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
    }
    if ( stristr( $current_url, 'page' ) !== false ) {
    $current_url = substr($current_url, 0, strrpos($current_url, 'page'));
    }
    if ( stristr( $link_html, $current_url ) !== false ) {
        $link_html = preg_replace( '/(<[^\s>]+)/', '\1 class="active"', $link_html, 1 );
    }
    return $link_html;
}
add_filter('get_archives_link', __NAMESPACE__ . '\\theme_get_archives_link');





/**
 * Custom Nav Menu
 * Creates clean nav (just links) and then wraps links in groups of 2
 *
 * @return  string  html string to output
 */

function Ground_Nav() {

  if (has_nav_menu('primary_navigation')) {
    $html = '';

    // Get the menu
    $primary_nav = wp_nav_menu( array(
      'theme_location' => 'primary_navigation',
      'depth' => 3,
      'menu_class' => '',
      'items_wrap'=>'%3$s',
      'container' => false,
      'echo' => false
    ) );

    // Replace li elements with links
    $find = array('><a','<li');
    $replace = array('','<a');
    $primary_nav = str_replace( $find, $replace, $primary_nav );

    // Tear list apart, get rid of empty items
    $nav = array_filter( explode('<a', $primary_nav) );
    $count = 1;

    // Build output
    foreach($nav as $item) {
      if($count === 1)
        $html .= '<div class="navigation--menu--group">';

      $html .= '<a' . $item . '</a>';

      if($count === 2) {
        $html .= '</div>';
        $count = 0;
      }

      $count ++;
    }

  }

  return $html;
}




/**
 * Filter Projects Cache
 * Create a cache of the terms. Create the cache everytime a new term is created.
 *
 * Ala https://10up.github.io/Engineering-Best-Practices/php/#performance
 */

// Refresh cached on save
// function refresh_terms_for_filter( $post_id ) {
//   $type = get_post_type($post_id);

//   if($type === 'projects') {
//     // Force the cache refresh for top-commented posts.
//     namespace\get_terms_for_filter( $force_refresh = true );
//   }
// }
// add_action( 'save_post', __NAMESPACE__ . '\\refresh_terms_for_filter' );



// // Fetch cache
// function get_terms_for_filter($force_refresh = false) {
//   // Check for the top_commented_posts key in the 'top_posts' group.
//   $filter_terms = wp_cache_get( 'ground_filter_terms', 'ground_filter_terms_group' );

//   // If nothing is found, build the object.
//   if ( true === $force_refresh || false === $filter_terms ) {
//     echo 'REBUILDING';

//     // Get terms for the project_type taxonomy
//     $args = [
//       'orderby' => 'id',
//       'order' => 'ASC'
//     ];
//     $filter_terms = get_terms('project_type', $args);

//     if ( ! is_wp_error( $filter_terms ) ) {
//       // Set a cache without an expiration.
//       wp_cache_set( 'ground_filter_terms', $filter_terms, 'ground_filter_terms_group' );
//     }
//   }
//   return $filter_terms;
// }
