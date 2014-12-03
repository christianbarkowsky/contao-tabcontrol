<?php

/**
 * TabControl
 * 
 * @copyright  Christian Barkowsky 2014
 * @package    tabControl
 * @author     Christian Barkowsky <http://christianbarkowsky.de>
 * @license    LGPL
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
			if (!$this->Database->fieldExists('tab_tabs', 'tl_content'))
			{
				$this->Database->query("ALTER TABLE tl_content ADD tab_tabs blob NULL");
			}			
		
			if (!$this->Database->fieldExists('tab_template', 'tl_content'))
			{
				$this->Database->query("ALTER TABLE tl_content ADD tab_template varchar(64) NOT NULL default 'ce_tabcontrol_tab'");
			}
			
			if (!$this->Database->fieldExists('tab_template_start', 'tl_content'))
			{
				$this->Database->query("ALTER TABLE tl_content ADD tab_template_start varchar(64) NOT NULL default 'ce_tabcontrol_start'");
			}
			
			if (!$this->Database->fieldExists('tab_template_stop', 'tl_content'))
			{
				$this->Database->query("ALTER TABLE tl_content ADD tab_template_stop varchar(64) NOT NULL default 'ce_tabcontrol_stop'");
			}
			
			if (!$this->Database->fieldExists('tab_template_end', 'tl_content'))
			{
				$this->Database->query("ALTER TABLE tl_content ADD tab_template_end varchar(64) NOT NULL default 'ce_tabcontrol_end'");
			}

			$objTabControl = $this->Database->query("SELECT * FROM tl_content WHERE type='tabcontrol' AND tabType='tabcontroltab'");
			
			while ($objTabControl->next())
			{
				if ($this->Database->fieldExists('tabTitles', 'tl_content'))
				{
					$arrTabs = array();
					$arrTabTitles = deserialize($objTabControl->tabTitles);
					
					foreach($arrTabTitles as $title)
					{
						$arrTabs[] = array('tab_tabs_name' => $title, 'tab_tabs_cookies_value' => '', 'tab_tabs_default' => '');
					}
					
					$this->Database->query("UPDATE tl_content SET tab_tabs='". serialize($arrTabs) ."' WHERE id=". $objTabControl->id ."");
				}				
			}
		}
	}
}


/**
 * Instantiate the controller
 */
//$objTabControlRunonce = new TabControlRunonce();
//$objTabControlRunonce->run();
