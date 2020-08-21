<?php
//Détection du naviguateur et récupération de l'ip
function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$browser = new Browser();
if( $browser->getBrowser() == (Browser::BROWSER_CHROME OR Browser::BROWSER_EDGE) && $browser->getVersion() >=19 ) {
	$oldWebBrowser = false; //Version non Chromium de Garry's Mod
} else {
	$oldWebBrowser = true; //Naviguateur & Version Chromium de Garry's Mod
}

?>

<!DOCTYPE html>
<html>
<head>
	<title><?=getParameters("siteName")?></title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="themes/<?=getParameters("theme")?>/assets/css/styles.css">
	<?php
	if ($oldWebBrowser == true) {
		echo ('<link rel="stylesheet" href="themes/'.getParameters("theme").'/assets/css/styles-legacy.css">');
		echo ('');
	}
	?>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
	<?php
	if ($oldWebBrowser == false) {
		echo('<style type="text/css">
		.background{
			filter: blur(8px);
  			-webkit-filter: blur(8px);
		}
	</style>');
	}
	?>
	<audio id="backMusic" preload="auto"></audio>
	<!-- Fond -->
	<div class="background"></div>
	<img class="serverLogo" src="<?=getParameters("serverLogo")?>">

	<div class="carboardbox" style="background-color: <?=getParameters("cbThirdColor")?>;">
		<div class="topCBB" style="background-color: <?=getParameters("cbMainColor")?>; color: <?=getParameters("cbWhite")?>;">
			<a><?=getParameters("cbText")?></a>
		</div>
		<div class="playerProfilPic" style="background-image: url(<?=$playerSteamPic?>); border-color: <?=getParameters("cbMainColor")?>"></div>
		<p class="playerName"><?=$playerSteamName?></p>
		<div class="serverInfos">
			<div class="leftPart"><img src="themes/<?=getParameters("theme")?>/assets/images/user.png"></div>
			<div class="rightPart" id="serverPlace" style="color: <?=getParameters("cbBlack")?>"></div>
		</div>
		<div class="serverInfos">
			<div class="leftPart"><img src="themes/<?=getParameters("theme")?>/assets/images/location.png"></div>
			<div class="rightPart" id="map" style="color: <?=getParameters("cbBlack")?>"></div>
		</div>
		<div class="serverInfos">
			<div class="leftPart"><img src="themes/<?=getParameters("theme")?>/assets/images/vr-gaming.png"></div>
			<div class="rightPart" id="gamemode" style="color: <?=getParameters("cbBlack")?>"></div>
		</div>
	</div>

	<script type="text/javascript">
		var backgroundImages = <?=getParameters("backgroundImages")?>;

		//1s = 1000 ms
		var timeBackChange = <?=getParameters("timeBackChange")?>;
		var playlist = <?=getParameters("musics")?>;

		//Permet de générer un nombre aléatoire entre 0 et un nombre défini
		function getRandomInt(max) {
			return Math.floor(Math.random() * Math.floor(max));
		}

		  ////////////////////////
		 // Partie backgrounds //
		////////////////////////
		var i = getRandomInt(backgroundImages.length); //Prend comme valeur le nombre d'éléments que contient la liste
        var b = 0; //Sera la variable temporaire pour vérifier que l'objet suivant ne sera pas le même
        $(".background").css("background-image", "url(admin/upload/" + backgroundImages[i] + ")");
        setInterval(function () {
            b = i;
            i = getRandomInt(backgroundImages.length);
            while (i == b) { //Tant que l'objet suivant sera le même, il génèrera un nouveau nombre
                i = getRandomInt(backgroundImages.length);
            }
            $(".background").fadeOut("slow", function () {
                $(this).css("background-image", "url(admin/upload/" + backgroundImages[i] + ")");
                $(this).fadeIn("slow");
            });
        }, timeBackChange);

        $(document).ready(function() {
	      var backMusic = document.getElementById("backMusic");
	      backMusic.volume = 0.3;
	      backMusic.controls = false;


	      function player(x) {
	        var i = 0;
	        backMusic.src = playlist[x]; // x is the index number of the playlist array 
	        backMusic.load();            // use the load method when changing src
	        backMusic.play();
	        backMusic.onended = function() { // Once the initial file is played it plays the rest of the files
	          /* This would be better as a 'for' loop */
	          i++;                   
	          if (i > 2) {            //         ... Repeat
	            i = 0;                //         ^
	          }                       //         ^
	          backMusic.src = playlist[i];   // Rinse,  ^
	          backMusic.load();              // Lather, ^
	          backMusic.play();              // and.....^
	        }
	      }
	      player(0); // Call the player() function at 0 index of playlist array
	    });

	    //Récupération des infos de la partie
	    function GameDetails( servername, serverurl, mapname, maxplayers, steamid, gamemode, volume, language ) {
	    	$("#map").html(mapname);
	    	$("#serverPlace").html(maxplayers);
	    	$("#gamemode").html(gamemode);
	    }
	</script>
</body>
</html>