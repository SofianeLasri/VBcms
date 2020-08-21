<?php
function customSidebar (){
	echo ('<a href="themeFeature.php?p=feature1" class="list-group-item list-group-item-action bg-light">test</a>');
}
function customPage($page){
	return "../themes/demo/assets/includes/".$page;
}
?>