<?php
    include_once("dbutils.php");
    include_once("config.php");
    
    $orgid=$_POST['orgid'];
    
    // get a handle to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    $query1="SELECT * FROM organizations WHERE orgid=" . $orgid . ";";
    
    $result1=queryDB($query1, $db);
    
    if(nTuples($result1)>0){
        $delete1="DELETE FROM organizations WHERE orgid=" . $orgid . ";";
        $run1=queryDB($delete1, $db);
        exit;
    }
    
    $query2="SELECT * FROM pages WHERE orgid=" . $orgid . ";";
    
    $result2=queryDB($query2, $db);
    
    if(nTuples($result2)>0){
        $delete2="DELETE FROM pages WHERE orgid=" . $orgid . ";";
        $run2=queryDB($delete2, $db);
        exit;
    }
    
    $query3="SELECT * FROM pages WHERE orgid=" . $orgid . ";";
    
    $result3=queryDB($query3, $db);
    
    if(nTuples($result3)>0){
        $delete3="DELETE FROM userorg WHERE orgid=" . $orgid . ";";
        $run3=queryDB($delete3, $db);
        exit;
    }
    
    echo "Organization Deleted";  
?>