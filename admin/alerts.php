<?php
if (!isset($_COOKIE["login"])) {
	header('Location: login.php');
	exit;
}
include 'includes/constants.php';

if (isset($_GET["deletealert"])) {
	$sql = $bdd->prepare( "DELETE FROM alerts WHERE id =:id" );
	$sql->bindParam(':id', $_GET["deletealert"]);
	$sql->execute();
}
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
			<h1>Alertes</h1>
			<p>Utiles pour avertir tes joueurs.</p>
			<?php
			if (isset($_GET["success"])) {
				echo ('<div class="alert alert-success" role="alert">alerte créée avec succès!</div>');
			}
			?>
			<a href="editor.php?type=alert" class="btn btn-success">Créer une nouvelle alerte</a>
			<div class="d-flex flex-wrap">
				<?php 
				$res=$bdd->query("SELECT * FROM alerts");
				$result = $res->fetchAll();
				foreach($result as $row) {
					?>
					<!-- Carte alert -->
					<div class="card m-2" style="width: 18rem;">
						<div class="card-body">
					    	<h5 class="card-title"><?=$row["title"]?></h5>
					    	<p class="card-text"><?=$row["description"]?></p>
					    	<a href="editor.php?type=alert&id=<?=$row["id"]?>" class="btn btn-primary">Modifier</a>
					    	<a href="alerts.php?deletealert=<?=$row["id"]?>" class="btn btn-danger"><i class="far fa-trash-alt"></i></a> - <b><?=$row["duration"]?> ms</b>
					 	</div>
					</div>
					<!-- /carte alert -->
				<?php }	?>
			</div>
		</div>
	</div>
</body>
</html>