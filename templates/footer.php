<?php
  $line_one       = get_field('text_line_one', 'options');
  $line_two       = get_field('text_line_two', 'options');
  $link           = get_field('footer_link', 'options');
  $facebook_link  = get_field('facebook_url', 'options');
  $twitter_link   = get_field('twitter_url', 'options');
  $instagram_link = get_field('instagram_url', 'options');
  $linkedin_link  = get_field('linkedin_url', 'options'); 
?>


<footer class="global-footer" role="contentinfo">
  <div class="container footer-content">
    <a href="<?= $link ?>" class="footer-content--link">
      <div class="footer-content--content">
        <h2 class="head-2"><?= $line_one ?></h2>
        <h2 class="head-2 light"><?= $line_two ?></h2>
      </div>
    </a>
  </div>
  <div class="container footer-info">
    <div class="footer-info--content">
      <div class="footer-info--content--info">
        <p>
          <span class="company"><?= get_bloginfo('name') ?></span>
          <span class="company-desc"><?= get_bloginfo('description') ?></span>
        </p>
      </div>
      <div class="footer-info--content--links">
        <p><?php
          if($facebook_link) { ?><a href="<?= $facebook_link ?>" target="_blank"><i class="fa fa-facebook"></i></a><?php }
          if($twitter_link) { ?><a href="<?= $twitter_link ?>" target="_blank"><i class="fa fa-twitter"></i></a><?php }
          if($instagram_link) { ?><a href="<?= $instagram_link ?>" target="_blank"><i class="fa fa-instagram"></i></a><?php }
          if($linkedin_link) { ?><a href="<?= $linkedin_link ?>" target="_blank"><i class="fa fa-linkedin"></i></a><?php }
        ?></p>
      </div>
    </div>
  </div>
  <div id="primary-break" aria-hidden="true"></div>
</footer>
