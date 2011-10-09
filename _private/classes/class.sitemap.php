<?php

class sitemap{
    private $dom;
    private $site;
	private $xml_result;
    
    public function __construct(){
        // create the new XML document
        $this->dom = new DOMDocument('1.0');

        // create the root element
        $this->site = $this->dom->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9','urlset');
		$this->dom->appendChild($this->site);

	}
	public function addItem($location){

		$url = $this->site->appendChild($this->dom->createElement('url'));
		$url = $this->site->appendChild($url);

		$loc = $url->appendChild($this->dom->createElement('loc'));
		$loc->appendChild($this->dom->createTextNode($location));

        $this->xml_result = $this->dom->saveXML();
    }

    public function getSitemap(){
        return $this->xml_result;
    }
}