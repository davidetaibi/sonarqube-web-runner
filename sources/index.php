<!DOCTYPE html>
<html>
<head>
	 <!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
	<!-- <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css"/> -->
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
				<h1 class="lblHeader"> Projects </h1>
				
				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
					
				 	<?php
				 			$xml=simplexml_load_file("project_analysis/shedule.xml") or die("Error: Cannot create object");

				 			//echo $xml->project[2]->key;

									/* echo "<table>";
									$proj_list = fopen("project_analysis/projects_list.properties", 'r');
									while(!feof($proj_list))
									{
										$project = fgets($proj_list); 
										echo "<tr>";
											echo  "<td>" . $project . "</td>" . "<br>";
										echo "</tr>";
									}
								echo "</table>"; 
									fclose($proj_list);  */
						?> 


						<table>
							<th> Project </th>
							<th> Last Analysis </th>
							<th> Frequency </th>
							<th> Settings </th> 

							<?php
							foreach ($xml->project as $project) {
								echo'<tr>';
									echo'<td>' . $project->key . '</td>';
									echo'<td>' . 'N/A' .'</td>';
									echo'<td>' . $project->analyse . '</td>';
									echo'<td>';
										echo'<a href="#"> <img src="css/img/exec_analysis.png" class="img_icon" title="Execute Analysis"> </a>';
										echo'<a href="project_settings.php"> <img src="css/img/proj_settings.png" class="img_icon" title="Project Settings"> </a>';
										echo'<a href="shedule.php"> <img src="css/img/shedule_analysis.png" class="img_icon" title="Shedule Analysis"> </a>';
										echo'<a href="#"> <img src="css/img/delete.png" class="img_icon" title="Delete Project"> </a>';
									echo'</td>';
								echo'</tr>';
							}
							?>

						</table>

					<!-- <table>
						<th> Project </th>
						<th> Last Analysis </th>
						<th> Frequency </th>
						<th> Settings </th> 
					
						<tr>
							<td> Project 1 </td>
							<td> 05/03/2016 </td>
							<td> Each Revision </td>
							<td> 
								<a href="#"> <img src="css/img/exec_analysis.png" class="img_icon" title="Execute Analysis"> </a>
								<a href="project_settings.php"> <img src="css/img/proj_settings.png" class="img_icon" title="Project Settings"> </a>
								<a href="shedule.php"> <img src="css/img/shedule_analysis.png" class="img_icon" title="Shedule Analysis"> </a>
								<a href="#"> <img src="css/img/delete.png" class="img_icon" title="Delete Project"> </a>
							</td>
						</tr>
						<tr>
							<td> Project 2 </td>
							<td> 02/04/2016 </td>
							<td> Daily </td>
							<td> 
								<a href="#"> <img src="css/img/exec_analysis.png" class="img_icon" title="Execute Analysis"> </a>
								<a href="project_settings.php"> <img src="css/img/proj_settings.png" class="img_icon" title="Project Settings"> </a>
								<a href="shedule.php"> <img src="css/img/shedule_analysis.png" class="img_icon" title="Shedule Analysis"> </a>
								<a href="#"> <img src="css/img/delete.png" class="img_icon" title="Delete Project"> </a>
							</td>
						</tr>

					</table> -->
				 	
				 	<p> 
				 		<input type="button" name="submit_btn" value="Add New Projects" onclick="window.location.href='project_settings.php' ">
				 	</p>

				</form>
			</div>
		</div>
	</div>

</body>

</html>