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
				 	<p>
				 		<?php
				 			$instanceErr = $usernameErr = $passwordErr = "";
				 			if (isset($_POST['submit_btn'])) {
				 				if (empty($_POST['txt_instance'])) {
				 					$instanceErr = "Instance required";
				 				}
				 				else{
				 					$instance = 'sonar.host.url='.$_POST['txt_instance']; 
				 				}
				 				if (empty($_POST['txt_username'])) {
				 					$usernameErr = "Username required";
				 				}
				 				else{
				 					$username = 'sonarqube_web_runner.username='.$_POST['txt_username']; 
				 				}
				 				if (empty($_POST['txt_password'])) {
				 					$passwordErr = "Password required";
				 				}
				 				else{
				 					$password = 'sonarqube_web_runner.password='.$_POST['txt_password']; 
				 				}

				 				if (!$instanceErr && !$usernameErr && !$passwordErr) {
									$path = fopen("sonar-runner/conf/sonar-runner.properties", 'w');
									fwrite($path, $instance ."\n");
									fwrite($path, $username ."\n");
									fwrite($path, $password ."\n");
									fclose($path); 
									//Validate data saving message
									$saved_msg = "Information Saved Successfully.";
								} 

				 			}
					
						?> 

				 	</p>


				<!-- <p class="breadcrumbs"> <a href="index.php"> Home </a> / System Settings </p> -->
				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
					<h1 class="lblHeader"> System Settings </h1>

					<?php $saved_msg = isset($saved_msg) ? $saved_msg : '' ; ?>
					
					<p class="form_elements">
						<label> Sonarqube Instance </label>
						<input type="text" name="txt_instance"></input> <span class="error"> <?php echo $instanceErr; ?> </span>
					</p>
					<p class="form_elements">
						<label> Username </label>
						<input type="text" name="txt_username"> <span class="error"> <?php echo $usernameErr; ?> </input>
					</p>
					<p class="form_elements">
						<label> Password </label>
						<input type="password" name="txt_password"> <span class="error"> <?php echo $passwordErr; ?> </input>
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