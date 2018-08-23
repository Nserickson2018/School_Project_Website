<?php
   
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
   
    $Accquery = "SELECT acctype FROM pUsers WHERE username='" . $_SESSION['username'] . "';";
    
    $Accresult = queryDB($Accquery, $db);

 
    if($Accresult){
        $AccnumRows=nTuples($Accresult);
        
        for($acc=0; $acc<$AccnumRows; $acc++){
            $accRow=nextTuple($Accresult);
            
            $acctype=$accRow['acctype'];
            #echo "account type: " . $acctype;
        }
    }
    
    $orgaccquery = "SELECT orgacctype FROM userorg, pUsers WHERE userorg.uid = pUsers.uid AND pUsers.username ='" . $_SESSION['username']. "';";
    $orgaccresult = queryDB($orgaccquery, $db);
    
    if($orgaccresult){
        $orgaccnumrows = nTuples($orgaccresult);
        
        for($acc=0; $acc<$orgaccnumrows; $acc++){
            $accRow2 = nextTuple($orgaccresult);
            
            $orgacctype=$accRow2['orgacctype'];
        }
    }
    
?>