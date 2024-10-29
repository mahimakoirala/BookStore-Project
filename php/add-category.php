<?php

session_start();

if (isset($_SESSION['user_id']) && 
    isset($_SESSION['user_email'])) {

      #database connection file
      include "../db_conn.php";

      #check if author name is submitted.
      if(isset($_POST['category_name'])) {
        #get data from post reqsuest and store it in var 
        $name = $_POST['category_name'];

        #simple form validation 
        if (empty($name)) {
          $em = "the category name is required";
          header("Location: ../add-category.php?error=$em");
          exit;
        } else {
          $sql = "INSERT INTO categories (name) VALUES (?)";
          $stmt = $conn-> prepare($sql);
          $res = $stmt -> execute([$name]);

          #if there is no error while inserting the data
          if($res) {
            #success message
            $sm = "successfully created";
            header("Location: ../add-category.php?success=$sm");
          } else {
            #error message 
            $em = "unknown error occured!" ;
            header("Location: ../add-category.php?error=$em");
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
  

