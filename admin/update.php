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
			<h1><?php if(getParameters("language") == "fr"){echo "Mettre à jour VBcms";}elseif (getParameters("language") == "en") {echo "Update VBcms";} ?></h1>
			<p>Réfère-toi à la <a href="https://vbcms.net/doc-update.php">documentation</a> pour mettre à jour.<br>
			<b>v<?=getParameters("version")?></b> par <a href="https://sl-projects.com/">SofianeLasri</a></p>

			
			<?php
			if ($currentVJSON != "false") {
				if (($currentVDate<$newVDate) == true) { ?>

			<div class="fullwidthContainer rounded p-2 d-flex">
				<div class="flex-grow-1">
					<h1>Mise à jour <?=$newVInfo->version?></h1>
					<h4 class='mt-n2'><?=$newVDate->format('Y/m/d')?></h4>
					<p><?=$newVInfo->changelog?></p>
					<br><a href="https://vbcms.net/update.php?ver=<?=getParameters("version")?>" target="_blank">En savoir plus</a>
				</div>
				<div class="align-self-center">
					<h5>À extraire à la racine!</h5>
					<a class="btn btn-success" href="<?=$newVInfo->downloadLink?>" target="_blank">Télécharger le fichier de mise à jour</a>
				</div>
			</div>
				<?php } else {
					echo "Vous possédez la dernière version. :D";
				}

				echo "<br><br><h2>Version actuelle | ".getParameters("version")."</h2>";
				echo "<h4 class='mt-n2'>".$currentVDate->format('Y/m/d')."</h4>";
				echo ($currentVInfo->changelog);
				echo "<br><a href='https://vbcms.net/update.php?ver=".getParameters("version")."' target='_blank'>En savoir plus</a>";

			} else {
				echo "Vous disposez d'une version non officielle. :/";
			}
			?>
		</div>
	</div>
</body>
</html>