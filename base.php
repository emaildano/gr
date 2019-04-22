<?php

namespace Apollo\Base;
use Apollo\Config\Condition;
use Apollo\Theme\Wrapper;

?>

<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
    </div>
  <![endif]-->

  <div class="slide-body-wrapper">

    <?php do_action('get_header');                  // WP Header (ignore)
    get_template_part( 'templates/header' );        // Theme Wrapper Header


    if( is_front_page() )               // Conditionally get the page header
      get_template_part( 'templates/page-header/_page-header-main' ); ?>

    <main class="main container" role="main">
      <?php
        // Content Container
        echo '<section class="main-content">';
          include Wrapper\template_path();
        echo '</section>';
      ?>
    </main>

    <?php
      get_template_part( 'templates/footer' );      // Theme Wrapper Footer

      if( is_front_page() ) {                         // Home page modal
        if(get_field('display_message_modal'))
          get_template_part( 'templates/pages/home-page-modal' );
      }

      wp_footer();                                  // WP Footer (ignore)
    ?>

  </div>
</body>
</html>
