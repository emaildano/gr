<?php

namespace Apollo\Extend\Admin;

// =============================================================================
// Functions to alter the appearance of admin pages
// =============================================================================

// Hide Features in Editor
// =============================================================================

add_action( 'init', __NAMESPACE__ . '\\hide_on_screen', 10 );
function hide_on_screen() {

	$post_types = [
		'page',
		'post'
	];

	$features = [
	 'editor'
	];

	foreach ($post_types as $post_type) {
		foreach ($features as $feature) {
			remove_post_type_support( $post_type, $feature);
		}
	}
}

// Hide the Admin Bar in in dev
// =============================================================================

if(WP_ENV === 'development' || WP_ENV === 'staging') :
  add_filter('show_admin_bar', '__return_false');
endif;

// Change Posts to News
function change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'News Tags';
    echo '';
}
function change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}

add_action( 'admin_menu', __NAMESPACE__ . '\\change_post_label' );
add_action( 'init', __NAMESPACE__ . '\\change_post_object' );