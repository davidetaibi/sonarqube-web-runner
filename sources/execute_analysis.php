<?php

// vmware , turnkey linux lamp stack

//echo date("d-m-y h:i:s A");

echo shell_exec('project_analysis/execute-sonar-svn.sh');

$file = 'project_analysis/shedule.xml';
$xml = simplexml_load_file($file) or die("Error: Cannot create object");

foreach ($xml->project as $project) {
	//$project -> addChild('dt_execute',date("d-m-y h:i:s A") );
	//echo $project->analyse . "<br>";

	if ($_GET['key']==$project['key']) {
		//update child node
		$project->dt_execute = date("d-m-y h:i:s A");
		$xml->asXML($file);
	}
} 

header('Location:index.php'); 

?>