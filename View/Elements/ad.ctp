<div class="hidden-print"><?php 


	if (!isset($count)) $count = 1; 

	foreach (ClassRegistry::init('Adverts.Ad')->get($type, $count) as $ad) { 
		
		// Skip admin-only ads
		if ($ad['Ad']['admin_only'] && !$this->User->id()) continue; 
		
		
		$tracking = "track(['Ad', 'Click', '{$ad['Ad']['id']}', 1], 2); track(['Ad', 'Click', '".h($ad['Ad']['title'])."'], 0); return true;"; 
		
		$attribs = 'rel="nofollow" ' . 
					  'href="'.$ad['Ad']['destination_url'].'" target="_blank" onclick="'.$tracking.'"';
		
		
	?>
		
		<?php if ($ad['Ad']['html']) { ?>
			
			<div class="hidden-sm hidden-xs">
				<?=$ad['Ad']['html']?>
			</div>
			
			<?php if ($ad['Ad']['imagemobile']) { ?>
				<a class="ad adtype<?=$ad['AdType']['id']?> hidden-md hidden-lg"<?= $attribs ?>>
					<?=$this->Html->image($ad['Ad']['imagemobile'], array('class' => 'img-responsive center-block', 'alt' => $ad['Ad']['title']))?>
				</a>
			<?php } ?>
			
		<?php } else if ($ad['Ad']['imagemobile']) { ?>
	
			<a class="ad adtype<?=$ad['AdType']['id']?> hidden-sm hidden-xs"<?= $attribs ?>>
				<?=$this->Html->image($ad['Ad']['image'], array('class' => 'img-responsive center-block', 'alt' => $ad['Ad']['title']))?>
			</a>
		
			<a class="ad adtype<?=$ad['AdType']['id']?> hidden-md hidden-lg"<?= $attribs ?>>
				<?=$this->Html->image($ad['Ad']['imagemobile'], array('class' => 'img-responsive center-block', 'alt' => $ad['Ad']['title']))?>
			</a>
		
		<?php } else { ?>
		
			<a class="ad adtype<?=$ad['AdType']['id']?>"<?= $attribs ?>>
				<?=$this->Html->image($ad['Ad']['image'], array('class' => 'img-responsive center-block', 'alt' => $ad['Ad']['title']))?>
			</a>
	
		<?php } ?>

	<?php 	
	
	}

?></div>