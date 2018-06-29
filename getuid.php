<?php
   
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
   
    $userquery = "SELECT uid FROM pUsers WHERE username='" . $username . "';";
    
    $useresult = queryDB($userquery, $db);

 
    if($userresult){
        $usernumRows=nTuples($userresult);
        
        for($user=0; $user<$usernumRows; $user++){
            $userRow=nextTuple($userresult);
            
            $uid=$userRow['uid'];
            #echo "username grabbed: " . $username;
        }
    }
    
    ?>