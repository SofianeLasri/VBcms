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

//Récupération du contenu depuis la base de donnée
$backgroundImage = json_decode(getParameters("backgroundImages"));

  ////////////////////////////////
 // Récupère les posts/Astuces //
////////////////////////////////
$res=$bdd->query("SELECT * FROM posts");
$result = $res->fetchAll();
$loadingPostsText = array(); //Création d'une liste
$loadingPostsImages = array(); //Idem
foreach ( $result as $row ) {; //Boucle qui s'éxecute à chaque post/Astuce
	array_push($loadingPostsText, "<h1>".$row[1]."</h1>".$row[2]); //Assemble le titre et le texte du post/astuce (j'allais pas créer une variable juste pour le titre mdr)
	array_push($loadingPostsImages, $row[3]); //Créé un item contenu l'image du post/Astuce, c'est dans le même ordre
}
$loadingPostsText = json_encode($loadingPostsText); //Encode en JSON pour pouvoir récupérer la variable plus bas
$loadingPostsImages = json_encode($loadingPostsImages); //Idem
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
	<audio id="backMusic" preload="auto"></audio>
	<!-- Fond -->
	<div class="background"></div>
	<img class="serverLogo" src="<?=getParameters("serverLogo")?>">


	<div class="content">
		<div class="postText"></div>
		<div class="postImage"></div>
	</div>

	<div class="rightBottom">
		<div class="gmodLoadingBar"></div>
	</div>

	<script type="text/javascript">
		var backgroundImages = <?=getParameters("backgroundImages")?>;

		//1s = 1000 ms
		var timeBackChange = <?=getParameters("timeBackChange")?>;
		var timePostChange = <?=getParameters("timePostChange")?>;

		//Il est important de mettre le même nombre d'images que de tips, et dans le bon ordre.
		var loadingPostsText = <?=$loadingPostsText?>;

		var loadingPostsImages = <?=$loadingPostsImages?>;

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

		  //////////////////////////
		 // Partie Posts/astuces //
		//////////////////////////
		var o = getRandomInt(loadingPostsText.length); //Prend comme valeur le nombre d'éléments que contient la liste
	    var c = 0; //Sera la variable temporaire pour vérifier que l'objet suivant ne sera pas le même

	    <?php
	    if ($oldWebBrowser == true) { ?>
	    $(".postText").html("<h1>Hep hep hep!</h1><p>Il semblerait que tu n'utilises pas la Bêta Chromium de Garry's Mod!<br>Le naviguateur intégré de la version par défaut se fait très vieux (2012). <br><br>La plupart des fonction de style utilisées aujourd'hui sont incompatible, et certains éléments risquent de ne pas s'afficher correctement. Penses à faire le changement!</p>");
	    $(".postImage").css("background-image", "url(themes/<?=getParameters("theme")?>/assets/images/postAwesomium.jpg)");
	    <?php } else { ?>
	    $(".postText").html(loadingPostsText[0]);
	    $(".postImage").css("background-image", "url("+loadingPostsImages[0]+")");
	    <?php } ?>
	    
	    setInterval(function () {
            c = o;
            o = getRandomInt(loadingPostsText.length);
            while (o == c) { //Tant que l'objet suivant sera le même, il génèrera un nouveau nombre
                o = getRandomInt(loadingPostsText.length);
            }

            $(".postText").fadeOut("slow", function () {
                $(".postText").html(loadingPostsText[c]);
                $(".postImage").css("background-image", "url("+loadingPostsImages[c]+")");
                $(this).fadeIn("slow");
            });

        }, timePostChange);

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

        
	</script>
</body>
</html>