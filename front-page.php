<?php get_header() ?>
<?php
  global $post;

  $cities = get_posts([
    'post_type' => 'city',
    'numberposts' => -1,
  ]);
  
  $realty = get_posts([
    'post_type' => 'realty',
    'numberposts' => 6
  ]);
?>

<section class="py-5">
  <div class="container">
    <h2 class="mb-4">Города</h2>
    
    <div class="row mb-n4">
      <?php foreach($cities as $post):
        setup_postdata($post);
      ?>
        <div class="col-4 mb-4">
          <div class="card h-100">
            <?php the_post_thumbnail('large') ?>  

            <div class="card-body d-flex flex-column">
              <h5 class="card-title">
                <?php the_title() ?>
              </h5>
              
              <div class="card-text mb-4">
                <?php the_content() ?>
              </div>
              
              <a href="<?php the_permalink() ?>" class="btn btn-primary mt-auto">Смотреть недвижимость</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<section>
  <div class="container">
    <h2 class="mb-4">Недвижимость</h2>

    <div class="row mb-n4">
      <?php foreach($realty as $post):
        setup_postdata($post);
      ?>
        <div class="col-4 mb-4">
          <?php get_template_part('template-parts/realty-card') ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<section class="py-5">
  <div class="container">
    <h2 class="mb-4">Добавить недвижимость</h2>
	  
	<?php
		$terms = get_terms( [
			'taxonomy' => 'realty_type',
			'hide_empty' => false,
		]);
	  
	  	$cities = get_posts([
			'post_type' => 'city',
			'numberposts' => -1,
		]);
	?>

    <form id="realty-form" action="<?php echo admin_url( "admin-ajax.php" ) ?>" class="w-50">
	  <input type="hidden" name="action" value="create_realty">
	  <div class="mb-3">
        <select class="form-select" name="city" required>
		  <option value="" selected>Город</option>
		  <?php foreach($cities as $city): ?>
		    <option value="<?= $city->ID ?>"><?= $city->post_title ?></option>
		  <?php endforeach; ?>
		</select>
      </div>
	  <div class="mb-3">
        <select class="form-select" name="realty_type" required>
		  <option value="" selected>Тип недвижимости</option>
		  <?php foreach($terms as $term): ?>
		    <option value="<?= $term->term_id ?>"><?= $term->name ?></option>
		  <?php endforeach; ?>
		</select>
      </div>
	  <div class="mb-3">
        <input type="text" name="address" class="form-control" placeholder="Адрес" required>
      </div>
      <div class="mb-3">
        <input type="num" name="price" class="form-control" placeholder="Стоимость" required>
      </div>
	  <div class="mb-3">
        <input type="num" name="area" class="form-control" placeholder="Площадь" required>
      </div>
	  <div class="mb-3">
        <input type="num" name="living-area" class="form-control" placeholder="Жилая площадь">
      </div>
	  <div class="mb-3">
        <input type="num" name="floor" class="form-control" placeholder="Этаж">
      </div>
	  <div class="mb-3">
        <input type="num" name="floor-count" class="form-control" placeholder="Этажность дома">
      </div>
      <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
  </div>
</section>


<script>
	const form = document.getElementById('realty-form');
	form.addEventListener('submit', async (event) => {
		event.preventDefault();
		
		const formData = new FormData(form);
		const url = form.getAttribute('action');
		
		await fetch(url, {
			method: 'POST',
      		body: formData
		}).then(() => {
			alert('Недвижимость добавлена');
			form.reset();
		});
	});
</script>

<?php get_footer() ?>