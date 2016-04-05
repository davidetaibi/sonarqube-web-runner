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
				<p class="breadcrumbs"> <a href="index.php"> Main </a> / Project Settings </p>
				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
					<h1 class="lblHeader"> Project Settings </h1>

					<p class="form_elements">
						<label> Project Name </label>
						<input type="text"> </input>
					</p>
					<p class="form_elements">
						<label> Project Key  </label>
						<input type="text"> </input>
					</p>
					<p class="form_elements">
						<label> Repository Link </label>
						<input type="text"> </input>
					</p>
					<p class="form_elements">
						<label> Repository Type </label>
						<input type="radio" name="rdoDaily"> Daily
						<input type="radio" name="rdoWeekly"> Weekly
					</p>
					<p class="form_elements">
						<label> Source Folder </label>
						<input type="text"> </input>  <span style="font-size: 0.8em"> (Relative Path)eg: / SRC / Java / SRC2) </span>
					</p>
					<p class="form_elements">
						<label> Language </label>
						<select class="form-control" id="proj_name" style="width: 200px;">
							<option>Java</option>
							<option>C#</option>
							<option>Web</option>
						 </select>
					</p>
					<p class="form_elements">
						<label> Source Encoding </label>
						<input type="radio" name="rdo_utf"> UTF-8
						<input type="radio" name="rdo_western"> Western
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