<?php
/*
This file is created by ZeHua Yan

Purpose of this file: create my own style db connection 
*/

include_once($_SERVER['DOCUMENT_ROOT'] . "/dashboard-framework-v1/Config.php");

$dbConfig = new Config();

# mysqli_connect(host,username,password,dbname,port,socket);
$mysqli = mysqli_connect($dbConfig->server_name, $dbConfig->username, $dbConfig->password, $dbConfig->db_name, $dbConfig->port);

// Check connection
if (!$mysqli) {
    die("Connection failed: %s\n". mysqli_connect_error());
    exit();
} else {
    
}
