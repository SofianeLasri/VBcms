<?php
setcookie("login", $_POST["inputUser"], time()-3600);  /* supprime le cookie */
header('Location: login.php');
?>