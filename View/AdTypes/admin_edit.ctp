<?php

$this->extend('/Common/admin_edit');
echo $this->Form->input('AdType.id');
echo $this->GoodForm->input('AdType.title', ['class' => 'input-lg']);

?>

<div class="row">
   <div class="col-md-3">
      <?= $this->GoodForm->input('AdType.width', ['append' => 'px', 'default' => 0]) ?>
   </div>
   <div class="col-md-3">
      <?= $this->GoodForm->input('AdType.height', ['append' => 'px', 'default' => 0]) ?>
   </div>
   <div class="col-md-3">
      <?= $this->GoodForm->input('AdType.mobile_width', ['append' => 'px', 'default' => 0]) ?>
   </div>
   <div class="col-md-3">
      <?= $this->GoodForm->input('AdType.mobile_height', ['append' => 'px', 'default' => 0]) ?>
   </div>
</div>

<?= $this->GoodForm->input('AdType.notes') ?>


<?php

$samples = [];
if (@$this->data['AdType']['width']) {
   $samples['Desktop'] = [$this->data['AdType']['width'], $this->data['AdType']['height']];
   $samples['Desktop@2x'] = [$this->data['AdType']['width'] * 2, $this->data['AdType']['height'] * 2];
}
if (@$this->data['AdType']['mobile_width']) {
   $samples['Mobile'] = [$this->data['AdType']['mobile_height'], $this->data['AdType']['mobile_width']];
   $samples['Mobile@2x'] = [$this->data['AdType']['mobile_height'] * 2, $this->data['AdType']['mobile_width'] * 2];
}

?>

<?php if (!empty($samples)) { ?>
   <hr />
   <h3>Samples</h3>
   <p>Images can optionally be supplied at double resolution for retina displays (@2x). If you don't supply a mobile size, the desktop size will be used.</p>
   <?php foreach ($samples as $title => $size) { ?>
      <img src="https://placehold.jp/28/3880B4/ffffff/<?= $size[0] ?>x<?= $size[1] ?>.png?text=<?= $title ?> <?= $size[0] ?>x<?= $size[1] ?>" class="img-responsize img-fluid m-b-15" width="<?= strstr($title, '@2x') ? $size[0] / 2 : $size[0] ?>" width="<?= strstr($title, '@2x') ? $size[1] / 2 : $size[1] ?>" /><br />

   <?php } ?>
   <hr />

<?php } ?>