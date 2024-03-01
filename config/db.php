<?php 

$host = "localhost";
$dbname = "chat-app";
$dbuser = "root";
$dbpwd = "";

$db = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpwd);

if (!$db) {
  echo "DB connect fail!";
}