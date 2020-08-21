<?php
if (!isset($_COOKIE["login"])) {
	header('Location: login.php');
	exit;
}
include 'includes/constants.php';

if (isset($_GET['deleteMedia'])) {
	$id = $_GET['deleteMedia'];
	$res=$bdd->query("SELECT * FROM gallery WHERE id = ".$id);
	$result = $res->fetch();
	$sql = $bdd->prepare( "DELETE FROM gallery WHERE id =:id" );
	$sql->bindParam(':id', $id);
	$sql->execute();
	unlink('upload/'.$result["path"]);
	header("Location: gallery.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=getParameters("siteName")?> | Gallerie</title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>

	<!-- dropzone -->
	<link rel="stylesheet" href="vendors/dropzone-5.7.0/dist/dropzone.css">
	<script src="vendors/dropzone-5.7.0/dist/dropzone.js"></script>
</head>
<body>
	<style type="text/css">
		.gallery{
		}
		.gallery img{
			width: 25vw;
			border-radius: 10px;
			margin: 1vw;
		}
	</style>
	<?php include 'includes/navbar.php'; ?>
	<div class="d-flex">
		<?php include 'includes/sidebar.php'; ?>
		<div class="page-content container-fluid">
			<?php include getTranslation("gallery"); ?>
		</div>
	</div>
	<script type="text/javascript" src="js/drag-config.js"></script>
</body>
</html>