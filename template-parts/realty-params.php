<?php
  $params = [
    'area' => 'Площадь',
    'living-area' => 'Жилая площадь',
    'floor' => 'Этаж',
    'loor-count' => 'Этажность дома',
  ];
?>

<?php foreach($params as $key => $label):
  if(!$value = get_field($key)) continue;

  $postText = in_array($key, ['area', 'living-area']) ? ' м²' : '';
?>
  <p>
    <b><?= $label ?>:</b>
    <span><?= $value.$postText ?></span>
  </p>
<?php endforeach; ?>