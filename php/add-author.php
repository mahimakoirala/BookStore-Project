<?php

session_start();

if (isset($_SESSION['user_id']) && 
    isset($_SESSION['user_email'])) {

      #database connection file
      include "../db_conn.php";

      #check if author name is submitted.
      if(isset($_POST['author_name'])) {
        #get data from post reqsuest and store it in var 
        $name = $_POST['author_name'];

        #simple form validation 
        if (empty($name)) {
          $em = "the author name is required";
          header("Location: ../add-author.php?error=$em");
          exit;
        } else {
          $sql = "INSERT INTO author(name) VALUES (?)";
          $stmt = $conn-> prepare($sql);
          $res = $stmt -> execute([$name]);

          #if there is no error while inserting the data
          if($res) {
            #success message
            $sm = "successfully created";
            header("Location: ../add-author.php?success=$sm");
          } else {
            #error message 
            $em = "unknown error occured!" ;
            header("Location: ../add-author.php?error=$em");
            exit;
          }
        }

      } else {
        header("Location: ../admin.php");
        exit;
      }
    } else {
      header("Location: ../login.php");
      exit;
    }
?>
  

