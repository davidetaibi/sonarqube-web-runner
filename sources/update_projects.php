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

				<?php
					//$action =  isset($_GET['action']) ? $_GET['action'] : ''; 
					$nameErr = $keyErr = $repoLinkErr = $srcPathErr = '';

					if (isset($_POST['submit_btn'])) 
					{
						//APPENDING TO A XML DOCUMENT
						$file = 'project_analysis/shedule.xml';
						$xml = simplexml_load_file($file) or die("Error: Cannot create object");

						foreach ($xml->project as $project) 
						{
							if ($_POST['proj_name'] == $project->name) 
							{
								$project->repo_link = $_POST['repo_link'];		
								$project->repo_type = $_POST['rdo_repo'];
								$project->src_path = $_POST['src_path'];	
								$project->lang = $_POST['lang'];
								$project->src_encode = $_POST['rdo_encode'];					 
								$xml->asXML($file); 
							}
						} 
					sleep(1);
					header('location:index.php');
					}

					

				?>

				<?php

				 		$xml=simplexml_load_file('project_analysis/shedule.xml') or die("Error: Cannot create object");
				 			//$xml=simplexml_load_file('project_analysis/shedule.xml')
				 		
				 		if (!isset($_POST['submit_btn'])) {
				 			//echo "update mode";
				 			$index = $_GET['no']; //echo $a;
				 			//echo $xml->project[0]->repo_type;
				 			$j=0;
				 			foreach ($xml->project as $project) {
				 				if ($index==$j) {
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
				 		
					?> 

				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">

					<h1 class="lblHeader"> Project Settings </h1>

					<?php $saved_msg = isset($saved_msg) ? $saved_msg : '' ; ?>

					<p> <span class="saved_msg"> <?php echo $saved_msg; ?></span> </p>
					<p class="form_elements">
						<label> Project Name </label>
						<input type="text" name="proj_name" value="<?php echo $proj_name; ?>"> </input> <span class="error"> <?php echo $nameErr; ?> </span>
					</p>
					</p> 
					<p class="form_elements">
						<label> Repository Link </label>
						<input type="text" name="repo_link" value="<?php echo $repo_link; ?>"> </input> <span class="error"> <?php echo $repoLinkErr; ?> </span>
					</p>
					<p class="form_elements">
						<label> Repository Type </label> 
						<?php 
							if (isset($repo_type) && $repo_type=='github') {
								echo '<input type="radio" name="rdo_repo" value="github" checked="true"> Github';
								echo '<input type="radio" name="rdo_repo" value="svn"> SVN';
							}elseif (isset($repo_type) && $repo_type=='svn') {
								echo '<input type="radio" name="rdo_repo" value="github"> Github';
								echo '<input type="radio" name="rdo_repo" value="svn" checked="true"> SVN'; 
							}elseif (!isset($repo_type)) {
								echo '<input type="radio" name="rdo_repo" value="github" checked="true"> Github';
								echo '<input type="radio" name="rdo_repo" value="svn"> SVN'; }
						?>
					</p>
					<p class="form_elements">
						<label> Source Folder </label>
						<?php $src_path = isset($src_path) ? $src_path: ''; ?>
						<input type="text" name="src_path" value="<?php echo $src_path; ?>"> </input>  <span style="font-size: 0.8em"> (Relative Path)eg: / SRC / Java / SRC2) </span>
						<span class="error"> <?php echo $srcPathErr; ?> </span>
					</p>
					<p class="form_elements">
						<label> Language </label>
						
						<select class="form-control" name="lang" style="width: 200px;">
							<?php
								if ($lang=='Java') {
									echo "<option selected> java </option>";
									echo "<option> C# </option>";
									echo "<option> Web </option>";
								}
								elseif ($lang=='C#') {
									echo "<option >java</option>";
									echo "<option selected>C#</option>";
									echo "<option >Web</option>";
								}
								elseif ($lang=='Web') {
									echo "<option>java</option>";
									echo "<option>C#</option>";
									echo "<option selected>Web</option>";
								}
								else{
									echo "<option>java</option>";
									echo "<option>C#</option>";
									echo "<option>Web</option>";	
								}
							?>
						 </select>
					</p>
					<p class="form_elements">
						<label> Source Encoding </label>

						<?php 
							if (isset($src_encode) && $src_encode=='UTF-8') {
								echo '<input type="radio" name="rdo_encode" value="UTF-8" checked="true"> UTF-8';
								echo '<input type="radio" name="rdo_encode" value="Western"> Western';
							}elseif (isset($src_encode) && $src_encode=='Western') {
								echo '<input type="radio" name="rdo_encode" value="UTF-8"> UTF-8';
								echo '<input type="radio" name="rdo_encode" value="Western" checked="true"> Western'; 
							}elseif (!isset($src_encode)) {
								echo '<input type="radio" name="rdo_encode" value="UTF-8" checked="true"> UTF-8';
								echo '<input type="radio" name="rdo_encode" value="Western"> Western'; }
						?>
					</p>
					<p>
						<input id="submit" type="submit" name="submit_btn" value="Update" class="btn btn-default">
					</p>
				</form>
			</div>
		</div>
	</div>

</body>

</html>