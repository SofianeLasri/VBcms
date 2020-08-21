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
	<title><?=$siteInfos[0]?> | 404</title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>
</head>
<body>
	<?php include 'includes/navbar.php'; ?>
	<div class="d-flex">
		<?php include 'includes/sidebar.php'; ?>
		<div class="page-content container-fluid">
			<h1>Mayday! Nous avons perdu le contact!</h1>
			<p>Il semblerait que tu te sois perdu. :/</p>
		</div>
	</div>
</body>
</html>