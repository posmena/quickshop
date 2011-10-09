<?php

function curl_get_file_contents($url, $limit = null)
{
	// Output something so we know it's working.
	print "Downloading...\n";//'".$url."'\n";
	flush();
	
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	
	if ($limit !== null) {
		$offset = 0;
		$size = $limit;
		
		$a = $offset;
		$b = $offset + $size-1;
		curl_setopt($c, CURLOPT_HTTPHEADER, array("Range: bytes=$a-$b") );
	}
	
	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 5000);
	curl_setopt($c, CURLOPT_TIMEOUT, 10000);

	$contents = curl_exec($c);
	curl_close($c);

	return $contents;
}


$data = curl_get_file_contents('http://www.atsdistribution.co.uk/feeds/Xml_All_Products.aspx');
$local_file = 'files/atsfeed.xml';
$fp = fopen($local_file, 'w+');
fwrite($fp, $data);
fclose($fp);

$file = $local_file;
$reader = new XMLReader();
	$reader->open($file);


// Read each line of the XML
$i=0;
$query ='';
$x = 0;

$conn = new Mongo('localhost');
$mdb = $conn->quickshop;
$collection = $mdb->atsproducts;
//$collection->drop();
$collection->ensureIndex(array('DropshipPrice' =>  1));
$collection->ensureIndex(array('CategoryID' =>  1));
$collection->ensureIndex(array('ProductID' =>  1));

while ($reader->read())
{
	switch ($reader->nodeType)
	{
		// Check that this line is an element, rather than a declartion or a comment.
		case (XMLREADER::ELEMENT):
		{
			// We only care if the element is a product
			if ($reader->localName == 'Product')
			{
				$node = $reader->expand();
				$dom = new DomDocument();
				$domNode = $dom->importNode($node,true);
				$dom->appendChild($domNode);
				$product = simplexml_import_dom($domNode);

				if ($product->Description == '' || false === isset($product->Description)) {
					//print "This product does not have a description\n";
					$x++;
				}

				$product->DropshipPrice = ceil($product->DropshipPrice * 1.20) + 0.97;
				$product->_id = $product->ProductID;
				$collection->save($product);
				$i++;

			}
		}
	}
}

echo $i . " number of products inserted successfully!\n";
echo "There were $x number of products without a description at all\n";