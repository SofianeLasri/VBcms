<?php
include 'bdd.php';

if ($installed == true) { //vérifie si VBcms est installé


function getParameters ($parm){
	include 'bdd.php';
	$result = $bdd->query("SELECT value FROM settings WHERE parameter ='".$parm."'");
	$siteInfos = $result->fetch();
	return $siteInfos[0];
}
function themeFeatures ($feature){
    $themeJsonFileContents = file_get_contents(getParameters("themePath"));
    $themeJsonFileContents = json_decode($themeJsonFileContents);
    if (in_array($feature, $themeJsonFileContents->features)) {
        return true;
    } else {
        return false;
    } 
}
function getTranslation ($file){
	$path = "includes/translations/".getParameters("language")."/".$file;
	return $path;
}
function uploadfiles ($fileUrl){
	$ch = curl_init($fileUrl); 
	$dir = './upload/';
	$file_name = basename($fileUrl); 
	$save_file_loc = $dir . $file_name; 
	$fp = fopen($save_file_loc, 'wb'); 
	curl_setopt($ch, CURLOPT_FILE, $fp); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_exec($ch); 
	curl_close($ch);
	fclose($fp); 
}

if (getParameters("themeInclude") != "") {
	include getParameters("themeInclude");
}

if (isset($_GET["steamid"])) {
	$playerSteamInfo = simplexml_load_file("http://steamcommunity.com/profiles/".$_GET["steamid"]."/?xml=1");
	$playerSteamName = $playerSteamInfo->steamID;
	$playerSteamPic = $playerSteamInfo->avatarFull;
}

if (getParameters("serverIp") != null) {
	include 'SourceQuery.php';
	$serverInfos = new SourceQuery(getParameters("serverIp"), 27015);
	$serverInfos  = $serverInfos->getInfos();
}

}//Fin de la condition

?>
