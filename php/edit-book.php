<?php

session_start();

if (isset($_SESSION['user_id']) && 
    isset($_SESSION['user_email'])) {

      #database connection file
      include "../db_conn.php";

      #validation helper function 
        include "func-validation.php";

    #file upload helper function 
    include "func-file-upload.php";
 
    
      #check if all input field are filled. 
      if(isset($_POST['book_id'])       && 
      isset($_POST['book_title'])       && 
      isset($_POST['book_description']) &&
      isset($_POST['book_category'])    &&
      isset($_POST['book_author'])      &&
      isset($_FILES['book_cover'])      &&
      isset($_FILES['file'])            &&     
      isset($_POST['current_cover'])   &&    
      isset($_POST['current_file']))  {

      #get data from post request and store them  in var 
      $id = $_POST['book_id'];
      $title = $_POST['book_title'];
      $description = $_POST['book_description'];
      $author = $_POST['book_author'];
      $category = $_POST['book_category'];

      #get current cover and current file from post and store it in var 
      $current_cover = $_POST['current_cover'];
      $current_file = $_POST['current_file'];

      #simple form validation 
      $text = "book title";
      $location = "../edit-book.php";
      $ms = "id=$id&error";
      is_empty($title, $text, $location, $ms, "");

      $text = "book description";
      $location = "../edit-book.php";
      $ms = "id=$id&error";
      is_empty($description, $text, $location, $ms, "");

      $text = "book author";
      $location = "../edit-book.php";
      $ms = "id=$id&error";
      is_empty($author, $text, $location, $ms, "");
      
      $text = "book category";
      $location = "../edit-book.php";
      $ms = "id=$id&error";
      is_empty($category, $text, $location, $ms, "");
     
        #if the admin try to update the book cover 
        if(!empty($_FILES['book_cover']['name'])) {

          #if the admin try to update both 
          if(!empty($_FILES['file']['name'])) {
            #update both here 

             #book cover uploading 
            $allowed_image_exs = array("jpg", "jpeg", "png");
            $path = "cover";
            $book_cover = upload_file($_FILES['book_cover'], $allowed_image_exs, $path);

             #file uploading 
            $allowed_file_exs = array("pdf", "docx", "pptx");
            $path = "files";
            $file = upload_file($_FILES['file'], $allowed_file_exs, $path);

             #if error occured while uploading the book cover  
              if($book_cover['status'] == "error" || 
               $file['status'] == "error") {

                $em = $book_cover['data'];

                #redirect to '../edit-book.php'  and passing error message & the id 
                header ("Location: ../edit-book.php?error=$em&id=$id");
                exit;
              } else {
                #curent book cover location 
                $c_p_book_cover = "../uploads/cover/$current_cover";

                 #curent file location 
                 $c_p_file = "../uploads/files/$current_file";

                 #delete from the server 
                 unlink($c_p_book_cover);
                 unlink($c_p_file);

                 #getting the new file name and new cover name 
                 $file_URL = $file['data'];
                 $book_cover_URL = $book_cover['data'];

                #update just the data
                  $sql = "UPDATE books 
                            SET title = ?,
                            author_id =?,
                            description = ?,
                            category_id = ?,
                             cover = ?,
                             file = ?
                            WHERE id = ?";
                  $stmt = $conn-> prepare($sql);
                  $res = $stmt -> execute([$title, $author,$description, $category,$book_cover_URL, $file_URL, $id]);

                  #if there is no error while updating the data
                  if($res) { 
                  #success message
                  $sm = "successfully updated!";
                  header("Location: ../edit-book.php?success=$sm&id=$id");
                  exit;
                  } else {
                  #error message 
                  $em = "unknown error occured!" ;
                  header("Location: ../edit-book.php?error=$em&id=$id");
                  exit;
                  }

                }

          } else {
            #update just book cover 

            #book cover uploading 
            $allowed_image_exs = array("jpg", "jpeg", "png");
            $path = "cover";
            $book_cover = upload_file($_FILES['book_cover'], $allowed_image_exs, $path);

            

             #if error occured while uploading the book cover  
              if($book_cover['status'] == "error") {

                $em = $book_cover['data'];

                #redirect to '../edit-book.php'  and passing error message & the id 
                header ("Location: ../edit-book.php?error=$em&id=$id");
                exit;
              } else {
                #curent book cover location 
                $c_p_book_cover = "../uploads/cover/$current_cover";

                

                 #delete from the server 
                 unlink($c_p_book_cover);

                 #getting the new file name and new cover name 
                 $book_cover_URL = $book_cover['data'];

                #update just the data
                  $sql = "UPDATE books 
                            SET title = ?,
                            author_id =?,
                            description = ?,
                            category_id = ?,
                             cover = ?,
                            WHERE id = ?";
                  $stmt = $conn-> prepare($sql);
                  $res = $stmt -> execute([$title, $author,$description, $category,$book_cover_URL, $id]);

                  #if there is no error while updating the data
                  if($res) { 
                  #success message
                  $sm = "Successfully updated!";
                  header("Location: ../edit-book.php?success=$sm&id=$id");
                  } else {
                  #error message 
                  $em = "unknown error occured!" ;
                  header("Location: ../edit-book.php?error=$em&id=$id");
                  exit;
                  }

                }
            
          }
        }

        #if the admin try to update just the file  
        else if(!empty($_FILES['file']['name'])) {
          #update just the file 
            #file uploading 
            $allowed_file_exs = array("pdf", "docx", "pptx");
            $path = "files";
            $files = upload_file($_FILES['file'], $allowed_file_exs, $path);

            

             #if error occured while uploading
              if($files['status'] == "error") {

                $em = $files['data'];

                #redirect to '../edit-book.php'  and passing error message & the id 
                header ("Location: ../edit-book.php?error=$em&id=$id");
                exit;
              } else {
                #curent book cover location 
                $c_p_file = "../uploads/files/$current_file";

                

                 #delete from the server 
                 unlink($c_p_file);

                 #getting the new file name and new cover name 
                 $file_URL = $file['data'];

                #update just the data
                  $sql = "UPDATE books 
                            SET title = ?,
                            author_id =?,
                            description = ?,
                            category_id = ?,
                             file = ?,
                            WHERE id = ?";
                  $stmt = $conn-> prepare($sql);
                  $res = $stmt -> execute([$title, $author,$description, $category,$file_URL, $id]);

                  #if there is no error while updating the data
                  if($res) { 
                  #success message
                  $sm = "Successfully updated!";
                  header("Location: ../edit-book.php?success=$sm&id=$id");
                  } else {
                  #error message 
                  $em = "unknown error occured!" ;
                  header("Location: ../edit-book.php?error=$em&id=$id");
                  exit;
                  }

                }
            
          }
        


        else {
          #update just the data
          $sql = "UPDATE books SET title = ?, 
                          author_id = ?,
                         description = ?,
                        category_id = ? 
                        WHERE id = ?";
          $stmt = $conn-> prepare($sql); 
          $res = $stmt -> execute([$title, $author,       $description, $category,$id]);

           #if there is no error while updating the data
           if($res) { 
            #success message
            $sm = "successfully updated!";
            header("Location: ../edit-book.php?success=$sm&id=$id");
          } else {
            #error message 
            $em = "unknown error occured!" ;
            header("Location: ../edit-book.php?error=$em&id=$id");
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
  

