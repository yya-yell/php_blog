<?php

    define('MYSQL_USER' , 'root');
    define('MYSQL_PASSWORD' , 'admin139');
    define('MYSQL_DBNAME' , 'php_blog');
    define('MYSQL_HOST' , 'localhost');

    $option = array(
        PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION,
    );

    $pdo = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DBNAME, MYSQL_USER,MYSQL_PASSWORD , $option);

?>