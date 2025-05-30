<?php

$this->extend('/Common/admin_index');

$this->set('options', [
	'create' => true,
	'export' => true,
	'header-actions' => [['action' => ['controller' => 'ad_types', 'plugin' => 'adverts', 'action' => 'index'], 'title' => 'Manage Ad Types']]

]);


?>


<p>
	<strong>Impression:</strong> An ad <em>impression</em> occurs when an ad is displayed to a user. The "impression" event is fired internally via javascript 400ms after the ad has been displayed on the page and is also sent to Google Analytics (if configured). Impressions should not be affected by bots or ad blockers.
	<strong>Hit:</strong> An ad is <em>hit</em> when it's image content is loaded by a browser. This method does not use javascript but may be subverted by browser cache or ad blockers and may also be triggered by bots.
</p>

<table class="table table-hover index_table">
	<thead>
		<tr>
			<th class="filterable">Status</th>
			<th>Dates</th>
			<th>Created</th>
			<th>Biller</th>
			<th class="filterable">Type</th>
			<th class="filterable">Format</th>
			<th>Hits</th>
			<th>Impressions</th>
			<th>Clicks</th>
			<th>Restrictions</th>
			<th class="no-export"></th>
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
				<td><?php if ($row['Ad']['created'] != '0000-00-00 00:00:00') echo '<span class="hidden">' . $row['Ad']['created'] . '</span>' . $this->App->timeAgo($row['Ad']['created']) ?></td>
				<td>
					<strong><?php echo $this->Html->link($row['Ad']['title'], array('action' => 'edit', $row['Ad']['id']), array('escape' => false)); ?></strong><br />
					<?= $row['Ad']['biller'] ?>
				</td>
				<td>
					<?= $row['AdType']['title'] ?>
				</td>
				<td>
					<?= $row['Ad']['type'] ?>
				</td>
				<td><?= $row['Ad']['hits'] ?> </td>
				<td><?= $row['Ad']['impressions'] ?> </td>
				<td><?= $row['Ad']['clicks'] ?> </td>
				<td><?php

					if ($row['Ad']['whitelist_urls']) echo '<label class="badge badge-default">Whitelist</label>';
					if ($row['Ad']['blacklist_urls']) echo '<label class="badge badge-dark">Blacklist</label>';

					?></td>
				<td class="actions">
					<div class="btn-group">
						<?= $this->element('admin/index-actions', array('id' => $row['Ad']['id'])) ?>
					</div>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>