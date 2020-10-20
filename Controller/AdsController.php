<?php

App::uses('AppController', 'Controller');


class AdsController extends AppController {

	public $name = 'Ads';
	
	
	public $uses = ['Adverts.Ad', 'Analytic']; 
	

	public function click($id) {

		// Later do this in the MODEL
		$ad = $this->Ad->findById($id);

		if (!empty($ad)) {
			
			$this->Analytic->hit('Ad', 'Click', $ad['Ad']['id']);
			$ad['Ad']['destination_url'] = $this->Ad->addTracking($ad['Ad']['destination_url']); 
			return $this->redirect($ad['Ad']['destination_url']);

		} else {
			throw new NotFoundException('This advertisment is no longer running');
		}

	}


	public function specs() {

		$specs = $this->Ad->AdType->find('all');
		$this->data = $specs;

	}


	public function admin_index() {
		
		
		if (empty($this->Ad->AdType->find('list'))) {
		
			return $this->redirect(array('controller' => 'ad_types', 'action' => 'index', 'plugin' => 'adverts'));
			
		} 
		
		$this->data = $this->Ad->find('all');
		
		foreach ($this->request->data as &$row) {
			
			// Get the clicks from the analytics engine	
	 		$row['Ad']['impressions'] += $this->Analytic->hits('Ad', 'Impression', $row['Ad']['title']);  
			$row['Ad']['clicks'] += $this->Analytic->hits('Ad', 'Click', $row['Ad']['title']);  
			
			// This needs to be sorted @todo: fixme! 
			$row['Ad']['impressions'] += $this->Analytic->hits('Ad', 'Impression', $row['Ad']['id']);  
			$row['Ad']['clicks'] += $this->Analytic->hits('Ad', 'Click', $row['Ad']['id']);  

		}
		
		$this->layout = 'admin';

	}


	public function admin_add() {

		$this->admin_edit();

	}

	public function admin_edit($id = null, $layout = null) {
		
		// Add UTM links automatically if omitted
		if (!empty($this->request->data['Ad']['destination_url'])) {
			$this->request->data['Ad']['destination_url'] = $this->Ad->addTracking($this->data['Ad']['destination_url']); 
		}
		
		$this->set('adTypes', $this->Ad->AdType->find('list'));
		parent::admin_edit($id);

	}

	public function admin_delete($id = null) {

		parent::admin_delete($id);

	}
	
	
	
	
	
	
	
	

}
