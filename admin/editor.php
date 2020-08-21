<?php
if (!isset($_COOKIE["login"])) {
	header('Location: login.php');
	exit;
}
include 'includes/constants.php';

if (isset($_GET["type"])) {
  $action = "create";
  $btnValue = "create".$_GET["type"];
}

if (isset($_GET["id"]) AND (isset($_GET["type"]) AND ($_GET["type"] == "tip" OR $_GET["type"] == "alert"))) {
  if ($_GET["type"] == "tip") {
    $res=$bdd->query("SELECT * FROM posts WHERE id = ".$_GET["id"]);
    $result = $res->fetch();
    
  } elseif ($_GET["type"] == "alert") {
    $res=$bdd->query("SELECT * FROM alerts WHERE id = ".$_GET["id"]);
    $result = $res->fetch();
  }
  $action = "update";
  $btnValue = "update".$_GET["type"];
  $titre = $result["title"];
  $content = $result["description"];
  $id = $_GET["id"];
  $frontImage = $result["picPath"];
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=getParameters("siteName")?> | Editor</title>
	<link rel="icon" type="image/png" href="images/vbcms-logo-mini.png"/>

	<?php include 'includes/depedencies.php';?>

	<link rel="stylesheet" href="vendors/summernote/dist/summernote-lite.css">
	<script type="text/javascript" src="vendors/summernote/dist/summernote-lite.js"></script>
</head>
<body>
  <style type="text/css">
    .editorDiv{
      padding: 1vh;
    }
    .articleTitle{
      
      margin-bottom: 1vh;
    }
    .gallery{
      width: inherit;
      margin: 1vh;
    }
    .gallery img{
      width: 100%;
      border-radius: 10px;
    }
  </style>
	<?php include 'includes/navbar.php'; ?>
	<div class="d-flex">
		<?php include 'includes/sidebar.php'; ?>
		<div class="page-content container-fluid">
			<h1>Editor</h1>
			<p>Here you can create and edit text.</p>

      <form action = "editorSend.php" method = "POST">
        <input required class="input-group-text text-left my-1" type="text" name="articleName" <?php if(isset($action) AND $action == "update"){echo 'value="'.$titre.'"';} ?> placeholder="Title">
        <?php
        if (isset($_GET["type"]) AND $_GET["type"] != "alert") { ?>
         <button type="button" class="btn btn-primary btn-sm my-1" data-toggle="modal" data-target="#chooseMediaModal">Choose an illustration image</button>
         <input class="input-group-text text-left mb-2 my-1" type="text" id="frontImage" name="frontImage" <?php if(isset($action) AND $action == "update"){echo 'value="'.$frontImage.'"';} ?> placeholder="Image link">
        <?php } ?>
        <?php
        if (isset($_GET["type"]) AND $_GET["type"] == "alert") { ?>
         <input required class="input-group-text text-left my-1" type="text" id="alertDuration" name="alertDuration" <?php if(isset($action) AND $action == "update"){echo 'value="'.$frontImage.'"';} ?> placeholder="Alert duration (in ms)">
        <?php } ?>
        
        <?php if(isset($action) AND $action == "update"){echo '<input required class="input-group-text text-left my-1" type="text" id="articleId" name="articleId" value="'.$id.'">';} ?>

        <!-- Modal -->
        <div class="modal fade" id="chooseMediaModal" tabindex="-1" role="dialog" aria-labelledby="chooseMediaModalTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="chooseMediaModalTitle">Choose an image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <?php
              $res=$bdd->query("SELECT * FROM gallery ORDER BY id DESC");
              $result = $res->fetchAll();
              $count= count($result);
              if($count > 0){
                foreach( $result as $row ) {
                  $picPath = (getParameters("siteUrl")."admin/upload/".$row["1"]);
                  echo ('<div class="gallery d-flex flex-column"><img src="'.$picPath.'"><button class="btn btn-primary" onclick="changePath('."'".$picPath."'".')" id="chooseImageBtn" data-dismiss="modal">Choisir</button></div>');
                }
              } else {
                echo "Aucun média n'est encore ajouté. :(";
              }
              ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Fin du Modal -->

        <?php
        $res=$bdd->query("SELECT * FROM gallery");
        $count= count($res->fetchAll());
        if($count == 0){ ?>
          <div class="alert alert-warning border-0 alert-dismissible">
            <span class="font-weight-semibold">Hep hep hep!</span> It is better to have an image in stock. Check <a href="gallery.php" class="alert-link">here</a>.
            </div>
        <?php }
        ?>

  			<textarea required id="summernote" name="articleContent"><?php if(isset($action) AND $action == "update"){echo $content;}?></textarea>
        <button type="submit" name="submit" value="<?=$btnValue?>" class="btn btn-success  my-2"><?php if(isset($action) AND $action == "update"){echo 'Mettre à jour';}else{echo 'Créer';} ?></button>
      </form>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#summernote').summernote({
        placeholder: "Ceci est un texte.",
        tabsize: 2,
        height: 300,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['paragraph']],
          ['view', ['codeview', 'help']]
        ]
      });
		});
    function changePath(x) {
      console.log(arguments[0]);
      $("#frontImage").val(arguments[0]);
    }
	</script>
</body>
</html>