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
	<title><?=getParameters("siteName")?> | Admin</title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>
</head>
<body>
	<?php include 'includes/navbar.php'; ?>
	<div class="d-flex">
		<?php include 'includes/sidebar.php'; ?>
		<div class="page-content container-fluid">
			<img width="100px" src="images/vbcms-logo.png">
			<?php include getTranslation("index"); ?>
		</div>
	</div>
</body>
</html>