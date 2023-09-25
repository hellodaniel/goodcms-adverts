<?php


$AdModel = ClassRegistry::init('Adverts.Ad');

if (!isset($count)) $count = 1;

// Fallback to a placeholder ad? (default: false)
if (!isset($fallback)) $fallback = Configure::read('debug');

$cache_key = 'ad-' . $type . '-' . $count . Inflector::slug($this->here, '');

$ads = Cache::read($cache_key, 'short');
$ads = false;
// disused for the moment
if ($ads === false) {
	$ads = $AdModel->get($type, $count, true, $fallback);
	Cache::write($cache_key, $ads, 'short');
}


if (empty($ads)) return;


foreach ($ads as $i => $ad) {

	if ($i > 0 && !empty($between)) echo $between;

	if (!empty($before)) echo $before;

	// Skip admin-only ads
	if ($ad['Ad']['admin_only'] && !$this->User->id()) continue;

	$ids[$ad['Ad']['id']] = $ad['Ad']['title'];

	// Track the ad internally AND via Google Analytics
	// Internally we use the ID though
	$tracking = "track(['Ad', 'Click', '{$ad['Ad']['id']}', 1], 2); track(['Ad', 'Click', '" . addslashes($ad['Ad']['title']) . "'], 0); return true;";

	$attribs = 'rel="sponsored" ' .
		'href="' . $ad['Ad']['destination_url'] . '" ' .
		'onclick="' . $tracking . '" ' .
		'target="_blank"';


	$classes = 'hidden-print ad adtype-' . $ad['AdType']['id'] . ' adtype-' . $this->App->slug($ad['AdType']['title']);

	if (!empty($class)) $classes .= ' ' . $class;

	$image_attribs = [
		'class' => 'img-responsive center-block',
		'alt' => $ad['Ad']['title'],
		'style' => 'max-width: 100%;',
		'loading' => 'lazy'
	];


	$find = '/<img(.*?)src="(.*?)((?i)\.gif|\.png|\.jpg|\.jpeg)"/';
	$replace = '<img$1src="/adverts/ads/display/' . $ad['Ad']['id'] . '$3?src=$2$3&time=' . time() . '"';



	if ($ad['Ad']['imagemobile']) {
		$mobile_attribs = $image_attribs;
	}

	if ($ad['Ad']['html']) { ?>

		<div class="<?= $classes ?> hidden-sm hidden-xs">
			<?= $ad['Ad']['html'] ?>
		</div>

		<?php if ($ad['Ad']['imagemobile']) { ?>
			<a class="<?= $classes ?> hidden-md hidden-lg" <?= $attribs ?>>
				<?= preg_replace($find, $replace, $this->App->image($ad['Ad']['imagemobile'], $mobile_attribs)) ?>
			</a>
		<?php } ?>

	<?php } else if ($ad['Ad']['imagemobile']) { ?>

		<a class="<?= $classes ?> hidden-sm hidden-xs" <?= $attribs ?>>
			<?= preg_replace($find, $replace, $this->App->image($ad['Ad']['image'], $image_attribs)) ?>
		</a>

		<a class="<?= $classes ?> hidden-md hidden-lg" <?= $attribs ?>>
			<?= preg_replace($find, $replace, $this->App->image($ad['Ad']['imagemobile'], $mobile_attribs)) ?>
		</a>

	<?php } else { ?>

		<a class="<?= $classes ?>" <?= $attribs ?>>
			<?= preg_replace($find, $replace, $this->App->image($ad['Ad']['image'], $image_attribs)) ?>
		</a>

	<?php } ?>
	<script>
		setTimeout(function() {
			jQuery.ajax('/adverts/ads/impression/<?= $ad['Ad']['id'] ?>');
			track(['Ad', 'Impression', '<?= addslashes($ad['Ad']['title']) ?>'], 0);
		}, 400);
	</script>
<?php


	if (!empty($after)) echo $after;
}


?>