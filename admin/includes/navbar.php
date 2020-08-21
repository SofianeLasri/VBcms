<?php
$format = 'Y-m-d H:i:s';

$currentVJSON = file_get_contents('https://vbcms.sl-projects.com/getupdate.php?version='.getParameters("version"));
if ($currentVJSON != "false") {
	$currentVInfo = json_decode($currentVJSON);
	$currentVDate = $currentVInfo->date;
	$currentVDate = DateTime::createFromFormat($format, $currentVDate);

	$newVJSON = file_get_contents('https://vbcms.sl-projects.com/getupdate.php?lastest');
	$newVInfo = json_decode($newVJSON);
	$newVDate = $newVInfo->date;
	$newVDate = DateTime::createFromFormat($format, $newVDate);

	if (($currentVDate<$newVDate) == true) {
		$anUpdateIsAvailable = true;
	}
}
?>
<!-- Image and text -->
<nav class="navbar navbar-light">
	<a class="navbar-brand" href="index.php">
		<img src="./images/vbcms-logo-mini.png" width="30" height="30" class="d-inline-block align-top" alt="">
		VBcms
	</a>
	<div class="form-inline my-2 my-lg-0">
		<?php if(isset($serverInfos) AND ($serverInfos == "")){ echo('<span class="badge badge-danger">Votre serveur semble éteint</span>');} ?>
		<a class="text-white mx-2" href="update.php"><i class="fas fa-sync"></i> <?php if(isset($anUpdateIsAvailable)){ echo('<span class="badge badge-danger">New update available!</span>');} ?></a>
		<button class="btn btn-outline-light disconnectButton my-2 my-sm-0" onclick="window.location.href='logout.php'"><?php if(getParameters("language") == "fr"){echo "Se déconnecter";}elseif (getParameters("language") == "en") {echo "Disconnect";} ?></button>
    </div>
</nav>