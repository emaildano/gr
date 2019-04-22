<?php while(have_posts()) : the_post();
    global $post;

    $meta = get_post_meta( $post->ID );
    $image = get_field('headshot');
    // $alt = $image['alt'];
    // $imageSrc = $image['sizes'][ '2x3' ];
    $position = $meta['position'][0];
    $bio = get_field('bio');
    $bio_aside = get_field('bio_aside');
    $bio_image = get_field('bio_image');
    $projects = get_field('selected_projects');
    $content_class = !$projects ? 'staff--no-projects' : '';
?>

<div class="row">

  <div class="staff--headshot">
    <picture>
      <source srcset="<?= $image['sizes'][ '2x3_md' ] ?>" media="(min-width: 400px)" />
      <img srcset="<?= $image['sizes'][ '2x3_sm' ] ?>" alt="<?= $image['alt'] ?>" />
    </picture>
  </div>

  <?php if($bio_aside) { ?>
    <div class="resp-staff--bio-aside plus-aside">
      <p><?= $bio_aside ?></p>
    </div>
  <?php } ?>

  <div class="staff--content">
    <h1 class="head-1 lead"><?= get_the_title() ?></h1>
    <h1 class="head-1 subhead"><?= $position ?></h1>
    <?= $bio ?>

    <?php if($bio_aside) { ?>
      <div id="js-bio-aside" class="staff--content--bio-aside plus">
        <p><?= $bio_aside ?></p>
      </div>
    <?php } ?>
  </div>

  <?php if($projects) {
    echo '<div class="staff--projects">';
      echo '<ul class="staff--projects--list plus">';
        echo '<h3 class="head-5">Selected Projects</h3>';
        foreach ($projects as $project) {
          echo '<li><a href="' . get_permalink($project->ID) . '">';
            echo '<p class="head-5">' . get_the_title($project->ID) . '</p>';
            echo '<p class="head-6">' . get_post_meta( $project->ID, 'featured_detail', true ) . '</p>';
          echo '</a></li>';
        }
      echo '</ul>';
    echo '</div>';
  } ?>


  <?php if($bio_image) { ?>
    <div class="staff--alt-image <?= $content_class ?>">
    <picture>
      <source srcset="<?= $bio_image['sizes']['4x3_md'] ?>" media="(min-width: 600px)" />
      <img srcset="<?= $bio_image['sizes']['4x3_sm'] ?>" alt="<?= $image['alt'] ?>" />
    </picture>
    </div>
  <?php } ?>

</div>




<?php endwhile; ?>
