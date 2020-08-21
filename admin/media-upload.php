<?php
include ('includes/bdd.php');
$ds          = DIRECTORY_SEPARATOR;
 
$storeFolder = 'upload';
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name']; 

    $sql = "INSERT INTO gallery (id, path) VALUES (?,?)";
	$bdd->prepare($sql)->execute([NULL, $_FILES['file']['name']]);
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
     
    $targetFile =  $targetPath. $_FILES['file']['name'];

    
 
    move_uploaded_file($tempFile,$targetFile);
     
}
?>