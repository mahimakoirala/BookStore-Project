<?php

session_start();

if (isset($_SESSION['user_id']) && 
    isset($_SESSION['user_email'])) {

      #database connection file
      include "../db_conn.php";

      #check if category name is submitted.
      if(isset($_POST['category_name']) && isset($_POST['category_id'])) {

        #get data from post request and store them  in var 
        $name = $_POST['category_name'];
        $id = $_POST['category_id'];

        #simple form validation 
        if (empty($name)) {
          $em = "the category name is required";
          header("Location: ../edit-category.php?error=$em&id=$id");
          exit;
        } else { 
          #update the database
          $sql = "UPDATE categories SET name=? WHERE id=?";
          $stmt = $conn-> prepare($sql);
          $res = $stmt -> execute([$name, $id]);

          #if there is no error while inserting the data
          if($res) {
            #success message
            $sm = "successfully updated!";
            header("Location: ../edit-category.php?success=$sm&id=$id");
          } else {
            #error message 
            $em = "unknown error occured!" ;
            header("Location: ../edit-category.php?error=$em&id=$id");
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
  

