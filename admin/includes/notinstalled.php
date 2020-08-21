<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>VBcms n'est pas intallé</title>
	<link rel="icon" type="image/png" href="admin/images/vbcms-logo-mini.png" />
	<link rel="stylesheet" type="text/css" href="admin/css/fonts.css">
</head>
<body>
	<style type="text/css">
		body{
			background-image: url("admin/images/black-back-pattern-10.jpg");
			color: white;
		}
		.centerDiv{
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			margin: auto;
			width: 50%;
			height: 30%;

			display: flex;
			flex-direction: column;
			align-items: center;
			text-align: center;
			font-family: "LTKaliber Bold";
			color: white;
			font-size: 1.5em;
		}
		.centerDiv img{
			width: 20%;
		}
		.btn{
			background: #ed1c24;
			border-radius: 10px;
			padding: 20px 45px;
			color: #ffffff;
			display: inline-block;
			font: normal bold 26px/1 "LTKaliber Bold";
			text-align: center;
		}
		a{
			text-decoration: none;
		}
	</style>
	<div class="centerDiv">
		<img src="admin/images/vbcms-logo-dark.png">
		<p>Oh oh... Le panel ne semble pas être installé.<br>
		Rejoins la page de Connexion.</p>
		<a class="btn" href="admin/login.php">Installer VBcms</a>
	</div>
</body>
</html>