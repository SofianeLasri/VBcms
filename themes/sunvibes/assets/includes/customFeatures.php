<?php
function customSidebar (){
	/*echo ('<a href="themeFeature.php?p=themeSettings" class="list-group-item list-group-item-action bg-light">Paramètres du thème</a>');*/
	echo ('<a href="themeFeature.php?p=importAssets" class="list-group-item list-group-item-action bg-light">Import theme asssets</a>');
}
function customPage($page){
	return "../themes/".getParameters("theme")."/assets/includes/".$page;
}
?>