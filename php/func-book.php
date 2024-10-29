<?php 
 #get all books function 
 function get_all_books($conn) {
  $sql = "SELECT * FROM  books ORDER BY id DESC";
  $stmt = $conn -> prepare($sql);
  $stmt  ->execute();

  if($stmt -> rowCount() >0) {
    $books = $stmt -> fetchAll();

  } else {
    $books = 0;
  }
  return $books;

 }

 #get book by ID function 
 function get_book($conn, $id) {
  $sql = "SELECT * FROM books WHERE id = ?" ;
  $stmt = $conn ->prepare($sql);
  $stmt -> execute([$id]);

  if($stmt -> rowCount() > 0) {
    $book = $stmt -> fetch();
  } else {
    $book = 0;
  }
  return $book;
 }


 #search book function 
 function search_books($conn, $key) {
  
  #creating simple search algorithm 
  $key = "%{$key}%";

  $sql = "SELECT * FROM books 
            WHERE title LIKE ?
           OR description LIKE ?" ;
  $stmt = $conn ->prepare($sql);
  $stmt -> execute([$key, $key]);

  if($stmt -> rowCount() > 0) {
    $books = $stmt -> fetchAll();
  } else {
    $books = 0;
  }
  return $books;
 }

 #get book by category function 
 function get_books_by_category($conn, $id) {
  $sql = "SELECT * FROM books WHERE category_id = ?" ;
  $stmt = $conn ->prepare($sql);
  $stmt -> execute([$id]);

  if($stmt -> rowCount() > 0) {
    $books = $stmt -> fetchAll();
  } else {
    $books = 0;
  }
  return $books;
 }

 #get book by author function 
 function get_books_by_author($conn, $id) {
  $sql = "SELECT * FROM books WHERE author_id = ?" ;
  $stmt = $conn ->prepare($sql);
  $stmt -> execute([$id]);

  if($stmt -> rowCount() > 0) {
    $books = $stmt -> fetchAll();
  } else {
    $books = 0;
  }
  return $books;
 }




?>