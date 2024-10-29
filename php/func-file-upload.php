<?php 
#ffile upload helper function 
function upload_files($files, $allowed_exs, $path) {
  
  #get data and stpre them in var
  $file_name = $files['name'];
  $tmp_name = $files['tmp_name'];
  $error = $files['error'];

  #if no error while uploading
  if($error === 0) {

          #get the file extension and store it in var 
          $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);

          #CONVERT THE FILE EXTENSION INTO LOWERCASE AND STORE IT IN VAR 
          $file_ex_lc = strtolower($file_ex);

          #check if the file exxtension exist in $allowed_exs array 
          if(in_array($file_ex_lc, $allowed_exs)) {

            #renaming the file with random strings
            $new_file_name = uniqid("",true).'.'.$file_ex_lc;
            

            #assigning upload path 
            $file_upload_path = '../uploads/'.$path.'/'.$new_file_name;

            #moving uploaded file to the root directory upload/$path folder
            move_uploaded_file($tmp_name,$file_upload_path);

            #creating success messahe associative array with named keys status and data
             #creating success message 
              $sm['status'] = 'success';
              $sm['data'] = $new_file_name;

              #return the sm array
              return $sm;


          } else {
            #creating erroe message associative array with named keys status and data
          $em['status'] = 'error';
          $em['data'] = "you can\'t upload file of this type!";

          #return the em array
          return $em;

          }
  } else {
    #creating error message  associative array with names keys status and data
    $em['status'] = 'error';
    $em['data'] = 'error occured while uploading!';

    #return the em array
    return $em;
  }
}










?>