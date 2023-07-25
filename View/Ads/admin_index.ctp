<?php

$this->extend('/Common/admin_index');

$this->set('options', [
	'create' => true,
	'export' => true,
	'header-actions' => [['action' => ['controller' => 'ad_types', 'plugin' => 'adverts', 'action' => 'index'], 'title' => 'Manage Ad Types']]

]);


?>
<?php $this->append('secondary-sidebar'); ?>

<p><strong>Impression:</strong> An ad <em>impression</em> occurs when an ad is displayed to a user. The "impression" event is fired internally via javascript 400ms after the ad has been displayed on the page and is also sent to Google Analytics (if configured). Impressions should not be affected by bots or ad blockers.</p>

<p><strong>Hit:</strong> An ad is <em>hit</em> when it's image content is loaded by a browser. This method does not use javascript but may be subverted by browser cache or ad blockers and may also be triggered by bots.</p>

<div class="alert alert-warning">n.b.: Due to the changes in impression algorithms we reset impresssions at <?= $this->App->shortDate(filemtime('../Plugin/Adverts/sql/02 Reset the numbers.sql')) ?>. If you want to see historic impressions prior to that date please <a href="?historic=true">click here.</a></div>

<?php $this->end(); ?>

<table class="table table-hover index_table">
	<thead>
		<tr>

			<th class="filterable">Status</th>
			<th>Dates</th>
			<th>Biller</th>
			<th class="filterable">Type</th>
			<th>Hits</th>
			<th>Impressions</th>
			<th>Clicks</th>
			<th></th>

		</tr>
	</thead>
	<tbody>
		<?php foreach ($this->data as $row) { ?>
			<tr data-id="<?= $row['Ad']['id'] ?>">
				<td><?php if (!$row['Ad']['enabled']) { ?>
						<span class="label label-danger">Off</span>
					<?php } else if ((!$row['Ad']['start_date'] || strtotime($row['Ad']['start_date']) < time()) && (!$row['Ad']['end_date'] || strtotime($row['Ad']['end_date']) > time())) { ?>
						<span class="label label-success">Active</span>
					<?php } else if ($row['Ad']['start_date'] && strtotime($row['Ad']['start_date']) > time()) { ?>
						<span class="label label-info">Scheduled</span>
					<?php } else { ?>
						<span class="label label-warning">Inactive</span>
					<?php } ?>
				</td>
				<td><?php
					if ($row['Ad']['start_date']) echo '<span class="hidden">' . $row['Ad']['start_date'] . '</span>' . $this->App->shortDate($row['Ad']['start_date']);
					if ($row['Ad']['end_date']) echo '-' . $this->App->shortDate($row['Ad']['end_date']);
					?>
				</td>
				<td>
					<strong><?php echo $this->Html->link($row['Ad']['title'], array('action' => 'edit', $row['Ad']['id']), array('escape' => false)); ?></strong><br />
					<?= strip_tags($row['Ad']['destination_url']) ?>
				</td>
				<td>
					<?= $row['AdType']['title'] ?>
				</td>
				<td><?= number_format($row['Ad']['hits']) ?> </td>
				<td><?= number_format($row['Ad']['impressions']) ?> </td>
				<td><?= number_format($row['Ad']['clicks']) ?> </td>
				<td class="actions">
					<div class="btn-group">
						<?= $this->element('admin/index-actions', array('id' => $row['Ad']['id'])) ?>
					</div>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>