<?php

class Ad extends AppModel
{

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


	public function get($type = 1, $count = 1, $random = true, $fallback = false, $include = [])
	{

		$order = ($random) ? 'RAND()' : 'Ad.weight';

		$conditions = [];
		$conditions['Ad.enabled'] = 1;

		if (is_numeric($type)) {
			$conditions['Ad.ad_type_id'] = $type;
		} else if ($type) {
			$conditions['AdType.title LIKE'] = $type . ' %';
		}


		$conditions['AND'] = [];
		$conditions['AND'][] = ['OR' => [['Ad.start_date <=' => date('Y-m-d')], ['Ad.start_date' => '']]];
		$conditions['AND'][] = ['OR' => [['Ad.end_date >=' => date('Y-m-d')], ['Ad.end_date' => '']]];

		$ads = [];

		if (!empty($include)) {
			foreach ($this->find('all', ['conditions' =>  ['Ad.id' => $include] + $conditions, 'order' => $order]) as $ad) {
				$ads[] = $ad;
				$count--;
			}
		}

		// There's nothing for include... 
		if ($count > 0) {
			if (!empty($include))
				$conditions['Ad.id NOT IN'] = $include;
			$ads = array_merge($ads, $this->find('all', ['limit' => $count, 'conditions' => $conditions, 'order' => $order]));
		}

		// foreach ($ads as $ad) {		
		//	ClassRegistry::init('Analytic')->hit('Ad', 'Impression', $ad['Ad']['title']);
		// }

		if (empty($ads) && $fallback) {
			$conditions = [];

			if (is_numeric($type)) {
				$conditions['AdType.id'] = $type;
			} else if ($type) {
				$conditions['AdType.title LIKE'] = $type . '%';
			}

			$type = $this->AdType->find('first', ['conditions' => $conditions]);

			if (empty($type)) return;
			$ads = [];

			$ad = [
				'title' => $type['AdType']['title'],
				'id' => 0,
				'image' => 'https://placehold.jp/28/B6BFE6/ffffff/' . $type['AdType']['width'] * 2 . 'x' . $type['AdType']['height'] * 2 . '.png?text=' . $type['AdType']['title'],
				'imagemobile' => '',
				'html' => '',
				'destination_url' => '',
				'imagemobile' => '',
				'admin_only' => '',
			];

			for ($i = 0; $i < $count; $i++) {
				$ads[] = [
					'AdType' => $type['AdType'],
					'Ad' => $ad,
				];
			}
		}

		return $ads;
	}



	public function addTracking($url, $campaign = [])
	{

		// Already got one? Fine... 
		if (strpos($url, 'utm_')) return $url;

		if (is_string($campaign)) {
			$campaign = ['campaign' => $campaign, 'source' => Configure::read('Site.Title')];
		}

		if (empty($campaign['source'])) {
			$campaign['source'] = Configure::read('Site.Title');
		}
		if (empty($campaign['medium'])) {
			$campaign['medium'] = 'mrec';
		}
		if (empty($campaign['campaign'])) {
			$campaign['campaign'] = date('F Y') . ' web banner';
		}

		if (strpos($url, '?') !== false) {
			$url .= '&';
		} else {
			$url .= '?';
		}

		foreach ($campaign as $key => $val) {
			$campaign[$key] = strtolower(Inflector::slug($val, '+'));
		}

		$url .= "utm_source={$campaign['source']}&utm_medium={$campaign['medium']}&utm_campaign={$campaign['campaign']}";

		return $url;
	}
}
