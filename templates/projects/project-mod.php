<?php
  global $post;

  $image = get_field('featured_image'); $alt = $image['alt'];
  $imageSize = $image['sizes'][ '4x3_md' ];
  $link = get_permalink();
  $default_class = 'project-module bump-nth';

  /**
   * $post_mod_attr is set in archive-projects.php
   * $class is set in archive-projects.php
   *
   * This allows for posts to be added to archive array on archive-projects.php
   * while maintaining as DRY of a module as possible.
   */
  if(isset($post_mod_attr)) {
    $class .= ' ' . $default_class;
    $attr = $post_mod_attr;
  } else {
    $class = $default_class;
    $attr = '';
  }
?>

<div class="<?= $class ?> fade-in" <?= $attr ?>>
  <div class="project-module--image-wrapper">
    <a href="<?= $link ?>" class="project-module--img-wrap">
      <picture>
        <!--[if IE 9]><video style="display: none;"><![endif]-->
        <source srcset="<?= $image['sizes'][ '4x3_md' ] ?>" media="(min-width: 600px)" />
        <!--[if IE 9]></video><![endif]-->
        <img srcset="<?= $image['sizes'][ '4x3_sm' ] ?>" alt="<?= $image['alt'] ?>" />
      </picture>
    </a>
  </div>
  <a href="<?= $link ?>" class="project-link"><?=  get_the_title() ?></a>
</div>