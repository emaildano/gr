<?php

namespace Apollo\Extend\PostTypes;

function label_factory($name, $singular, $plural) {

  $labels = array(
    'name'                  => $name,
    'singular_name'         => $singular,
    'menu_name'             => $name,
    'name_admin_bar'        => $name,
    'parent_item_colon'     => 'Parent ' . $singular . ':',
    'all_items'             => 'All ' . $plural,
    'add_new_item'          => 'Add New ' . $singular,
    'add_new'               => 'Add New',
    'new_item'              => 'New ' . $singular,
    'edit_item'             => 'Edit ' . $singular,
    'update_item'           => 'Update ' . $singular,
    'view_item'             => 'View ' . $singular,
    'search_items'          => 'Search ' . $singular,
    'not_found'             => 'Not found',
    'not_found_in_trash'    => 'Not found in Trash',
    'items_list'            => $plural . ' list',
    'items_list_navigation' => $plural . ' list navigation',
    'filter_items_list'     => 'Filter ' . $plural . ' list'
  );

  return $labels;
}

// Refer to: http://generatewp.com/post-type/


// Register Custom Post Type
function projects_cpt() {

  $labels = label_factory('Projects', 'Project', 'Projects');

  $args = array(
    'label'                 => 'Projects',
    'labels'                => $labels,
    'supports'              => array( 'title', ),
    'taxonomies'            => array( 'project_type' ),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 20,
    'menu_icon'             => 'dashicons-hammer',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => false,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    'show_in_rest'          => true
  );
  register_post_type( 'projects', $args );

}
add_action( 'init', __NAMESPACE__ . '\\projects_cpt', 0 );


// Register Custom Post Type
function clients_cpt() {

  $labels = label_factory('Clients', 'Client', 'Clients');

  $args = array(
    'label'                 => 'Clients',
    'labels'                => $labels,
    'supports'              => array( 'title', ),
    'taxonomies'            => array( 'client_type' ),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 20,
    'menu_icon'             => 'dashicons-clipboard',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => false,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'clients', $args );

}
add_action( 'init', __NAMESPACE__ . '\\clients_cpt', 0 );



// Register STAFF Custom Post Type
function staff_cpt() {

  $labels = label_factory('Staff', 'Staff', 'Staff');

  $args = array(
    'label'                 => 'Staff',
    'labels'                => $labels,
    'supports'              => array( 'title', ),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 20,
    'menu_icon'             => 'dashicons-nametag',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => false,
    'can_export'            => true,
    'has_archive'           => 'people',
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'staff', $args );

}
add_action( 'init', __NAMESPACE__ . '\\staff_cpt', 0 );


