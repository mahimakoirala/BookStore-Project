<?php 

session_start();

if(isset($_SESSION['user_id']) && 
  isset($_SESSION['user_email'])) 
  { 
#databse connection file 
    include "../db_conn.php";

    #validation helper function 
    include "func-validation.php";

    #file upload helper function 
    include "func-file-upload.php";

    #check if ALL INPUT ARE FILLED
    if(isset($_POST['book_title']) && 
    isset($_POST['book_description']) &&
    isset($_POST['book_category']) &&
    isset($_POST['book_author']) &&
    isset($_FILES['book_cover']) &&
    isset($_FILES['file'])) {

      #get data from post request and store it in var
      $title = $_POST['book_title'];
      $description = $_POST['book_description'];
      $author = $_POST['book_author'];
      $category = $_POST['book_category'];
     
      #making URL data format 
      $user_input = 'title='.$title.'&category_id ='.$category.'&desc='.$description.'&author_id = '.$author;

      #simple form validation 
      $text = "book title";
      $location = "../add-book.php";
      $ms = "error";
      is_empty($title, $text, $location, $ms, $user_input);

      $text = "book description";
      $location = "../add-book.php";
      $ms = "error";
      is_empty($description, $text, $location, $ms, $user_input);

      $text = "book author";
      $location = "../add-book.php";
      $ms = "error";
      is_empty($author, $text, $location, $ms, $user_input);
      
      $text = "book category";
      $location = "../add-book.php";
      $ms = "error";
      is_empty($category, $text, $location, $ms, $user_input);

      #book cover uploading 
      $allowed_image_exs = array("jpg", "jpeg", "png");
      $path = "cover";
      $book_cover = upload_files($_FILES['book_cover'], $allowed_image_exs, $path);
     
      #if error occured while uploading the book cover  
      if($book_cover['status'] == "error") {
        $em = $book_cover['data'];

        #redirect to '../add-book.php'  and passing error message $ user_input
        header ("Location: ../add-book.php?error=$em&$user_input");
        exit;
      } else {
         #file uploading 
          $allowed_file_exs = array("pdf", "docx", "pptx");
          $path = "files";
          $file = upload_files($_FILES['file'], $allowed_file_exs, $path);

          #if error occured while uploading the file   
            if($file['status'] == 'error') {
              $em = $file['data'];

              #redirect to '../add-book.php'  and passing error message $ user_input
              header ("Location: ../add-book.php?error=$em&$user_input");
              exit;
            } else {
              #getting the new file name and book cover name 
              $file_URL = $file['data'];
              $book_cover_URL = $book_cover['data'];

              // echo $file_URL;

              #insert into database
              $sql = "INSERT INTO books(title, author_id, description, category_id, cover, file) VALUES (?,?,?,?,?,?)";
              $stmt = $conn-> prepare($sql);
              $res = $stmt -> execute([$title, $author, $description, $category, $book_cover_URL, $file_URL]);
    
              #if there is no error while inserting the data
              if($res) {
                #success message
                $sm = "successfully created";
                header("Location: ../add-book.php?success=$sm");
              } else {
                #error message 
                $em = "unknown error occured!" ;
                header("Location: ../add-book.php?error=$em");
                exit;
              }
            }
      }

    } else {
      header("Location: ../admin.php");
      exit;
    }
    ?>
 <?php } else {
   header("Location : ../login.php");
 }
 ?>