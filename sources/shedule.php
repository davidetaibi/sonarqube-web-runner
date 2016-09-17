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

		   	$downloadErr = $analyzeErr = "";
			if (isset($_POST['submit_btn'])) {
			
				if (empty($_POST['optProject'])) {
				 		$nameErr = "Project name required";
				 }
				else{
				 	$projectName = isset($_POST['optProject']) ? $_POST['optProject'] : '';
				}
				if (empty($_POST['optDownload'])) {
				 		$downloadErr = "Select download frequency";
				 }
				else{
				 	$download = isset($_POST['optDownload']) ? $_POST['optDownload'] : '';
				}
				if (empty($_POST['optAnalyse'])) {
				 		$analyzeErr = "Select analyze frequency";
				 }
				else{
				 	$analyse = isset($_POST['optAnalyse']) ? $_POST['optAnalyse'] : '';
				}

				$dt_execute = '00/00/0000';

				if (!$downloadErr && !$analyzeErr) {
					//APPENDING TO A XML DOCUMENT

				    $file = 'project_analysis/shedule.xml';
					$xml = simplexml_load_file($file) or die("Error: Cannot create object");

					foreach ($xml->project as $project) {
						if ($_POST['optProject'] == $project->key) {
						 	$project->download = $_POST['optDownload'];		
						 	$project->analyse = $_POST['optAnalyse'];					 
						 	$xml->asXML($file); 
						}
					} 


					//Validate data saving message
					$saved_msg = "Information Saved Successfully.";
					sleep(1);
					header('location:index.php');

				} 
				
			}
			?>


				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
					<h1 class="lblHeader"> Shedule Analysis </h1>

					<?php $saved_msg = isset($saved_msg) ? $saved_msg : '' ; ?>
					<p> <span class="saved_msg"> <?php echo $saved_msg; ?></span> </p>

					<p class="form_elements">
						<label> Project </label> 
						<?php

						/* echo '<select name="optProject">';
							$proj_list = fopen("project_analysis/projects_list.properties", 'r');
							while(!feof($proj_list)){
								$project = fgets($proj_list);
									echo '<option>' . $project . '</option>';
							}
						echo'</select>'; */

						$xml=simplexml_load_file("project_analysis/shedule.xml") or die("Error: Cannot create object");

						//echo $xml['attribute']; 


						echo '<select name="optProject">';
							foreach ($xml->project as $project) 
							{
								//$role = $project->attributes();


								if ($_GET['key']==$project['key']) {
									echo '<option selected>' . $project['key'] . '</option>';
								}
								else
								{
									echo '<option>' . $project['key'] . '</option>';
								}
							}
						echo'</select>';


						?>
					</p>
					<p class="form_elements">
						<label>Download Project:</label>
					 	<input type="radio" name="optDownload" value="Daily">Daily
						<input type="radio" name="optDownload" value="Weekly">Weekly
						<input type="radio" name="optDownload" value="Monthly">Monthly 		
						<span class="error"> <?php echo $downloadErr; ?> </span>
					</p>  

					<p class="form_elements">
						<label> Analyze </label> 
						<input type="radio" name="optAnalyse" value="Each Commit">Each Commit
						<input type="radio" name="optAnalyse" value="Last Commit of the Day">Last Commit of the Day 
						<input type="radio" name="optAnalyse" value="Last Commit of the Week">Last Commit of the Week
						<input type="radio" name="optAnalyse" value="Monthly">Monthly
						<span class="error"> <?php echo $analyzeErr; ?> </span>
					</p>
					<button type="submit" name="submit_btn" class="btn btn-default">Save</button> 
				</form>
			</div>
		</div>
	</div>

</body>

</html>