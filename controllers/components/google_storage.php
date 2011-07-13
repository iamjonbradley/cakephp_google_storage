<?php
/**
 * Google Storage component
 *
 * Handles functions for Google Storage
 *
 * Requirements:
 * PHP 5+
 * CakePHP 1.3+
 *
 * Studdr(tm) : Real Life in 3D (http://studdr.com)
 * Copyright 2011 Afzet, Inc. (http://afzetinc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     	Copyright 2011, Afzet, Inc. (http://afzetinc.com)
 * @link          	https://github.com/jonbradley/Google-Storage-for-CakePHP
 * @author			Jonathan Braldey <jonathan@studdr.com>
 * @package       	google_storage
 * @subpackage    	google_storage.controller.components
 * @version         v 1.0
 * @license       	MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::import('Vendor', 'GoogleStorage.Tws_Service_Google_Storage', array('file' => 'Storage.php'));

/**
 * Google Storage component class
 *
 * Handles functions for Google Storage
 *
 * @package       	google_storage
 * @subpackage    	google_storage.controller.components
 * @link          	https://github.com/jonbradley/Google-Storage-for-CakePHP
 */
class GoogleStorageComponent extends Object {

	/**
	 * Initializes GoogleStorageComponent for use in the controller
	 * and loads the GoogleStorage Settings
	 *
	 * @param object $controller A reference to the instantiating controller object
	 * @return void
	 * @access public
	 */
	public function initialize(&$controller) {
		Configure::load('GoogleStorage.settings'); 
	}

	/**
	 * Main execution method. Handles the load of the connection to Google
	 * Storage
	 *
	 * @param object $controller A reference to the instantiating controller object
	 * @return boolean
	 * @access public
	 */
	function startup(&$controller) {
		self::__connect();
	}
	
	/**
	 * Controlls the upload and processing of objects to a Google Storage
	 * Bucket
	 *
	 * @param string $path The temporary path of the file uploaded
	 * @param string $name The name of the file to be uploaded
	 * @return string $name Returns the name of the string back to the action
	 * @access public
	 */
	public function publish ($path, $name) {
		$object = Configure::read('GoogleStorage.Bucket') .'/'. $name;
		$this->gs->putFile($path, $object, array('acl' => 'public-read'));
		return $name;
	}
	
	/**
	 * Creates a new bucket in Google Storage
	 *
	 * @param string $name The name of the file to be uploaded
	 * @return void
	 * @access public
	 */
	public function createBucket ( $name) {
		$this->gs->createBucket($name);
	}
	
	/**
	 * Returns all the buckets for a user
	 *
	 * @return array
	 */
	public function getBuckets() {
		return $this->gs->getBuckets($name);
	}
	
	/**
	 * Connects the conroller to GoogleStorage
	 *
	 * @return object $gs connection for google storage
	 * @access protected
	 */
	protected function __connect() {
		$this->gs = new Tws_Service_Google_Storage (
			Configure::read('GoogleStorage.AccessKey'), 
			Configure::read('GoogleStorage.AccessKeySecret')
		);
	}
}