<?php
    require_once("../config/config.php");
    $stat = $pdo->prepare("DELETE FROM `users` WHERE id=".$_GET['id']);
    $stat->execute();
    header("location:user_mana.php");
?>