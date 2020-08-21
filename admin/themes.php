<?php
if (!isset($_COOKIE["login"])) {
	header('Location: login.php');
	exit;
}
include 'includes/constants.php';

if (isset($_GET["use"])) {
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'theme'";
	$bdd->prepare($sql)->execute([$_GET["use"]]);
	$themepath = "../themes/".$_GET["use"]."/theme.json";
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'themePath'";
	$bdd->prepare($sql)->execute([$themepath]);
	$themeJsonFileContents = file_get_contents($themepath);
	$themeJsonFileContents = json_decode($themeJsonFileContents);
	if ($themeJsonFileContents->include != "") {
		$themeInclude = "../themes/".$_GET["use"]."/".$themeJsonFileContents->include;
	} else {
		$themeInclude = $themeJsonFileContents->include;
	}
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'themeInclude'";
	$bdd->prepare($sql)->execute([$themeInclude]);
	header('Location: themes.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=getParameters("siteName")?> | Thèmes</title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>
</head>
<body>
	<?php include 'includes/navbar.php'; ?>
	<div class="d-flex">
		<?php include 'includes/sidebar.php'; ?>
		<div class="page-content container-fluid">
			<?php include getTranslation("themes"); ?>
			<div class="d-flex flex-wrap">
			<?php
			$themes = array_diff(scandir("../themes"), array('..', '.'));
			foreach ($themes as $isDir) {
				$isDir = "../themes/".$isDir;
				if (is_dir($isDir) == true) {
					$themeJSON = array_diff(scandir($isDir), array('..', '.'));
					foreach ($themeJSON as $isTheme) {
						if ($isTheme == "theme.json") {
							$theme = ($isDir."/".$isTheme);
							$themeJsonFileContents = file_get_contents($theme);
							$themeJsonFileContents = json_decode($themeJsonFileContents);
							echo ('<div class="card m-2" style="width: 18rem;">
									  <img src="'.$isDir.'/assets/images/themeTopImage.jpg" class="card-img-top" alt="...">
									  <div class="card-body">
									    <h5 class="card-title">'.$themeJsonFileContents->showname.'</h5>
									    <p class="card-text">'.$themeJsonFileContents->description.'</p>
									    <a href="themes.php?use='.$themeJsonFileContents->name.'" class="btn btn-primary">Utiliser</a>
									  </div>
									</div>');
						}
					}
				}
			}
			?>
			</div>
		</div>
	</div>
</body>
</html>