<?php
  $sName = "localhost";
  $uName = "root";
  $pass = "";
  $db_name = 'online_book_store_db';

  
  try{
    $conn = new PDO("mysql:host =$sName ;dbname=$db_name", $uName, $pass );
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
  } catch(\PDOException $e) {
    echo "Connection failed: " .$e -> getMessage();
    echo "nottt";
    
  } 
/*
  $conn = mysqli_connect($sName, $uName, $pass, $db_name);
  if(!$conn) {
    die('connection failed:'. mysqli_connect_error());
  } 
  echo "connected successfully";
*/
?> 
