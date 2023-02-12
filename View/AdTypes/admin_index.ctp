<?php

$this->extend('/Common/admin_index');

$this->set('options', [
    'create' => true,
    'sortable' => true,
    'header-actions' => [['action' => ['controller' => 'ads', 'plugin' => 'adverts', 'action' => 'index'], 'title' => 'Manage Ads']]
]);

?>

<table class="table table-hover index_table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Desktop</th>
            <th>Mobile</th>
            <th>Notes</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->data as $row) { ?>
            <tr data-id="<?= $row['AdType']['id'] ?>">
                <td>
                    <?= $row['AdType']['title'] ?>
                </td>
                <td>
                    <code><?= $row['AdType']['width'] ?>&times;<?= $row['AdType']['height'] ?></code>
                    <samp class="text-muted"><?= $row['AdType']['width'] * 2 ?>&times;<?= $row['AdType']['height'] * 2 ?>@2x</samp>
                </td>
                <td><?php if (!$row['AdType']['mobile_width']) { ?>
                        <span class="label label-default">Same as desktop</span>
                    <?php } else { ?>
                        <code><?= $row['AdType']['mobile_width'] ?>&times;<?= $row['AdType']['mobile_height'] ?></code>
                        <samp class="text-muted"><?= $row['AdType']['mobile_width'] * 2 ?>&times;<?= $row['AdType']['mobile_height'] * 2 ?>@2x</samp>
                    <?php } ?>
                </td>
                <td> <?= $row['AdType']['notes'] ?></td>
                <td class="actions">
                    <div class="btn-group">
                        <?= $this->element('admin/index-actions', array('id' => $row['AdType']['id'])) ?>
                    </div>
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>

<?php $this->append('primary-sidebar'); ?>
<p class="lead">Ad Types are used to group ads together.</p>
<p>For example, you might have one leaderboard ad on the homepage so you could create an ad group called "homepage", for example. If you don't want to use "types" then simply create one called "ad" and forget about it. </p>
<?php $this->end(); ?>