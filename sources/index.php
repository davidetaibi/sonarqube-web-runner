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

	<!-- <script type="text/javascript">
		function confirm_click()
		{
		if(confirm('Are you sure?'))
			window.location.href='delete_project.php?key='.$project->name.'?';
		}
	</script> -->

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
				 			$xml=simplexml_load_file('project_analysis/shedule.xml') or die("Error: Cannot create object");
				 			//$xml=simplexml_load_file('project_analysis/shedule.xml')

						?> 

						<table>
							<th> Project </th>
							<th> Last Analysis </th>
							<th> Frequency </th>
							<th> Settings </th> 

							<?php
							$i=0;
							foreach ($xml->project as $project) {
								echo'<tr>';
									echo'<td>' . $project->name . '</td>';
									echo'<td>' . $project->date_execute .'</td>';
									echo'<td>' . $project->analyse . '</td>';
									echo'<td>';
										//echo'<a href="'. shell_exec('project_analysis/execute-sonar-svn.sh') .'"> <img src="css/img/exec_analysis.png" class="img_icon" title="Execute Analysis"> </a>';
										echo'<a href="execute_analysis.php"> <img src="css/img/exec_analysis.png" class="img_icon" title="Execute Analysis"> </a>';
										echo'<a href="project_settings.php?action=update&no='.$i.'&key='.$project['key'].' "> <img src="css/img/proj_settings.png" class="img_icon" title="Project Settings"> </a>';
										echo'<a href="shedule.php?key='.$project['key'].'"> <img src="css/img/shedule_analysis.png" class="img_icon" title="Shedule Analysis"> </a>';
										//echo'<a href="delete_project.php?key='.$project->name.'" "> <img src="css/img/delete.png" class="img_icon" title="Delete Project"> </a>'; 
										echo'<a href="delete_project.php?action=delete&key='.$project['key'].'"> <img src="css/img/delete.png" class="img_icon" title="Delete Project"> </a>'; 
									echo'</td>';
								echo'</tr>';
								$i++;
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