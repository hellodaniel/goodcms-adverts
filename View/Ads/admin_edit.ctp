<?php $this->extend('/Common/admin_edit'); ?>




<?php $this->append('primary-sidebar'); ?>



<?= $this->GoodForm->input('Ad.enabled', ['type' => 'checkbox']) ?>
<div data-visibility-control="#AdEnabled">
	<?= $this->GoodForm->input('Ad.admin_only', ['type' => 'checkbox', 'label' => 'Visible only to admins']) ?>
</div>


<?php
echo $this->GoodForm->input('Ad.biller');
echo $this->GoodForm->input('Ad.ad_type_id');
echo $this->GoodForm->input('Ad.background', array('default' => 'FFFFFF', 'label' => 'Background colour'));

?>

<?php $this->end(); ?>


<?php


echo $this->Form->input('Ad.id');

echo $this->GoodForm->input('Ad.title', ['class' => 'input-lg']);

echo $this->GoodForm->input('Ad.destination_url', ['hint' => 'Include http(s):// for all external links']);

echo $this->GoodForm->input('Ad.type', array('options' => array(
	'image' => 'Image',
	'video' => 'Video',
	'html' => 'HTML',
)));

?>

<div class="well">
	<div class="row" data-visibility-control="#AdType==image">
		<div class="col-md-6">

			<h4><?= $this->App->icon('computer') ?> Desktop version</h4>
			<?php
			if (!empty($this->data['Ad']['image'])) {
				$filesize  = round($this->App->filesize($this->data['Ad']['image']) / 1000000, 1);
				if ($filesize > 2) {
					echo '<div class="alert alert-' . ($filesize > 10 ? 'danger' : 'warning') . '">Image file size is ' . $filesize . 'mb - this is ' . ($filesize > 10 ? 'too' : 'quite') . ' large and may affect page load times.</div>';
				}
			}
			?>
			<?= $this->GoodForm->input('Ad.image', array('type' => 'image')) ?>

		</div>
		<div class="col-md-6">

			<h4><?= $this->App->icon('mobile') ?> Mobile version</h4>
			<?php
			if (!empty($this->data['Ad']['imagemobile'])) {
				$filesize  = round($this->App->filesize($this->data['Ad']['imagemobile']) / 1000000, 1);
				if ($filesize > 2) {
					echo '<div class="alert alert-' . ($filesize > 10 ? 'danger' : 'warning') . '">Image file size is ' . $filesize . 'mb - this is  ' . $filesize . 'mb - this is ' . ($filesize > 10 ? 'too' : 'quite') . ' large and may affect page load times.</div>';
				}
			}
			?>
			<?= $this->GoodForm->input('Ad.imagemobile', array('type' => 'image')) ?>
		</div>

	</div>
	<div data-visibility-control="#AdType==video">
		<div class="callout">
			Videos must be in MP4 or WEPM format.
		</div>

		<?php
		if (!empty($this->data['Ad']['video'])) {
			$filesize  = round($this->App->filesize($this->data['Ad']['video']) / 1000000, 1);
			if ($filesize > 2) {
				echo '<div class="alert alert-' . ($filesize > 10 ? 'danger' : 'warning') . '">Video file size is ' . $filesize . 'mb - this is ' . ($filesize > 10 ? 'too' : 'quite') . ' large and may affect page load times.</div>';
			}
		}
		?>
		<?= $this->GoodForm->input('Ad.video', array('type' => 'file')) ?>

	</div>

	<div data-visibility-control="#AdType==html">
		<div class="callout">
			HTML ads do not currently include any tracking or click-through functionality. They are displayed as-is and are not recommended for use with external advertisers.
		</div>
		<?= $this->GoodForm->input('Ad.html', ['type' => 'code']) ?>
	</div>
</div>

<div class="well">
	<h4>Restrictions</h4>
	<p>Add urls to whitelist or blacklist them</p>
	<div class="row">
		<div class="col-md-6">
			<?= $this->GoodForm->input('Ad.whitelist_urls', ['hint' => 'Whitelisted URLs', 'type' => 'code']) ?>

		</div>
		<div class="col-md-6">
			<?= $this->GoodForm->input('Ad.blacklist_urls', ['hint' => 'Blacklisted URLs', 'type' => 'code']) ?>

		</div>
	</div>
</div>


<?php $this->append('secondary-sidebar'); ?>

<?= $this->GoodForm->input('Ad.start_date', ['type' => 'date', 'label' => 'Display from', 'hint' => 'Blank for no start date']) ?>
<?= $this->GoodForm->input('Ad.end_date', ['type' => 'date', 'label' => 'Display until', 'hint' => 'Blank for no end date']) ?>

<?php $this->end(); ?>