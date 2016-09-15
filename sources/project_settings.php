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
				 	/* if (empty($_POST['proj_key'])) {
				 		$keyErr = "Project key required";
				 	}
				 	else{
				 		$proj_key = isset($_POST['proj_key']) ? "sonar.projectKey=". $_POST['proj_key'] : ''; 
				 	} */

				 	$proj_name_compressed = preg_replace('/\s+/', '', $_POST['proj_name']);
				 	$proj_key = isset($_POST['proj_name']) ? "sonar.projectKey=". $proj_name_compressed : ''; 

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
						$project->addChild('name', $_POST['proj_name']); 
						$project->addChild('download', 'N/A'); 
						$project->addChild('analyse', 'N/A'); 
						$project->addChild('date_execute', '00/00/0000'); 
						//New fields to XML file
						$project->addChild('repo_link', $_POST['repo_link']); 
						$project->addChild('repo_type', $_POST['rdo_repo']); 
						$project->addChild('src_path', $_POST['src_path']); 
						$project->addChild('lang', $_POST['lang']); 
						$project->addChild('src_encode', $_POST['rdo_encode']); 

						file_put_contents($file, $xml->asXml());


						//Validate data saving message
						//$saved_msg = "Information Saved Successfully.";

						sleep(1);
						header('location:index.php');

					}
				 }

				?>

				 <form role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">

				 	<?php
				 		$xml=simplexml_load_file('project_analysis/shedule.xml') or die("Error: Cannot create object");
				 			//$xml=simplexml_load_file('project_analysis/shedule.xml')
				 		if ((isset($_GET['action']) && $_GET['action']='update')) {
				 			$a = $_GET['no']; //echo $a;
				 			//echo $xml->project[0]->repo_type;
				 			$j=0;
				 			foreach ($xml->project as $project) {
				 				if ($a==$j) {
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




					<h1 class="lblHeader"> Project Settings </h1>

					<?php $saved_msg = isset($saved_msg) ? $saved_msg : '' ; ?>

					<p> <span class="saved_msg"> <?php echo $saved_msg; ?></span> </p>
					<p class="form_elements">
						<label> Project Name </label>
						<input type="text" name="proj_name" value="<?php echo $proj_name; ?>"> </input> <span class="error"> <?php echo $nameErr; ?> </span>
					</p>
					<!-- <p class="form_elements">
						<label> Project Key  </label>
						<input type="text" name="proj_key"> </input>  <span class="error"> <?php echo $keyErr; ?> </span>
					</p> -->
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
						<button type="submit" name="submit_btn" class="btn btn-default">Save</button> 
					</p>
				</form>
			</div>
		</div>
	</div>

</body>

</html>