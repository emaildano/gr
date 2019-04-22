<div class="blog-sidebar">
  <ol>
  <h3 class="head-5">View</h3>
  <?php
    $args = array(
      'type'            => 'monthly',
      'limit'           => 10,
      'show_post_count' => false,
    );
    wp_get_archives( $args );
  ?>
</div>