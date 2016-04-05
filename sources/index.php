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
		</div>

		<div class="content">
			<div class="section1"> 

				<h1 class="lblHeader"> Dashboard (Project List) </h1>

				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
					
					<table>
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

					</table>
				 	
				 	<p> 
				 		<button type="submit" name="submit_btn" class="btn btn-default"> Add New Projects </button> 
				 	</p>
				</form>
			</div>
		</div>
	</div>

</body>

</html>