<?php

namespace Apollo\Functions\Queries;

// // Change Posts Per Page and Order for Post Types
function manipulate_queries( $query ) {
  if ( is_admin() || is_search() )
    return;

  if ( is_post_type_archive( 'staff' ) ) {
    // Return all posts
    $query->set( 'posts_per_page', 50 );
    $query->set( 'order', 'ASC' );
    $query->set( 'orderby', 'menu_order' );
    $query->set('no_found_rows', true);
    return;
  }

  if ( is_post_type_archive( 'clients' ) ) {
    // Return all posts
    $query->set( 'posts_per_page', 500 );
    $query->set( 'order', 'ASC' );
    $query->set( 'orderby', 'title' );
    $query->set('no_found_rows', true);
    return;
  }

  if ( is_post_type_archive( 'projects' ) ) {
    // Return all posts
    $query->set( 'posts_per_page', 500 );
    $query->set( 'order', 'ASC' );
    $query->set( 'orderby', 'menu_order' );
    $query->set('no_found_rows', true);
    return;
  }
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\\manipulate_queries', 1 );

?>