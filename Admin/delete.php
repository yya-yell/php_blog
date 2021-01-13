<?php
require_once("../config/config.php");
$statement = $pdo->prepare("DELETE FROM `post` WHERE id=". $_GET[id]);
$statement->execute();
header("location: index.php");
?>