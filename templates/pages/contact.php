<?php
  $directions_url = get_field('directions_link');
  $company = get_bloginfo('name');
  $street = get_field('company_address', 'options');
  $suite = get_field('company_suite_number', 'options');
  $city_state = get_field('company_city_state', 'options');
  $zip = get_field('company_zip_code', 'options');

  $address = $street . ' ' . $city_state . ' ' . $zip;

  $popup = htmlspecialchars('<span>hi</span>');
?>

<div class="contact-wrapper">
  <div id="map" class="contact-map google-map" data-address="<?= $address ?>">

  </div>
  <div id="map-content" class="contact-map--content">
    <p>
      <span class="blue"><?= $company ?></span>
      <span><?= $street ?></span>
      <span><?= $suite ?></span>
      <span><?= $city_state ?></span>
      <span><?= $zip ?></span><br>
    </p>
    <p>
      <a href="<?= $directions_url ?>" class="read-more small white" target="blank">Get Directions</a>
    </p>
  </div>

  <!-- IE HOTFIX -->
  <div class="contact-map ie-contact-map">
    <div class="contact-map--content">
      <p>
        <span class="blue"><?= $company ?></span>
        <span><?= $street ?></span>
        <span><?= $suite ?></span>
        <span><?= $city_state ?></span>
        <span><?= $zip ?></span><br>
      </p>
      <p>
        <a href="<?= $directions_url ?>" class="read-more small white" target="blank">Get Directions</a>
      </p>
    </div>
  </div>
  <!-- /IE HOTFIX -->

  <div class="contact-info">
    <div class="contact-info--content">
      <?= get_field('content_text') ?>
    </div>
  </div>
</div>