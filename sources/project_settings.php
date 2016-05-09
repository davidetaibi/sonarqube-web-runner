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
				<!-- <p class="breadcrumbs"> <a href="index.php"> Home </a> / Project Settings </p> -->

				<?php
				$nameErr = $keyErr = $repoLinkErr = $srcPathErr = "";
				 if (isset($_POST['submit_btn'])) {
				 	if (empty($_POST['proj_name'])) {
				 		$nameErr = "Project name required";
				 	}
				 	else{
				 		$proj_name = isset($_POST['proj_name']) ? "sonar.projectName=". $_POST['proj_name'] : ''; 
				 	}

				 	if (empty($_POST['proj_key'])) {
				 		$keyErr = "Project key required";
				 	}
				 	else{
				 		$proj_key = isset($_POST['proj_key']) ? "sonar.projectKey=". $_POST['proj_key'] : ''; 
				 	}

				 	if (isset($_POST['rdo_github'])) {
						$repo_link = isset($_POST['repo_link']) ? "githubRepo=". $_POST['repo_link'] : ''; 
					}
					elseif (isset($_POST['rdo_svn'])) {
						$repo_link = isset($_POST['repo_link']) ? "svnRepo=". $_POST['repo_link'] : ''; 
					}

				 	if (empty($_POST['repo_link'])) {
				 		$repoLinkErr = "Repository link required";
				 	}
				 	else{
				 		$repo_link = $repo_link;
				 	}

				 	if (empty($_POST['src_path'])) {
				 		$srcPathErr = "Source folder required";
				 	}
				 	else{
				 		$src_path = isset($_POST['src_path']) ? "sonar.sources=". $_POST['src_path'] : ''; 
				 	}

				 	$lang = isset($_POST['lang']) ? "sonar.language=". $_POST['lang'] : ''; 

				 	if (isset($_POST['rdo_utf'])) {
						$src_encode = "sonar.sourceEncoding=". $_POST['rdo_utf'];
					}
					elseif (isset($_POST['rdo_western'])) {
						$src_encode = "sonar.sourceEncoding=". $_POST['rdo_western'];
					}

					if (!$nameErr && !$keyErr && !$repoLinkErr && !$srcPathErr) {
						$proj_file_name= isset($_POST['proj_name']) ? $_POST['proj_name'] : ''; 
						$proj_file_name = preg_replace('/\s+/', '', $proj_file_name);
						//Writing to the project files list
						$proj_files_list = fopen("project_analysis/projects_list.properties", "a");
						fwrite($proj_files_list, $proj_file_name);
						fclose($proj_files_list);

						$path = fopen("project_analysis/$proj_file_name.properties", 'w');
						fwrite($path, $proj_name ."\n");
						fwrite($path, $proj_key ."\n");
						fwrite($path, $repo_link ."\n");
						fwrite($path, $src_path ."\n");
						fwrite($path, $lang ."\n");
						fwrite($path, $src_encode ."\n");
						fclose($path); 
					}
				 }

				?>

				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
					<h1 class="lblHeader"> Project Settings </h1>

					<p class="form_elements">
						<label> Project Name </label>
						<input type="text" name="proj_name"> </input> <span class="error"> <?php echo $nameErr; ?> </span>
					</p>
					<p class="form_elements">
						<label> Project Key  </label>
						<input type="text" name="proj_key"> </input>  <span class="error"> <?php echo $keyErr; ?> </span>
					</p>
					<p class="form_elements">
						<label> Repository Link </label>
						<input type="text" name="repo_link"> </input> <span class="error"> <?php echo $repoLinkErr; ?> </span>
					</p>
					<p class="form_elements">
						<label> Repository Type </label>
						<input type="radio" name="rdo_github" value="github" checked="true"> Github
						<input type="radio" name="rdo_svn" value="svn"> SVN
					</p>
					<p class="form_elements">
						<label> Source Folder </label>
						<input type="text" name="src_path"> </input>  <span style="font-size: 0.8em"> (Relative Path)eg: / SRC / Java / SRC2) </span>
																	 <span class="error"> <?php echo $srcPathErr; ?> </span>
					</p>
					<p class="form_elements">
						<label> Language </label>
						<select class="form-control" name="lang" style="width: 200px;">
							<option>Java</option>
							<option>C#</option>
							<option>Web</option>
						 </select>
					</p>
					<p class="form_elements">
						<label> Source Encoding </label>
						<input type="radio" name="rdo_utf" value="UTF-8" checked=true> UTF-8
						<input type="radio" name="rdo_western" value="Western"> Western
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