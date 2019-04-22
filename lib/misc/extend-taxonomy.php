<?php

namespace Apollo\Extend\Taxonomies;
use Apollo\Extend\PostTypes;

// Project Types
function project_types_tax() {

  $labels = PostTypes\label_factory('Project Types', 'Project Type', 'Project Types');

  $rewrite = array(
    'slug'                       => 'project-type',
    'with_front'                 => true,
    'hierarchical'               => false,
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => false,
    'show_tagcloud'              => true,
    'rewrite'                    => $rewrite,
  );

  register_taxonomy( 'project_type', array( 'projects' ), $args );

}
add_action( 'init', __NAMESPACE__ . '\project_types_tax', 0 );



// Client Categorization
function client_types_tax() {

  $labels = PostTypes\label_factory('Client Types', 'Client Type', 'Client Types');

  $rewrite = array(
    'slug'                       => 'client-type',
    'with_front'                 => true,
    'hierarchical'               => false,
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => false,
    'show_tagcloud'              => true,
    'rewrite'                    => $rewrite,
  );

  register_taxonomy( 'client_type', array( 'clients' ), $args );

}
add_action( 'init', __NAMESPACE__ . '\client_types_tax', 0 );





?>
