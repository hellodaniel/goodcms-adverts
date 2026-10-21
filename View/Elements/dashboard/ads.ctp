<?php



$conditions = [];
$conditions['Ad.enabled'] = 1;

$conditions['AND'] = [];
$conditions['AND'][] = ['OR' => [['Ad.start_date <=' => date('Y-m-d')], ['Ad.start_date' => '']]];
$conditions['AND'][] = ['OR' => [['Ad.end_date >=' => date('Y-m-d')], ['Ad.end_date' => '']]];


DebugTimer::start('loading_ads', 'Loading ads');
$ads = ClassRegistry::init('Adverts.Ad')->find('all', ['conditions' => $conditions]);
DebugTimer::stop('loading_ads');

$clicks = [];


DebugTimer::start('processing_ads', 'Processing ads');

foreach ($ads as $ad) {

	$hits = ClassRegistry::init('Analytic')->hits('Ad', 'Click', $ad['Ad']['id'], date('Y-m-d', time() - 7 * DAY));
	if ($hits) {
		$clicks[$ad['Ad']['title']] = $hits;
	}
}

DebugTimer::stop('processing_ads');


if (empty($clicks)) return;

arsort($clicks);



?>


<div class="tile">

	<h4 class="title">7 day top clicked ads</h4>
	<div id="ad-click-chart" class="etch-chart"><div data-etch-plot></div></div>

</div>

<?php $this->append('plugins'); ?>
<script>
	// Ranked list keeps long ad titles readable
	Etch.render(document.getElementById('ad-click-chart'), {
		type: 'bar-list',
		max: <?= max($clicks) ?>,
		values: <?= json_encode(array_map(fn($label, $value) => ['label' => (string)$label, 'value' => $value], array_keys($clicks), $clicks)) ?>
	});
</script>
<?php $this->end(); ?>