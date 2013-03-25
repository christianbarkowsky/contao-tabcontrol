<?php

/**
 * TabControl
 * 
 * @copyright  Christian Barkowsky 2013
 * @package    tabControl
 * @author     Christian Barkowsky <http://www.christianbarkowsky.de>
 * @license    LGPL
 */
 

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


class TabControlRunonce extends \Controller
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
		$objInstalledTabControl = $this->Database->query("SELECT version FROM tl_repository_installs WHERE extension='tabcontrol' LIMIT 1");
	
		if($objInstalledTabControl->version <= '30000009')
		{
			$this->Database->query("ALTER TABLE tl_content ADD tab_template varchar(64) NOT NULL default 'ce_tabcontrol_tab'");
			$this->Database->query("ALTER TABLE tl_content ADD tab_template_start varchar(64) NOT NULL default 'ce_tabcontrol_start'");
			$this->Database->query("ALTER TABLE tl_content ADD tab_template_stop varchar(64) NOT NULL default 'ce_tabcontrol_stop'");
			$this->Database->query("ALTER TABLE tl_content ADD tab_template_end varchar(64) NOT NULL default 'ce_tabcontrol_end	'");

			/*
			$objTabControl = $this->Database->query("SELECT * FROM tl_content WHERE type='tabcontrol' AND tabType='tabcontroltab'");
			*/
		}
	}
}


/**
 * Instantiate the controller
 */
$objTabControlRunonce = new TabControlRunonce();
$objTabControlRunonce->run();
