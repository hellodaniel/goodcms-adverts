<?php 


	if (!isset($count)) $count = 1; 
	if (!isset($align)) $align = 'left'; 
	
	foreach (ClassRegistry::init('Ad')->get($type, $count) as $ad) { 
	
	?>
	
	
		<a class="ad adtype<?=$ad['AdType']['id']?> pull-<?=$align?>" href="/ads/click/<?=$ad['Ad']['id']?>" target="_blank" onclick="analytics.trackLink(this, 'Ad Click', { ad : '<?=$ad['Ad']['title']?>', url: '<?=$ad['Ad']['destination_url']?>' });">
			<?=$this->Html->image($ad['Ad']['image'], array('class' => 'img-responsive center-block', 'alt' => $ad['Ad']['title']))?>
		</a>
	
	
	<?php 	
	
	}

?>