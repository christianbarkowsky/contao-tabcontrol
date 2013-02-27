<?php

/**
 * TabControl
 * 
 * @copyright  Christian Barkowsky 2012-2013
 * @package    tabControl
 * @author     Christian Barkowsky <http://www.christianbarkowsky.de>
 * @license    LGPL
 */

class TabControlRunonce extends Controller
{

	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();

		$this->import('Database');
	}


	/**
	 * Run the controller
	 */
	public function run()
	{
	}
}


/**
 * Instantiate the controller
 */
$objTabControlRunonce = new TabControlRunonce();
$objTabControlRunonce->run();
