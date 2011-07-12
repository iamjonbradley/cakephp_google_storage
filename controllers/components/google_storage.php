<?php

App::import('Vendor', 'GoogleStorage.Tws_Service_Google_Storage', array('file' => 'Storage.php'));
class GoogleStorageComponent extends Object {
	
	public $gs = '';
	
	public function startup(&$controller) {
	}
	
	public function initialize(&$controller) {
		Configure::load('GoogleStorage.settings'); 
	}
	
	public function publish ($path, $name) {
		
		self::__connect();
		self::__debug();
		
		$object = Configure::read('GoogleStorage.Bucket') .'/'. $name;
		
		$this->gs->putFile($path, $object, array('acl' => 'public-read'));
		
		return $name;
	}
	
	private function __connect() {
		$this->gs = new Tws_Service_Google_Storage (
			Configure::read('GoogleStorage.AccessKey'), 
			Configure::read('GoogleStorage.AccessKeySecret')
		);
	}
	
	private function __debug() {
		if (Configure::read('debug') == 0) 
			$this->gs->setDebug(false);
		else
			$this->gs->setDebug(true);
	}
}