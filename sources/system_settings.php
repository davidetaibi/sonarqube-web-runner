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
					<li> <a href="#"> Home </a> </li>
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
				<p class="breadcrumbs"> <a href="index.php"> Main </a> / System Settings </p>
				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
					<h1 class="lblHeader"> System Settings </h1>

					<p class="form_elements">
						<label> Sonarqube Instance </label>
						<input type="text"></input>
					</p>
					<p class="form_elements">
						<label> Username </label>
						<input type="text"></input>
					</p>
					<p class="form_elements">
						<label> Password </label>
						<input type="password"></input>
					</p>
					<p>
						<button type="submit" name="submit_btn" class="btn btn-default">Save</button> 
					</p>
				</form>
			</div>
		</div>
	</div>

</body>

</html>