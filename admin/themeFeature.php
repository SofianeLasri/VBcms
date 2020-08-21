<?php
if (!isset($_COOKIE["login"])) {
	header('Location: login.php');
	exit;
}
include 'includes/constants.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=getParameters("siteName")?> | Fonction du thème</title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>
</head>
<body>
	<?php include 'includes/navbar.php'; ?>
	<div class="d-flex">
		<?php include 'includes/sidebar.php';

		if (getParameters("themeInclude") != "") {
			include customPage($_GET["p"]);
		}else {
			echo ('<div class="page-content container-fluid">
					<h1>Oh oh :(</h1>
					<p>Il semblerait que le thème utilisé ne possède pas de page personnalisé. :(</p>
				</div>');
		}

		?>
	</div>
</body>
</html>