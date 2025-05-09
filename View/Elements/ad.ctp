<?php


$AdModel = ClassRegistry::init('Adverts.Ad');

// You can pass in a list of ads that should be included.. 
if (!isset($url))
	$url = $this->here;

if (!isset($count)) $count = 1;

// Fallback to a placeholder ad? (default: false)
if (!isset($fallback)) $fallback = Configure::read('debug');

$cache_key = 'ad-' . Inflector::slug($type) . '-' . $count . 'x' . Inflector::slug($url, '');

$ads = Cache::read($cache_key);
$ads = false;
// disused for the moment
if ($ads === false) {
	$ads = $AdModel->get($type, $count, true, $fallback, $url);
	Cache::write($cache_key, $ads);
}


if (empty($ads)) return;


foreach ($ads as $i => $ad) {

	if ($i > 0 && !empty($between)) echo $between;

	if (!empty($before)) echo $before;

	// Skip admin-only ads
	if ($ad['Ad']['admin_only'] && !$this->User->id()) continue;

	$ids[$ad['Ad']['id']] = $ad['Ad']['title'];

	$classes = 'hidden-print ad adtype-' . $ad['AdType']['id'] . ' adtype-' . $this->App->slug($ad['AdType']['title']);
	if (!empty($class)) $classes .= ' ' . $class;

	if (empty($ad['Ad']['type']) || $ad['Ad']['type'] == 'video' || $ad['Ad']['type'] == 'image') {

		// Track the ad internally AND via Google Analytics
		// Internally we use the ID though
		$tracking = "track(['Ad', 'Click', '{$ad['Ad']['id']}', 1], 2); track(['Ad', 'Click', '" . addslashes($ad['Ad']['title']) . "'], 0); return true;";

		// Applied to the link for video and image ads
		$attribs = 'rel="sponsored" ' .
			'href="' . $ad['Ad']['destination_url'] . '" ' .
			'onclick="' . $tracking . '" ' .
			'target="_blank" ' .
			'title="' . addslashes($ad['Ad']['title']) . '"';

		$inlinestyle = 'display: block; margin-left: auto; margin-right: auto; max-width: 100%;';

		$image_attribs = [
			'class' => 'img-responsive img-fluid',
			'alt' => $ad['Ad']['title'],
			'loading' => 'lazy',
			'style' => $inlinestyle,
		];

		$find = '/<img(.*?)src="(.*?)((?i)\.gif|\.png|\.jpg|\.jpeg)"/';

		// Why do we put the time on here? Well it's jus tto trigger a track, really... 
		// I don't love the idea... 
		$replace = '<img$1src="/adverts/ads/display/' . $ad['Ad']['id'] . '$3?src=$2$3&time=' . time() . '"';

		if ($ad['Ad']['imagemobile']) {
			$mobile_attribs = $image_attribs;
		}



		if (!empty($ad['Ad']['type']) && $ad['Ad']['type'] == 'video') { ?>

			<?php if ($ad['Ad']['video'] && $ad['Ad']['videomobile']) { ?>

				<a class="<?= $classes ?> hidden-sm hidden-xs d-none d-md-block" <?= $attribs ?>>
					<video autoplay muted loop playsinline style="<?= $inlinestyle ?>">
						<source src="<?= $ad['Ad']['video'] ?>" type="video/<?= strtolower(pathinfo($ad['Ad']['video'], PATHINFO_EXTENSION)) ?>">
					</video>
				</a>

				<a class="<?= $classes ?> hidden-md hidden-lg d-md-none" <?= $attribs ?>>
					<video autoplay muted loop playsinline style="<?= $inlinestyle ?>">
						<source src="<?= $ad['Ad']['videomobile'] ?>" type="video/<?= strtolower(pathinfo($ad['Ad']['videomobile'], PATHINFO_EXTENSION)) ?>">
					</video>
				</a>

			<?php } else { ?>

				<a class="<?= $classes ?>" <?= $attribs ?>>
					<video autoplay muted loop playsinline style="<?= $inlinestyle ?>">
						<source src="<?= $ad['Ad']['video'] ?: $ad['Ad']['videomobile'] ?>" type="video/<?= strtolower(pathinfo(($ad['Ad']['video'] ?: $ad['Ad']['videomobile']), PATHINFO_EXTENSION)) ?>">
					</video>
				</a>

			<?php } ?>

		<?php } ?>


		<?php if (empty($ad['Ad']['type']) || $ad['Ad']['type'] == 'image') {

			if ($ad['Ad']['imagemobile'] && $ad['Ad']['image']) { ?>

				<a class="<?= $classes ?> hidden-sm hidden-xs d-none d-md-block" <?= $attribs ?>>
					<?= preg_replace($find, $replace, $this->App->image($ad['Ad']['image'], $image_attribs)) ?>
				</a>

				<a class="<?= $classes ?> hidden-md hidden-lg d-md-none" <?= $attribs ?>>
					<?= preg_replace($find, $replace, $this->App->image($ad['Ad']['imagemobile'], $mobile_attribs)) ?>
				</a>

			<?php } else { ?>

				<a class="<?= $classes ?>" <?= $attribs ?>>
					<?= preg_replace($find, $replace, $this->App->image($ad['Ad']['image'] ?: $ad['Ad']['imagemobile'], $image_attribs)) ?>
				</a>

		<?php }
		} ?>

	<?php } else if ($ad['Ad']['type'] == 'html') { ?>

		<div class="<?= $classes ?>">
			<?= $ad['Ad']['html'] ?>
		</div>

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