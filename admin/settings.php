<?php
if (!isset($_COOKIE["login"])) {
	header('Location: login.php');
	exit;
}
include 'includes/constants.php';

if (isset($_POST["submit"])) {
	//Modification des paramètres
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'siteName'";
	$bdd->prepare($sql)->execute([$_POST["inputSiteName"]]);
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'siteUrl'";
	$bdd->prepare($sql)->execute([$_POST["inputUrl"]]);
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'timeBackChange'";
	$bdd->prepare($sql)->execute([$_POST["inputTimeBackChange"]]);
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'timePostChange'";
	$bdd->prepare($sql)->execute([$_POST["inputPostChange"]]);
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'musics'";
	$bdd->prepare($sql)->execute([$_POST["inputMusic"]]);
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'serverLogo'";
	$bdd->prepare($sql)->execute([$_POST["serverLogo"]]);
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'serverIp'";
	$bdd->prepare($sql)->execute([$_POST["inputServerIp"]]);
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'steamAPIkey'";
	$bdd->prepare($sql)->execute([$_POST["inputSteamAPIkey"]]);
	$sql = "UPDATE settings SET value = ? WHERE parameter = 'language'";
	$bdd->prepare($sql)->execute([$_POST["language"]]);

	//Actualisation de la page
	header('Location: settings.php?success');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=getParameters("siteName")?> | Paramètres</title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>
</head>
<body>
	<style type="text/css">
		.gallery{
	      width: inherit;
	      margin: 1vh;
	    }
	    .gallery img{
	      width: 100%;
	      border-radius: 10px;
	    }
	</style>
	<?php include 'includes/navbar.php'; ?>
	<div class="d-flex">
		<?php include 'includes/sidebar.php'; ?>
		<div class="page-content container-fluid">
			<?php include getTranslation("settings"); ?>
			<!-- Modal -->
	        <div class="modal fade" id="chooseServerLogo" tabindex="-1" role="dialog" aria-labelledby="chooseServerLogoTitle" aria-hidden="true">
	          <div class="modal-dialog" role="document">
	            <div class="modal-content">
	              <div class="modal-header">
	                <h5 class="modal-title" id="chooseServerLogoTitle">Choisir une image</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true">&times;</span>
	                </button>
	              </div>
	              <div class="modal-body">
	              <?php
	              $res=$bdd->query("SELECT * FROM gallery ORDER BY id DESC");
	              $result = $res->fetchAll();
	              $count= count($result);
	              if($count > 0){
	                foreach( $result as $row ) {
	                  $picPath = (getParameters("siteUrl")."admin/upload/".$row["1"]);
	                  echo ('<div class="gallery d-flex flex-column"><img src="'.$picPath.'"><button class="btn btn-primary" onclick="changePath('."'".$picPath."'".')" id="chooseImageBtn" data-dismiss="modal">Choisir</button></div>');
	                }
	              } else {
	                echo "Aucun média n'est encore ajouté. :(";
	              }
	              ?>
	              </div>
	              <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
	              </div>
	            </div>
	          </div>
	        </div>
	        <!-- Fin du Modal -->
		</div>
	</div>

	<script type="text/javascript">
		function changePath(x) {
	      console.log(arguments[0]);
	      $("#serverLogo").val(arguments[0]);
	    }
	</script>
</body>
</html>