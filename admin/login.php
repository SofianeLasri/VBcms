<?php
$admin = true;
include 'includes/config.php';
if (!is_writable("includes/config.php")) {
    $errorMessage = ('<div class="alert alert-danger" role="alert">Configuration file is note writable!</div>');
}
if (isset($installed) AND ($installed == true)) {
	$installed = true;
	$title = "Connexion";
	include 'includes/bdd.php';
} else {
	$installed = false;
	$title = "Installation";
}

if (isset($_COOKIE["login"])) {
  header('Location: index.php');
}

if (isset($_POST["inputUser"]) AND ($installed == false)) {

	//Écriture du fichier config
	$bddhost_str = var_export($_POST["inputBddHost"], true);
	$bdduser_str = var_export($_POST["inputBddUser"], true);
	$bddpass_str = var_export($_POST["inputBddPass"], true);
	$bddname_str = var_export($_POST["inputBddName"], true);
	$var = ("<?php\n".'$bddHost = '.$bddhost_str.";\n".'$bddUser = '.$bdduser_str.";\n".'$bddMdp = '.$bddpass_str.";\n".'$bddName = '.$bddname_str.";\n\n".'$installed = true;'."\n\n".'error_reporting(0); //désactive les messages derreur'."\n?>");
	file_put_contents('includes/config.php', $var);
	include 'includes/bdd.php';

	//Création des tables
	$bdd->exec("CREATE TABLE IF NOT EXISTS users ( id INT NOT NULL AUTO_INCREMENT , name VARCHAR(32) NOT NULL , password VARCHAR(64) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB;");
	$bdd->exec("CREATE TABLE IF NOT EXISTS posts ( id INT NOT NULL AUTO_INCREMENT , title VARCHAR(128) NOT NULL , description VARCHAR(512) NOT NULL , picPath VARCHAR(512) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB;");
	$bdd->exec("CREATE TABLE IF NOT EXISTS alerts ( id INT NOT NULL AUTO_INCREMENT , title VARCHAR(128) NOT NULL , description VARCHAR(512) NOT NULL , duration INT NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB;");
	$bdd->exec("CREATE TABLE IF NOT EXISTS settings ( parameter VARCHAR(128) NOT NULL , value VARCHAR(512) NOT NULL , PRIMARY KEY (parameter)) ENGINE = InnoDB;");
	$bdd->exec("CREATE TABLE IF NOT EXISTS gallery ( id INT NOT NULL AUTO_INCREMENT , path VARCHAR(512) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB;");

	//Insertion des info du formulaire
	$hashed_password = crypt($_POST["inputPassword"]);
	$sql = "INSERT INTO users (id, name, password) VALUES (?,?,?)";
	$bdd->prepare($sql)->execute([NULL, $_POST["inputUser"], $hashed_password]);

	$sql = "INSERT INTO settings (parameter, value) VALUES ('siteName', ?), ('siteUrl', ?), ('timeBackChange', ?), ('timePostChange', ?), ('musics', ?), ('backgroundImages', ?), ('version', ?), ('theme', ?), ('themePath', ?), ('themeInclude', ?), ('serverLogo', ?), ('serverIp', ?), ('steamAPIkey', ?), ('language', ?)";
	$bdd->prepare($sql)->execute([$_POST["inputSiteName"], $_POST["inputUrl"], 5000, 7000, "[]", "[]", "1.2d", "demo", "../themes/demo/theme.json", "", "", $_POST["inputServerIp"], $_POST["inputSteamAPIkey"], $_POST["language"]]);

	header('Location: login.php');
} elseif (isset($_POST["inputUser"]) AND ($installed == true)) {
	include 'includes/constants.php';
	if (getParameters("version") != "1.2d") {
		$sql = "UPDATE settings SET value = ? WHERE parameter = 'version'";
		$bdd->prepare($sql)->execute(["1.2d"]);
	}
	$res=$bdd->query("SELECT * FROM users WHERE name = '".$_POST["inputUser"]."'");
	$result = $res->fetch();
	if ($result["password"] != "") {
		if (hash_equals($result["password"], crypt($_POST["inputPassword"], $result["password"]))) {
			setcookie("login", $_POST["inputUser"], time()+3600);  /* expire dans 1 heure */
			header('Location: index.php');
			exit;
		} else {
			$errorMessage = ('<div class="alert alert-danger" role="alert">Mauvais couple mot de passe/identifiant</div>');
		}
	} else {
		$errorMessage = ('<div class="alert alert-danger" role="alert">Mauvais couple mot de passe/identifiant</div>');
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>
</head>
<body>
	<style type="text/css">
		body{
			background-image: url("images/black-back-pattern-10.jpg");
		}
	</style>
	<div class="loginCard mx-auto mt-5 rounded d-flex flex-column">
		<div class="m-2 text-center">
			<img class="w-25" src="images/vbcms-logo.png">
		</div>
		<div class="d-flex m-2 flex-column">
			<h1><?=$title?></h1>
			<form method="post" action="login.php">
			<?php
			if (isset($errorMessage)) {
				echo $errorMessage;
			}
			if ($installed == false) {?>
				<h3>Language</h3>
				<div class="form-group">
					<select class="form-control" name="language">
						<option value="fr">Français</option>
						<option value="en">English (may be incomplete)</option>
					</select>
				</div>
			
			
			<h3>Connexion à la base de données</h3>
				<div class="form-group">
					<div class="form-label-group">
						<label for="inputBddHost">Adresse du serveur (souvent localhost)</label>
						<input type="text" id="inputBddHost" name="inputBddHost" class="form-control" value="<?=$bddHost?>" placeholder="localhost" required="required" autofocus="autofocus">
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group">
						<label for="inputBddUser">Utilisateur de la base</label>
						<input type="text" id="inputBddUser" name="inputBddUser" class="form-control" value="<?=$bddUser?>" placeholder="bdd_user" required="required" autofocus="autofocus">
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group">
						<label for="inputBddPass">Mot de passe de l'utilisateur</label>
						<input type="password" id="inputBddPass" name="inputBddPass" class="form-control" value="<?=$bddMdp?>" placeholder="testr0pl3nt!" required="required" autofocus="autofocus">
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group">
						<label for="inputBddName">Nom de la base</label>
						<input type="text" id="inputBddName" name="inputBddName" class="form-control" value="<?=$bddName?>" placeholder="bdd_name" required="required" autofocus="autofocus">
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group">
						<label for="inputSiteName">Nom du site</label>
						<input type="text" id="inputSiteName" name="inputSiteName" class="form-control" placeholder="Site de Gordon" required="required">
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group">
						<label for="inputUrl">Url du site (avec un / à la fin)</label>
						<input type="text" id="inputUrl" name="inputUrl" class="form-control" placeholder="https://gordonfreeman.blackmesa.us/" required="required">
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group">
						<label for="inputServerIp">IP du serveur (optionnel)</label>
						<input type="text" id="inputServerIp" name="inputServerIp" class="form-control" placeholder="ip du serveur">
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group">
						<label for="inputSteamAPIkey">Steam API key (voir <a href="https://steamcommunity.com/dev/apikey">ce lien</a>) (optionnel)</label>
						<input type="text" id="inputSteamAPIkey" name="inputSteamAPIkey" class="form-control" placeholder="clé steam API" >
					</div>
				</div>
				<h3>Création de l'utilisateur</h3>
			<?php } ?>
				<div class="form-group">
					<div class="form-label-group">
						<label for="inputUser">Nom d'utilisateur</label>
						<input type="text" id="inputUser" name="inputUser" class="form-control" placeholder="GordonFreeman" required="required" autofocus="autofocus">
					</div>
				</div>
				<div class="form-group">
					<div class="form-label-group">
						 <label for="inputPassword">Mot de passe</label>
						<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="tut@password" required="required">
					 
					</div>
				</div>
				
				<button type="submit" class="btn btn-primary btn-block"><?=$title?></button>
		</form>
		</div>
	</div>
	<p class="text-center text-muted">VBCMS par <a href="https://sl-projects.com" target="_blank">SofianeLasri</a></p>
</body>
</html>