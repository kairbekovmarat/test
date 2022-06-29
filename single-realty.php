<?php get_header() ?>

<div class="container py-5">
  <h1><?= get_realty_title() ?></h1>

  <div class="mt-5 row">
    <div class="col-6">
      <?php
        $gallery = [];

        if($photos = get_field('photos')) {
          $gallery = array_map(function($element) {
            return $element['sizes']['large'];
          }, $photos);
        }

        if($mainImage = get_the_post_thumbnail_url(get_the_ID(), 'large')) {
          array_unshift($gallery, $mainImage);
        }
      ?>

      <?php if($gallery): ?>
      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php foreach($gallery as $index => $img): ?>
          <div class="carousel-item <?= !$index ? 'active' : '' ?>">
            <img src="<?= $img ?>" class="d-block w-100" alt="...">
          </div>
          <?php endforeach; ?>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <?php endif; ?>
    </div>
    
    <div class="col-6">
      <h2 class="mb-4">Цена: <?= get_price() ?></h2>
      <?php get_template_part('template-parts/realty-params') ?>

      <div class="mt-5">
        <?php the_content() ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer() ?>