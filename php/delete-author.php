<?php

session_start();

if (isset($_SESSION['user_id']) && 
    isset($_SESSION['user_email'])) {

      #database connection file
      include "../db_conn.php";

      #check if author is set.
      if(isset($_GET['id'])) {

        #get data from GET request and store them  in var 
        $id = $_GET['id'];

        #simple form validation 
        if (empty($id)) {
          $em = "error occured";
          header("Location: ../admin.php?error=$em");
          exit;
        } else { 

            #delete the category from databse 
            $sql = "DELETE FROM author WHERE id = ?";
            $stmt = $conn ->prepare($sql);
            $res = $stmt -> execute([ $id]);

            #if there is no error while deleting the data
            if($res) {

              #success message 
              $sm = "successfully removed!";
              header("Location: ../admin.php?success=$sm");
              exit;
            } else {
              $em = "error occured";
              header("Location: ../admin.php?error=$em");
              exit;
            }
          

      } 
    }else {
        header("Location: ../admin.php");
        exit;
      }
    } else {
      header("Location: ../login.php");
      exit;
    }
?>
  

