<?php get_header() ?>

<div class="container py-5">
  <div class="px-4 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
      <?php the_post_thumbnail('large') ?>
      <h1 class="display-5 fw-bold mt-3">
        <?php the_title() ?>
      </h1>
      <div class="col-md-8 fs-4">
        <?php the_content() ?>
      </div>
    </div>
  </div>


  <?php
    $realty = new WP_Query([
      'connected_type' => 'realty_to_city',
      'connected_items' => get_queried_object(),
      'posts_per_page' => 10
    ]);
  ?>

  <?php if($realty->have_posts()): ?>
    <section>
      <div class="container">
        <h2 class="mb-4">Недвижимость</h2>

        <div class="row mb-n4">
          <?php while($realty->have_posts()) : $realty->the_post(); ?>
            <div class="col-4 mb-4">
              <?php get_template_part('template-parts/realty-card') ?>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
</div>

<?php get_footer() ?>