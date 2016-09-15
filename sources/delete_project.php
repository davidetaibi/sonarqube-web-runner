<?php

$id = $_GET['key'];
$index = 0;
$i = 0;

//$xml = simplexml_load_file('project_analysis/shedule.xml');

//$xml = new SimpleXMLElement('project_analysis/shedule.xml',null,true);

if (isset($id)) {
	$file = 'project_analysis/shedule.xml';
	$xml = simplexml_load_file($file) or die("Error: Cannot create object");

	foreach ($xml->project as $project) {
		if ($project['key']==$id) {
			$index = $i;
			break;
		}
		$i++;
	}
	unset($xml->project[$index]); 
	file_put_contents($file, $xml->asXml());

}

sleep(1);
header('location:index.php');

?>