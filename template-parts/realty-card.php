<div class="card h-100">
  <?php the_post_thumbnail('large') ?>  

  <div class="card-body d-flex flex-column">
    <h5 class="card-title">
      <?= get_realty_title() ?>
    </h5>

    <h4 class="my-3"><?= get_price() ?></h4>
    
    <div class="card-text mb-4">
      <?php get_template_part('template-parts/realty-params') ?>
    </div>
    
    <a href="<?php the_permalink() ?>" class="btn btn-primary mt-auto">Подробнее</a>
  </div>
</div>