<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php Apollo\Extend\Util\get_search_form(); ?>
<?php endif; ?>


<?php get_template_part('templates/blog/blog-sidebar' ); ?>

<div class="blog-entries">
  <?php while (have_posts()) : the_post();
    get_template_part('templates/blog/blog-module');
  endwhile;

  the_posts_navigation(); ?>

</div>