<?php

session_start();

if (isset($_SESSION['user_id']) && 
    isset($_SESSION['user_email'])) {

      #database connection file
      include "../db_conn.php";

      #check if author id is submitted.
      if(isset($_GET['id'])) {

        #get data from GET request and store them  in var 
        $id = $_GET['id'];

        #simple form validation 
        if (empty($id)) {
          $em = "error occured";
          header("Location: ../admin.php?error=$em");
          exit;
        } else { 

          #get book from database 
          $sql2 = "SELECT * FROM books 
                    WHERE id=?";
          $stmt2 = $conn-> prepare($sql2);
          $stmt2 -> execute([ $id]);
          $the_book = $stmt2 ->fetch();

          if($stmt2 -> rowCount() > 0) {

            #delete the book from databse 
            $sql = "DELETE FROM books 
                    WHERE id = ?";
            $stmt = $conn ->prepare($sql);
            $res = $stmt -> execute([$id]);

            #if there is no error while deleting the data
            if($res) {
              #delete the current book_cover and the file 
              $cover = $the_book['cover'];
              $file = $the_book['file'];
              $c_b_c = "../uploads/cover/$cover";
              $c_f= "../uploads/files/$file";

              unlink($c_b_c);
              unlink($c_f);

              #success message 
              $sm = "successfully removed!";
              header("Location: ../admin.php?success=$sm");
              exit;
            
          } else {
            $em = "error occured";
            header("Location: ../admin.php?error=$em");
            exit;

          }
        } else {
          #error message
          $em = "unknown error occured!";
          header("Location: ../admin.php?error=$em");
          exit;
        }
      }
    }

      } else {
        header("Location: ../login.php");
        exit;
      }
    
?>
  

