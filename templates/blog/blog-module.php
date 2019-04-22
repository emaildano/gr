<?php
  $link_option = get_field('link_to_single');
  $content = get_field('archive_content');
?>

<section class="blog-module">
  <?php get_template_part('templates/blog/blog-entry-header' ); ?>

  <article>
    <?= $content ?>
  </article>

  <?php if($link_option) {
    echo '<a href="' . get_the_permalink() . '" class="read-more blank"></a>';
  } ?>

</section>