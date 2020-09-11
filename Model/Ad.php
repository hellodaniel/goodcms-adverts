<?php

class Ad extends AppModel {

		public $name = 'Ad';

		public $belongsTo = ['Adverts.AdType'];

		public $actsAs = [
			'Uploader.Attachment' => [
					'image' => [
						'uploadDir' => 'files/uploads/ads/',
						'finalPath' => '/files/uploads/ads/'
					],
					'imagemobile' => [
						'uploadDir' => 'files/uploads/ads/',
						'finalPath' => '/files/uploads/ads/'
					]
				]
			];


		public function get($type = 1, $count = 1, $random = true) {

			$order = ($random) ? 'RAND()' : 'Ad.weight';
			
			$conditions = []; 
			$conditions['Ad.enabled'] = 1; 
			
			if (is_numeric($type)) {
				$conditions['Ad.ad_type_id'] = $type; 
			} else if ($type) {
				$conditions['AdType.title LIKE'] = $type . '%'; 
			}
			
			$conditions['AND'] = []; 
			$conditions['AND'][] = ['OR' => [['Ad.start_date <=' => date('Y-m-d')], ['Ad.start_date' => '']]]; 
			$conditions['AND'][] = ['OR' => [['Ad.end_date >=' => date('Y-m-d')], ['Ad.end_date' => '']]]; 
			
			$ads = $this->find('all', ['limit' => $count, 'conditions' => $conditions, 'order' => $order]);

			foreach ($ads as $ad) {		
				ClassRegistry::init('Analytic')->hit('Ad', 'Impression', $ad['Ad']['title']);
			}

			return $ads;

		}
		
		
		
		public function addTracking($url, $campaign = '') {
			
				// Already got one? Fine... 
				if (strpos($url, 'utm_')) return $url; 
				
				if (!@$options['source']) {
					$options['source'] = Configure::read('Site.Title');
				}
				if (!@$options['medium']) {
					$options['medium'] = 'mrec';
				}
				if (!@$options['campaign']) {
					$options['campaign'] = date('F') . ' web banner';
				}

				if(strpos($url, '?') !== false) {
					$url .= '&';
				} else {
					$url .= '?';
				}

				foreach ($options as $key => $val) {
					$options[$key] = strtolower(Inflector::slug($val, '+'));
				}

				$url .= "utm_source={$options['source']}&utm_medium={$options['medium']}&utm_campaign={$options['campaign']}";

				return $url; 
			
		}
		
		
		

}
