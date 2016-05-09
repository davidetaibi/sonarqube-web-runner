<!DOCTYPE html>
<html>
<head>
	 <!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
	<!--<link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css"/> -->
	<link rel="stylesheet" href="css/style.css">
	<title>
		Sonarqube web application
	</title>
</head>
<body>
	<div class="wrapper">
		<div class="header">
			<div class="logo">
				<img src="http://sonar.inf.unibz.it/images/logo.svg">
			</div> 
			<div class="nav">
				<ul>
					<li> <a href="index.php"> Home </a> </li>
					<li> <a href="system_settings.php"> System Settings </a> </li>
					<!-- <li> <a href="#"> Measures </a> </li>
					<li> <a href="#"> Rules </a> </li>
					<li> <a href="#"> Quality Profiles </a> </li>
					<li> <a href="#"> Quality Gates </a> </li>
					<li> <a href="#"> More </a> </li> -->
				</ul>
			</div> 
		</div>

		<div class="content">
			<div class="section1"> 
				
			<?php

			if (isset($_POST['submit_btn'])) {
			
					$download = isset($_POST['optDownload']) ? $_POST['optDownload'] : '';
					$projectName = isset($_POST['optProject']) ? $_POST['optProject'] : '';
					$analyse = isset($_POST['optAnalyse']) ? $_POST['optAnalyse'] : '';
				

				// CREATING A NEW XML DOCUMENT
				
				/* $projects = $xml -> createElement("projects");
				$projects = $xml -> appendChild($projects);

				$project = $xml->createElement($projectName);
				$project = $projects->appendChild($project); */

				/* $xml = new DomDocument("1.0","UTF-8");

				$projects = $xml -> createElement("projects");
				$projects = $xml -> appendChild($projects);

				$project = $xml->createElement("project");
				$project = $projects->appendChild($project);

				$projectName = $xml->createElement("key",$projectName);
				$projectName = $project->appendChild($projectName);

				$download = $xml->createElement("download",$download);
				$download = $project->appendChild($download);

				$analyse = $xml->createElement("analyse",$analyse);
				$analyse = $project->appendChild($analyse);

				$xml->FormatOutput = true;
				$string_value = $xml->saveXml();
				$xml->save("project_analysis/shedule.xml"); */


				//APPENDING TO A XML DOCUMENT
				$xml = new DOMDocument();
			    $xml->load('project_analysis/shedule.xml');

			    $root = $xml->firstChild;
			    //$root = $xml->getElementsByTagName("projects");

				$project = $xml->createElement("project");
				$root->appendChild($project);

				$projectName = $xml->createElement("key",$projectName);
				$projectName = $project->appendChild($projectName);

				$download = $xml->createElement("download",$download);
				$download = $project->appendChild($download);

				$analyse = $xml->createElement("analyse",$analyse);
				$analyse = $project->appendChild($analyse);

				$xml->FormatOutput = true;
				$string_value = $xml->saveXml();
				$xml->save("project_analysis/shedule.xml");

			}
			?>


				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
					<h1 class="lblHeader"> Shedule Analysis </h1>

					<p class="form_elements">
						<label> Project </label>

						<?php
						echo '<select name="optProject">';
							$proj_list = fopen("project_analysis/projects_list.properties", 'r');
							while(!feof($proj_list)){
								$project = fgets($proj_list);
								
									echo '<option>' . $project . '</option>';
							}
						echo'</select>';
						?>
					</p>
					<p class="form_elements">
						<label>Download Project:</label>
					 	<input type="radio" name="optDownload" value="Daily">Daily
						<input type="radio" name="optDownload" value="Weekly">Weekly
						<input type="radio" name="optDownload" value="Monthly">Monthly 					
					</p>
					<p class="form_elements">
						<label> Analyze </label> 
						<input type="radio" name="optAnalyse" value="Each Commit">Each Commit
						<input type="radio" name="optAnalyse" value="Last Commit of the Day">Last Commit of the Day 
						<input type="radio" name="optAnalyse" value="Last Commit of the Week">Last Commit of the Week
						<input type="radio" name="optAnalyse" value="Monthly">Monthly
					</p>
					<button type="submit" name="submit_btn" class="btn btn-default">Save</button> 
				</form>
			</div>
		</div>
	</div>

</body>

</html>