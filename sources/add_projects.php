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

					$nameErr = $keyErr = $repoLinkErr = $srcPathErr = '';

					if (isset($_POST['submit_btn'])) 
					{
							if (empty($_POST['proj_name'])) {
					 			$nameErr = "Project name required";
						 	}
						 	else{
						 		$proj_name = isset($_POST['proj_name']) ? $_POST['proj_name'] : '';
						 		$proj_name_txt = isset($_POST['proj_name']) ? "sonar.projectName=". $_POST['proj_name'] : ''; 
						 	}

						 	$proj_name_compressed = preg_replace('/\s+/', '', $_POST['proj_name']);
						 	$proj_key = isset($_POST['proj_name']) ?  $proj_name_compressed : ''; 
						 	$proj_key_txt = isset($_POST['proj_name']) ? "sonar.projectKey=". $proj_name_compressed : ''; 

						 	if (isset($_POST['rdo_github'])) {
						 		$repo_link = isset($_POST['repo_link']) ? $_POST['repo_link'] : ''; 
								$repo_link_txt = isset($_POST['repo_link']) ? "githubRepo=". $_POST['repo_link'] : ''; 
							}
							elseif (isset($_POST['rdo_svn'])) {
								$repo_link = isset($_POST['repo_link']) ? $_POST['repo_link'] : ''; 
								$repo_link_txt = isset($_POST['repo_link']) ? "svnRepo=". $_POST['repo_link'] : ''; 
							}

						 	if (empty($_POST['repo_link'])) {
						 		$repoLinkErr = "Repository link required";
						 	}
						 	else{
						 		$repo_link = $_POST['repo_link'];
						 	}

						 	if (empty($_POST['src_path'])) {
						 		$srcPathErr = "Source folder required";
						 	}
						 	else{
						 		$src_path = isset($_POST['src_path']) ? $_POST['src_path'] : ''; 
						 		$src_path_txt = isset($_POST['src_path']) ? "sonar.sources=". $_POST['src_path'] : ''; 
						 	}

						 	$lang = isset($_POST['lang']) ? $_POST['lang'] : ''; 
						 	$lang_txt = isset($_POST['lang']) ? "sonar.language=". $_POST['lang'] : ''; 

						 	if (isset($_POST['rdo_encode'])) {
								$src_encode = $_POST['rdo_encode'];
								$src_encode_txt = "sonar.sourceEncoding=". $_POST['rdo_encode'];
							}
							
							elseif (isset($_POST['rdo_encode'])) {
								$src_encode = $_POST['rdo_encode'];
								$src_encode_txt = "sonar.sourceEncoding=". $_POST['rdo_encode'];
							}

							if (!$nameErr && !$keyErr && !$repoLinkErr && !$srcPathErr) 
							{
								$proj_file_name= isset($_POST['proj_name']) ? $_POST['proj_name'] : ''; 
								$proj_file_name = preg_replace('/\s+/', '', $proj_file_name);
								//Writing to the project files list
								$proj_files_list = fopen("project_analysis/projects_list.properties", "a");
								fwrite($proj_files_list, $proj_file_name);
								fclose($proj_files_list);

								$path = fopen("project_analysis/$proj_file_name.properties", 'w');
								fwrite($path, $proj_name_txt ."\n");
								fwrite($path, $proj_key_txt ."\n");
								fwrite($path, $repo_link ."\n");
								fwrite($path, $src_path_txt ."\n");
								fwrite($path, $lang_txt ."\n");
								fwrite($path, $src_encode_txt ."\n");
								fclose($path); 

								//Creating XML file
								$download = 'N/A';
								$analyse = 'N/A';
								$dt_execute = '00/00/0000';

								//APPENDING TO A XML DOCUMENT
								$file = 'project_analysis/shedule.xml';
								$xml = simplexml_load_file($file) or die("Error: Cannot create object");

								$project = $xml->addChild('project');
								$project->addAttribute('key', $proj_name_compressed);

								$project->addChild('key', $proj_name_compressed); 
								$project->addChild('name', $proj_name); 
								$project->addChild('download', 'N/A'); 
								$project->addChild('analyse', 'N/A'); 
								$project->addChild('date_execute', '00/00/0000'); 
								//New fields to XML file
								$project->addChild('repo_link', $repo_link); 
								$project->addChild('repo_type', $_POST['rdo_repo']); 
								$project->addChild('src_path', $src_path); 
								$project->addChild('lang', $lang); 
								$project->addChild('src_encode',  $_POST['rdo_encode']);

								file_put_contents($file, $xml->asXml());

								//Validate data saving message
								$saved_msg = "Information Saved Successfully.";
							
								sleep(1);
								header('location:index.php');
							}
					}

					

				?>

				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">

					<h1 class="lblHeader"> Project Settings </h1>

					<?php $saved_msg = isset($saved_msg) ? $saved_msg : '' ; ?>

					<p> <span class="saved_msg"> <?php echo $saved_msg; ?></span> </p>
					<p class="form_elements">
						<label> Project Name </label>
						<input type="text" name="proj_name"> </input> <span class="error"> <?php echo $nameErr; ?> </span>
					</p>
					</p> 
					<p class="form_elements">
						<label> Repository Link </label>
						<input type="text" name="repo_link"> </input> <span class="error"> <?php echo $repoLinkErr; ?> </span>
					</p>
					<p class="form_elements">
						<label> Repository Type </label> 
						<input type="radio" name="rdo_repo" value="github" checked="true"> Github
						<input type="radio" name="rdo_repo" value="svn"> SVN
					</p>
					<p class="form_elements">
						<label> Source Folder </label>
						<?php $src_path = isset($src_path) ? $src_path: ''; ?>
						<input type="text" name="src_path"> </input>  <span style="font-size: 0.8em"> (Relative Path)eg: / SRC / Java / SRC2) </span>
						<span class="error"> <?php echo $srcPathErr; ?> </span>
					</p>
					<p class="form_elements">
						<label> Language </label>
						
						<select class="form-control" name="lang" style="width: 200px;">
							<option selected>Java</option>
							<option>C#</option>
							<option>Web</option>
						 </select>
					</p>
					<p class="form_elements">
						<label> Source Encoding </label>
						<input type="radio" name="rdo_encode" value="UTF-8" checked="true"> UTF-8
						<input type="radio" name="rdo_encode" value="Western"> Western
					</p>
					<p>
						<input id="submit" type="submit" name="submit_btn" value="Submit" class="btn btn-default">
					</p>
				</form>
			</div>
		</div>
	</div>

</body>

</html>