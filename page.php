<?php while (have_posts()) : the_post();

// Profile / About
if(is_page(71)) {
  get_template_part( 'templates/pages/about' );

// Contact Page
} elseif(is_page(108)) {
  get_template_part( 'templates/pages/contact' );

}
else {
  get_template_part( 'templates/pages/_default' );
}

endwhile; ?>
