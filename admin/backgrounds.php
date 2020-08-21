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
	<title><?=getParameters("siteName")?> | Backgrounds</title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>
</head>
<body>
	<style type="text/css">
		.gallery img {
		    width: 100%;
		}
		.gallery2 img{
			width: 25vw;
			border-radius: 10px;
			margin: 1vw;
		}
	</style>
	<?php include 'includes/navbar.php'; ?>
	<?php include getTranslation("backgrounds"); ?>
</body>
</html>