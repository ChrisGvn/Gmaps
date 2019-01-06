<?php
//DB params
$db_username = 'mapsuser';
$db_password = '5428';
$db_name = 'markers';
$db_host = 'localhost';

try{
	//DB Connection
	$pdo = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_username, $db_password);
	$pdo -> exec('set names utf8');//?????
}
catch(Exception $e){
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}

//Create DOM structure to contain the fetched data
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


//SQL query fething the data from DB
$sql = 'SELECT * from markers';
$statement = $pdo->prepare($sql);// prepare or query?
$statement->execute();//Excecute it

//set document header to text/xml
header("Content-type: text/xml"); 


while($row = $statement->fetch()){	//If the query has returned with results

	//Create an XML node for every result
	$node = $dom->createElement("marker");  
  	$newnode = $parnode->appendChild($node);   
  	$newnode->setAttribute("lat", $row['lat']);  
  	$newnode->setAttribute("lng", $row['lng']);  
}

echo $dom->saveXML();



