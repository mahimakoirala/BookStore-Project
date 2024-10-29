<?php

session_start();

if (isset($_SESSION['user_id']) && 
    isset($_SESSION['user_email'])) {

      #database connection file
      include "../db_conn.php";

      #check if author name is submitted.
      if(isset($_POST['author_name']) && isset($_POST['author_id'])) {

        #get data from post request and store them  in var 
        $name = $_POST['author_name'];
        $id = $_POST['author_id'];

        #simple form validation 
        if (empty($name)) {
          $em = "the author name is required";
          header("Location: ../edit-author.php?error=$em&id=$id");
          exit;
        } else { 
          #update the database
          $sql = "UPDATE author SET name=? WHERE id=?";
          $stmt = $conn-> prepare($sql);
          $res = $stmt -> execute([$name, $id]);

          #if there is no error while inserting the data
          if($res) {
            #success message
            $sm = "successfully updated!";
            header("Location: ../edit-author.php?success=$sm&id=$id");
          } else {
            #error message 
            $em = "unknown error occured!" ;
            header("Location: ../edit-author.php?error=$em&id=$id");
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
  

