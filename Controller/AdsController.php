<?php

App::uses('AppController', 'Controller');


class AdsController extends AppController
{

	public $name = 'Ads';


	public $uses = ['Adverts.Ad', 'Analytic'];

	public $components = ['Export'];



	public function display($id)
	{

		$this->autoRender = false;

		$src = isset($_GET['src']) ? $_GET['src'] : null;
		if (empty($src)) {
			throw new NotFoundException('Invalid source parameter');
		}

		$ext = pathinfo($id)['extension'];
		$id = str_replace('.' . $ext, '', $id);


		// Memory cache is going to be faster
		$content = Cache::read('ad-' . md5($src));

		// Load it from the file cache if it's not in memory
		// and push it back into memory
		if (!$content) {
			$content = Cache::read('ad-' . md5($src), 'long');
			if ($content) Cache::write('ad-' . md5($src), $content);
		}

		if (!$content) {
			// Validate that the file exists and is readable before processing
			if (!file_exists($src) || !is_readable($src)) {
				throw new NotFoundException('File not found or not readable');
			}

			$content = file_get_contents($src);
			if ($content === false) {
				throw new InternalErrorException('Failed to read file content');
			}

			// Only call mime_content_type if we have a valid file
			$mime = mime_content_type($src);
			Cache::write('ad-' . md5($src), $content);
			Cache::write('ad-' . md5($src), $content, 'long');
		}

		$mimes = [
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
		];

		if (!$ext) $ext = pathinfo($src)['extension'];

		// Push the content out THEN do the DB update
		$this->response->header('Content-type', $mimes[strtolower($ext)]);
		$this->response->header('Content-length',  strlen($content));

		$this->response->header('Connection', 'close');
		ignore_user_abort(true);

		$this->response->body($content);
		$this->response->type(['image' => $mimes[strtolower($ext)]]);
		$this->response->type('image');
		$this->response->compress($content);

		$this->response->send();

		exit();
	}


	public function click($id)
	{

		// Later do this in the MODEL
		$ad = $this->Ad->findById($id);

		if (!empty($ad)) {
			if (!$this->Analytic->isBot())
				$this->Analytic->hit('Ad', 'Click', $ad['Ad']['id']);
			$ad['Ad']['destination_url'] = $this->Ad->addTracking($ad['Ad']['destination_url']);
			return $this->redirect($ad['Ad']['destination_url']);
		} else {
			throw new NotFoundException('This advertisment is no longer running');
		}
	}

	public function impression($id)
	{
		// Don't track if this is a bot
		if ($this->Analytic->isBot())
			die('🤖');

		if (CakeSession::read('Auth.User.role') && in_array(CakeSession::read('Auth.User.role'), ['dev', 'admin']))
			die('👨‍💻');

		$this->Ad->impression($id);

		$this->autoRender = false;

		$this->response->header('Connection', 'close');
		ignore_user_abort(true);

		$body = "\x30\r\n\r\n";

		$this->response->header('Content-type', 'application/json');
		$this->response->header('Content-length', strlen($body));
		$this->response->body($body);
		$this->response->type('text');
		$this->response->send();

		exit();
	}


	public function specs()
	{

		$specs = $this->Ad->AdType->find('all');
		$this->data = $specs;
	}


	public function admin_index()
	{


		if (empty($this->Ad->AdType->find('list'))) {

			return $this->redirect(array('controller' => 'ad_types', 'action' => 'index', 'plugin' => 'adverts'));
		}

		$this->data = $this->Ad->find('all');


		// Get a list of all ads that have been inactive for over a year
		// and delete all their impressions from the analytics table
		$inactive = $this->Ad->find('all', [
			'conditions' => [
				'Ad.enabled' => 0,
				'Ad.modified <' => date('Y-m-d H:i:s', strtotime('-1 year'))
			]
		]);

		if (!empty($inactive)) {
			foreach ($inactive as $row) {
				$this->Analytic->deleteAll(['category' => 'Ad', 'label' => $row['Ad']['id']]);
			}
		}


		foreach ($this->request->data as &$row) {

			// Get the clicks from the analytics engine	
			// $row['Ad']['impressions'] += $this->Analytic->hits('Ad', 'Impression', $row['Ad']['title']);  
			// $row['Ad']['clicks'] += $this->Analytic->hits('Ad', 'Click', $row['Ad']['title']);  

			// Get historic impressions
			if (isset($_GET['historic'])) $row['Ad']['impressions'] += $row['Ad']['historic_impressions'];

			// This needs to be sorted @todo: fixme! 

			$report = false;
			if (strtotime($row['Ad']['modified']) > time() - YEAR)
				$report = true;
			if ($row['Ad']['enabled'] && (!$row['Ad']['end_date'] || strtotime($row['Ad']['end_date']) > time()))
				$report = true;

			if ($report) {
				$row['Ad']['impressions'] += $this->Analytic->hits('Ad', 'Impression', $row['Ad']['id']);
				$row['Ad']['clicks'] += $this->Analytic->hits('Ad', 'Click', $row['Ad']['id']);
			} else {
				$row['Ad']['impressions'] = '-';
				$row['Ad']['clicks'] = '-';
			}
		}

		$this->layout = 'admin';
	}


	public function admin_add()
	{

		$this->admin_edit();
	}

	public function admin_edit($id = null, $layout = null)
	{

		// Add UTM links automatically if omitted
		if (!empty($this->request->data['Ad']['destination_url'])) {
			$this->request->data['Ad']['destination_url'] = $this->Ad->addTracking($this->data['Ad']['destination_url']);
		}

		$this->set('adTypes', $this->Ad->AdType->find('list'));
		$this->set('types', $this->Ad->AdType->find('all', ['recursive' => -1]));

		parent::admin_edit($id);
	}

	public function admin_delete($id = null)
	{

		parent::admin_delete($id);
	}
}
