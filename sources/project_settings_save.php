<?php

echo $_GET['action'];



				 		$xml=simplexml_load_file('project_analysis/shedule.xml') or die("Error: Cannot create object");
				 			//$xml=simplexml_load_file('project_analysis/shedule.xml')
				 		if ($action == 'update') {
				 			$a = $_GET['no']; //echo $a;
				 			//echo $xml->project[0]->repo_type;
				 			$j=0;
				 			foreach ($xml->project as $project) {
				 				if ($a==$j) {
				 					$proj_name = $project[0]->name;
				 					$repo_link = $project[0]->repo_link;
				 					$repo_type = $project[0]->repo_type;
				 					$src_path = $project[0]->src_path;
				 					$lang = $project[0]->lang;
				 					$src_encode = $project[0]->src_encode;
				 				} 
				 				$j++;
				 			}
				 		}
				 		elseif ($action == 'add') {
				 			$proj_name = '';			 					
				 			$repo_link = '';
				 		}
?> 



