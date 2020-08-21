<?php
if (!isset($_COOKIE["login"])) {
	header('Location: login.php');
	exit;
}
include 'includes/constants.php';

if (isset($_GET["deletetip"])) {
	$sql = $bdd->prepare( "DELETE FROM posts WHERE id =:id" );
	$sql->bindParam(':id', $_GET["deletetip"]);
	$sql->execute();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=getParameters("siteName")?> | Tips</title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>
</head>
<body>
	<?php include 'includes/navbar.php'; ?>
	<div class="d-flex">
		<?php include 'includes/sidebar.php'; ?>
		<div class="page-content container-fluid">
			<h1><?php if(getParameters("language") == "fr"){echo "Liste des astuces";}elseif (getParameters("language") == "en") {echo "Tips List";} ?></h1>
			<p><?php if(getParameters("language") == "fr"){echo "Tu peux les modifier individuellement. Pense à en mettre plusieurs! :D";}elseif (getParameters("language") == "en") {echo "You can modify them individually. Remember to put several! :D";} ?></p>
			<?php
			if (isset($_GET["success"])) {
				echo ('<div class="alert alert-success" role="alert">Tip créé avec succès!</div>');
			}
			?>
			<a href="editor.php?type=tip" class="btn btn-success"><?php if(getParameters("language") == "fr"){echo "Créer une nouvelle astuce";}elseif (getParameters("language") == "en") {echo "Create new tip";} ?></a>
			<div class="d-flex flex-wrap">
				<?php 
				$res=$bdd->query("SELECT * FROM posts");
				$result = $res->fetchAll();
				foreach($result as $row) {
					if ($row["picPath"] != "") {
						$find = strpos($row["picPath"], "http");
						if ($find === false) {
						    $picPath = (getParameters("siteUrl").$row["picPath"]);
						} else{
							$picPath = $row["picPath"];
						}
					}
					?>
					<!-- Carte tip -->
					<div class="card m-2" style="width: 18rem;">
						<?php if($row["picPath"] != ""){echo ('<img src="'.$picPath.'" class="card-img-top" alt="...">');}?>
						<div class="card-body">
					    	<h5 class="card-title"><?=$row["title"]?></h5>
					    	<p class="card-text"><?=$row["description"]?></p>
					    	<a href="editor.php?type=tip&id=<?=$row["id"]?>" class="btn btn-primary"><?php if(getParameters("language") == "fr"){echo "Modifier";}elseif (getParameters("language") == "en") {echo "Modify";} ?></a>
					    	<a href="tips.php?deletetip=<?=$row["id"]?>" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
					 	</div>
					</div>
					<!-- /carte tip -->
				<?php }	?>
			</div>
		</div>
	</div>
</body>
</html>