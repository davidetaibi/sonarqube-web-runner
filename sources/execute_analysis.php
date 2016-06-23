<?php



//echo date("d-m-y h:i:s A");

shell_exec('project_analysis/execute-sonar-svn.sh');

$file = 'project_analysis/shedule.xml';
$xml = simplexml_load_file($file) or die("Error: Cannot create object");
print_r($xml);

echo "<br>";

foreach ($xml->project as $project) {
	//$project -> addChild('dt_execute',date("d-m-y h:i:s A") );
	//echo $project->analyse . "<br>";

	//update child node
	$project->dt_execute = date("d-m-y h:i:s A");
	$xml->asXML($file);

}

header('Location:index.php'); 


?>