
<div class="sidebar bg-light border-right">
	<div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action bg-light"><?php if(getParameters("language") == "fr"){echo "Accueil";}elseif (getParameters("language") == "en") {echo "Home";} ?></a>

        <a href="gallery.php" class="list-group-item list-group-item-action bg-light"><?php if(getParameters("language") == "fr"){echo "Galerie";}elseif (getParameters("language") == "en") {echo "Gallery";} ?></a>

        <?php if (themeFeatures("tips") == true) {?> <a href="tips.php" class="list-group-item list-group-item-action bg-light"><?php if(getParameters("language") == "fr"){echo "Astuces";}elseif (getParameters("language") == "en") {echo "Tips";} ?> <i class="fas fa-check-circle"></i></a> <?php } ?>

        <?php if (themeFeatures("alerts") == true) {?> <a href="alerts.php" class="list-group-item list-group-item-action bg-light"><?php if(getParameters("language") == "fr"){echo "Alertes";}elseif (getParameters("language") == "en") {echo "Alerts";} ?> <i class="fas fa-check-circle"></i></a> <?php } ?>

        <?php if (themeFeatures("dynamicBackgrounds") == true OR themeFeatures("staticBackground") == true) {?> <a href="backgrounds.php" class="list-group-item list-group-item-action bg-light"><?php if(getParameters("language") == "fr"){echo "Images de fond";}elseif (getParameters("language") == "en") {echo "Backgrounds";} ?> <i class="fas fa-check-circle"></i></a> <?php } ?>

        <a href="themes.php" class="list-group-item list-group-item-action bg-light"><?php if(getParameters("language") == "fr"){echo "Thèmes";}elseif (getParameters("language") == "en") {echo "Themes";} ?></a>
        <a href="settings.php" class="list-group-item list-group-item-action bg-light"><?php if(getParameters("language") == "fr"){echo "Paramètres généraux";}elseif (getParameters("language") == "en") {echo "Global settings";} ?></a>
        <?php
        if (getParameters("themeInclude") != "") {
            echo customSidebar();
        }
        ?>
    </div>
    <div class="fixed-bottom text-center" style="width: 15rem;">
    	VBcms <a class="text-dark" href="update.php">v<?=getParameters("version")?></a>
    </div>
</div>