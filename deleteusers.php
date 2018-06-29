<?php
    include_once('config.php');
    include_once('dbutils.php');
        
    //get data from fields
    $username=$_POST['username'];
    
    if(!$username){
        echo "No username received.";
        exit;
    }
    
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    $delete="DELETE FROM pUsers WHERE username='" . $username . "';";
    
    $deleteResult=queryDB($delete, $db);
    
    if ($deleteResult) {
        echo "User deleted";
        //header("Location: " . $baseURL . "input.php");
    } else {
        echo "soemthing bad happened with the query. " . $db->error . " This was the query: " . $delete;    
    }
?>