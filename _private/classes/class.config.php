<?php

class config
{
	public function setup() {

		$sites = array('electronicdictionary.org.uk' => 1, 'test.electronicdictionaries.co.uk' => 1);

		if (false === array_key_exists($_SERVER['HTTP_HOST'], $sites)) {
			die('Watcha doing? this is not a valid domain.');
		}
		
		$config = $sites[$_SERVER['HTTP_HOST']];

		switch ($config) 
		{
			case 1:
			{
				$this->theme = 'default';
				$this->domain = 'http://www.electronicdictionary.org.uk';
				$this->domain = 'http://test.electronicdictionaries.co.uk';
				$this->name = 'Electronic Dictionaries';
				$this->title = 'The Electronic Dictionary Shop | Electronic Dictionaries - Free Delivery';
				$this->cats = array(511 => 'Electronic Crosswords',
									  512 => 'Electronic Dictionaries',
									  513 => 'Electronic Encyclopedia',
									  519 => 'Electronic Thesaurus');

				$this->menu = array("Electronic Dictionaries", "About", "Contact Us", "Delivery & Returns", "Why Buy From Us");
				break;
			}
		}

		
	}

	
}