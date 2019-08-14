<?php 



	$conditions = []; 
	$conditions['Ad.enabled'] = 1; 
	
	$conditions['AND'] = []; 
	$conditions['AND'][] = ['OR' => [['Ad.start_date <=' => date('Y-m-d')], ['Ad.start_date' => '']]]; 
	$conditions['AND'][] = ['OR' => [['Ad.end_date >=' => date('Y-m-d')], ['Ad.end_date' => '']]]; 
	
	$ads = ClassRegistry::init('Adverts.Ad')->find('all', ['conditions' => $conditions]); 
	$clicks = []; 
	
	foreach ($ads as $ad) {
		
		$hits = ClassRegistry::init('Analytic')->hits('Ad', 'Click', $ad['Ad']['id'], date('Y-m-d', time()-7*DAY));
		if ($hits) {
			$clicks[$ad['Ad']['title']] = $hits;  
		}
		
	}
	
	arsort($clicks);
	
	

?>
	
	
				<div class="tile">
							
					<h4 class="title">7 day top clicked ads</h4>
					<div id="ad-click-chart" style="height: 250px"></div>
						
				</div>
	
	<?php $this->append('plugins'); ?>
	<script>
		
		var data = {
			labels: <?=json_encode(array_keys($clicks)) ?>,
			data: <?=json_encode(array_values($clicks)) ?>
		};
		var ads = new Grafs.Column('#ad-click-chart', data);
		
	</script>
	<?php $this->end(); ?>