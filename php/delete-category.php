<?php
session_start();

#If the admin is logged in
if (isset($_SESSION['user_id'])&&
    isset($_SESSION['user_email'])){

    #Database Connection File
    include "../db_conn.php";


    #Check if the category id is set
    if (isset($_GET['id'])){

        # Get data from GET request and store it in var
        $id = $_GET['id'];


        #simple form validation
        if (empty($id)){
            $em = "Error occurred";
            header("Location: ../admin.php?error=$em");
            exit;
        }
        
    else{
        #DELETE the category from database
        $sql = "DELETE FROM categories
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([$id]);

        #If there is no error while deleting the data
        if ($res){
                #success Message
                $sm = "Successfully removed!!";
                header("Location: ../admin.php?success=$sm");
            exit;
    }else{
        $em = "Error occurred";
        header("Location: ../admin.php?error=$em");
        exit;
    }

        
    }
    }
}else{
   header("Location: ../login.php");
   exit;
}
?>