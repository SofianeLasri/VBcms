<?php
include 'admin/includes/config.php';

if ($installed == false) {
	include 'admin/includes/notinstalled.php';
} else {
	include 'admin/includes/constants.php';
	require 'admin/includes/browser-check.php';
	$browser = new Browser();
	if( $browser->getBrowser() == Browser::BROWSER_CHROME && $browser->getVersion() >=19 ) {
		$oldWebBrowser = false;
	} else {
		$oldWebBrowser = true;
	}

	$themeJsonFileContents = file_get_contents("themes/".getParameters("theme")."/theme.json");
	$themeJsonFileContents = json_decode($themeJsonFileContents);
	include ('themes/'.getParameters("theme")."/".$themeJsonFileContents->index);
}

?>
