<?php
include 'includes/bdd.php';
if (isset($_POST["submit"])) {
	if ($_POST["submit"] == "createtip") {
		$sql = "INSERT INTO posts (id, title, description, picPath) VALUES (?,?,?,?)";
		$bdd->prepare($sql)->execute([null, $_POST["articleName"], $_POST["articleContent"], $_POST["frontImage"]]);
		header('Location: tips.php?success');
	} elseif ($_POST["submit"] == "updatetip") {
		$id = $_POST["articleId"];
		$sql = "UPDATE posts SET title=?, description=?, picPath=? WHERE id = ?";
		$bdd->prepare($sql)->execute([$_POST["articleName"], $_POST["articleContent"], $_POST["frontImage"], $_POST["articleId"]]);
		header('Location: tips.php?success');
	} elseif ($_POST["submit"] == "createalert") {
		$sql = "INSERT INTO alerts (id, title, description, duration) VALUES (?,?,?,?)";
		$bdd->prepare($sql)->execute([null, $_POST["articleName"], $_POST["articleContent"], $_POST["alertDuration"]]);
		header('Location: alerts.php?success');
	} elseif ($_POST["submit"] == "updatealert") {
		$id = $_POST["articleId"];
		$sql = "UPDATE alerts SET title=?, description=?, duration=? WHERE id = ?";
		$bdd->prepare($sql)->execute([$_POST["articleName"], $_POST["articleContent"], $_POST["alertDuration"], $_POST["articleId"]]);
		header('Location: alerts.php?success');
	}
}
?>