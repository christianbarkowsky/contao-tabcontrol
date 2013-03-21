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
		$objTabControl = $this->Database->query("SELECT * FROM tl_content WHERE type='tabcontrol'");

		while($objTabControl->next())
		{
		
			if($objTabControl->tabType == 'tabcontroltab')
			{
				//$this->Database->prepare("UPDATE tl_content SET tab_template=? WHERE id=?")->execute('ce_tabcontrol_tab', $objStores->id);
			}
			
			if($objTabControl->tabType == 'tabcontrolstart')
			{
				//$this->Database->prepare("UPDATE tl_content SET tab_template_start=? WHERE id=?")->execute('ce_tabcontrol_start', $objStores->id);
			}
			
			if($objTabControl->tabType == 'tabcontrolstop')
			{
				//$this->Database->prepare("UPDATE tl_content SET tab_template_stop=? WHERE id=?")->execute('ce_tabcontrol_stop', $objStores->id);
			}
			
			if($objTabControl->tabType == 'tabcontrol_end')
			{
				//$this->Database->prepare("UPDATE tl_content SET tab_template_end=? WHERE id=?")->execute('ce_tabcontrol_end', $objStores->id);
			}		
		}
	}
}


/**
 * Instantiate the controller
 */
$objTabControlRunonce = new TabControlRunonce();
$objTabControlRunonce->run();
