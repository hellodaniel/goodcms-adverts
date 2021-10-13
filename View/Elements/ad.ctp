<?php 


	if (!isset($count)) $count = 1; 
	
	$cache_key = 'ad-'.$type.'-'.$count; 
	
	$ads = Cache::read($cache_key, 'short'); 
	
	// disused for the moment
	if ($ads === false) {
		$ads = ClassRegistry::init('Adverts.Ad')->get($type, $count); 
		Cache::write($cache_key, $ads, 'short'); 
	}
	
	
	if (empty($ads)) return; 

	foreach ($ads as $ad) { 
		
		// Skip admin-only ads
		if ($ad['Ad']['admin_only'] && !$this->User->id()) continue; 
		
		
		$tracking = "track(['Ad', 'Click', '{$ad['Ad']['id']}', 1], 2); track(['Ad', 'Click', '".h($ad['Ad']['title'])."'], 0); return true;"; 
		
		$attribs = 'rel="sponsored" ' . 
					   'style="display: block; clear: both;" ' . 
					   'href="'.$ad['Ad']['destination_url'].'" ' . 
					   'onclick="'.$tracking.'" ' . 
					   'target="_blank"';
		
		
		$classes = 'hidden-print ad adtype-' . $ad['AdType']['id'] . ' adtype-' . $this->App->slug($ad['AdType']['title']); 
		
		if (!empty($class)) $classes .= ' ' . $class; 
		
		$image_attribs = [
			'class' => 'img-responsive center-block', 
			'alt' => $ad['Ad']['title'], 
			'style' => 'max-width: 100%;', 
			'loading' => 'lazy'
		]; 
		
		
	
		
		if ($ad['Ad']['imagemobile']) {
			$mobile_attribs = $image_attribs; 
		} 
		
		
	?>
		
		<?php if ($ad['Ad']['html']) { ?>
			
			<div class="<?=$classes?> hidden-sm hidden-xs">
				<?=$ad['Ad']['html']?>
			</div>
			
			<?php if ($ad['Ad']['imagemobile']) { ?>
				<a class="<?=$classes?> hidden-md hidden-lg" <?= $attribs ?>>
					<?=$this->App->image($ad['Ad']['imagemobile'], $mobile_attribs)?>
				</a>
			<?php } ?>
			
		<?php } else if ($ad['Ad']['imagemobile']) { ?>
			
			<a class="<?=$classes?> hidden-sm hidden-xs" <?= $attribs ?>>
				<?=$this->App->image($ad['Ad']['image'], $image_attribs)?>
			</a>
		
			<a class="<?=$classes?> hidden-md hidden-lg" <?= $attribs ?>>
				<?=$this->App->image($ad['Ad']['imagemobile'], $mobile_attribs)?>
			</a>
		
		<?php } else { ?>
		
			<a class="<?=$classes?>" <?= $attribs ?>>
				<?=$this->App->image($ad['Ad']['image'], $image_attribs)?>
			</a>
	
		<?php } ?>
		<script>jQuery(document).ready(function() { track(['Ad', 'Impression', '<?=h($ad['Ad']['title'])?>'], 0); }); </script>
	<?php 	
	
	}

?>