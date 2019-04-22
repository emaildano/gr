<?php

if(have_posts()) :
  $archives = [];
  $archive_count = 0;
  $attr = '';

  /**
   * If a type parameter is passed in the url, add it to the wrapper
   * as an attribute to allow sorting on load.
   */
  if(isset($_GET['type'])) {
    $type = $_GET['type'];
    $attr .= ' data-filtered="filter-' . str_replace('filter-', '', $type) . '"';
  }

  /****************************************************************************
   * Main Projects
   */

  echo '<h2 class="project-archive-title bump js--title">Projects</h2>';

  echo '<div id="js--filter-container" class="row project-wrapper" ' . $attr . '>';

    while(have_posts()) : the_post();

      global $post;
      $to_archive = false;

      // Begin post class
      $class = 'filter-all';

      // Get terms and add slug as class
      $terms = get_the_terms( $post, 'project_type' );

      if($terms) {
        foreach ($terms as $term) {
          $class .= ' filter-' . $term->slug;

          // Setup var to pass post to archive array
          if($term->slug === 'archive') {
            $to_archive = true;
          }
        }

      // If no terms
      } else {
        $class .= ' filter-unfilterable';
      }

      // Add menu order
      $post_mod_attr = 'data-order="' . $post->menu_order . '"';


      // Add archive posts to archive array
      if($to_archive) {
        $post->archive_class = $class;
        $post->archive_order = $post_mod_attr;
        $archives[] = $post;

      } else {
        include(TEMPLATEPATH . '/templates/projects/project-mod.php');
      }


    endwhile;
  echo '</div>';





  /****************************************************************************
   * Archived Projects
   */

  if($archives) :

    echo '<div id="js--filter-archive" class="row project-archive-wrapper gray-panel" ' . $attr . '>';

      echo '<h2 class="project-archive-title bump">Additional Projects</h2>';

      foreach($archives as $archive) {
        include(TEMPLATEPATH . '/templates/projects/archive-mod.php');
      }

    echo '</div>';

  endif;





  /****************************************************************************
   * Vaults (places to hide filtered-out projects)
   */

  echo '<div id="js--filter-vault" class="project-filter-vault"></div>';

  if($archives)
    echo '<div id="js--filter-archive-vault" class="archive-filter-vault"></div>';

endif;
