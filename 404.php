<?php

  // Bkg Image
  $project = get_field('page_lead_project', 4);
  $id = $project->ID;
  $image = get_field('featured_image', $id);


  // Featured Projects
  $content = get_field('featured_projects_content', 4);
  $featured = get_field('featured_projects', 4);

?>


<div class="wrapper-404 bkg-cover" style="background-image: url(<?= $image['sizes'][ '11x6_lg' ] ?>)">
  <div class="bkg-fade-dark"></div>
  <div class="content-404">
    <h1 class="head-1">Sorry, but the page you were trying to view does not exist.</h1>
    <p>It could be the result of either a mistyped address or an out-of-date link.</p>
  </div>
</div>

<div class="gray-panel featured-projects">

  <div class="featured-projects--content row">
    <p>While you're here, checkout some of our favorite projects:</p>
  </div>

  <div class="row">

    <?php
      foreach( $featured as $post) {
        setup_postdata( $post );
        get_template_part('templates/projects/project-mod');
      }
      wp_reset_postdata();
    ?>

  </div>

</div>