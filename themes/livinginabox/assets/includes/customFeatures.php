<?php
function customSidebar (){
	echo ('<a href="themeFeature.php?p=themeSettings" class="list-group-item list-group-item-action bg-light">Paramètres du thème</a>');
	echo ('<a href="themeFeature.php?p=importAssets" class="list-group-item list-group-item-action bg-light">Import theme asssets</a>');
}
function customPage($page){
	return "../themes/".getParameters("theme")."/assets/includes/".$page;
}
if (getParameters("cbMainColor") == null){
	$sql = "INSERT INTO settings (parameter, value) VALUES ('cbMainColor', ?), ('cbSecondaryColor', ?), ('cbThirdColor', ?), ('cbWhite', ?), ('cbBlack', ?), ('cbText', ?)";
	$bdd->prepare($sql)->execute(["#A67153", "#BF9780", "#F2D6B3", "#F2F2F2", "#262626", "Bienvenu sur mon serveur!"]);
}
?>