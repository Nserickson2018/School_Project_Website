<?php
    //Informatic Project
    //By: Nicholas Erickson, Malachi Melville, Jacob Sikorski
    if(isset($_SESSION['username'])){
        $username=$_SESSION['username'];
        
        /*$getuid="SELECT uid FROM pUsers WHERE username='" . $username . "';";
        $uidResult=queryDB($getuid, $db);
    
        if(nTuples($uidResult)>0){
            $uidRow=nextTuple($uidResult);
            $uid=$uidRow['uid'];
        }*/
    }
    
    
    include_once('config.php');
    include_once('dbutils.php');
    
    //get data from form
    $orgid=$_POST['orgid'];
    $orgName=$_POST['orgName'];
    $footerText=$_POST['footerText'];
    $stylesheet=$_POST['stylesheet'];
    $urltitle=$_POST['urlTitle'];
    $pagetitle=$_POST['pageTitle'];
    $menutitle=$_POST['menuTitle'];
    $bodytitle=$_POST['bodyTitle'];
    $body=$_POST['body'];
    $asidetitle=$_POST['asideTitle'];
    $asidebody=$_POST['asideBody'];
    $template=$_POST['template'];
    $acctype=$_POST['acctype'];
    $uid=$_POST['uid'];
	
	if(!$template){
		echo "Hey you did not select a template.";
		exit;
	}
    
    if($template!=1){
        if(!$_FILES['image']['size']>0){
            echo "There appears to be a problem uploading the image to the site.";
            exit;
        } else {
            $tmpName=$_FILES['image']['tmp_name'];
            $fileName=$_FILES['image']['name'];

            if(!move_uploaded_file($tmpName, $imgDir . $fileName)){
				if(file_exists($imgDir . $fileName)){
					echo "File " . $fileName . " already exists but the site will still be created and use the existing image.\n";
					exit;
				} else {
					echo "Unable to upload file.";
					exit;
				}
            }
        }
    }
    //connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    //check if the organization name is already in the database
    //set up query
    $checkQuery="SELECT * FROM organizations WHERE orgName='" . $orgName . "';";
    //run the statement
    $result=queryDB($checkQuery, $db);
    if($result) {
        $numRows=nTuples($result);
        if($numRows>0) {
            punt("Sorry but the organization site you are trying to create already exists. You will not be redirected to start page.");
            header("refresh:10;url=index.php");
        }
    } else {
        punt("Sorry, could not check if the organization was in the database.<p>" . $db->error, $checkQuery);
    }
    
    //create sql query to insert organization into database
    $insertQuery="INSERT INTO organizations(orgName, footerText, stylesheetid, verified) VALUES('" . $orgName . "', '" . $footerText . "', '" . $stylesheet . "', 'no');";
    //run sql statement
    $insertResult=queryDB($insertQuery, $db);
    
    //Now get the orgid from the created organizations, this will be used for the following sql statements
    $getorgid="SELECT orgid FROM organizations WHERE orgName='" . $orgName . "';";
    $orgidresult=queryDB($getorgid, $db);
    if (nTuples($orgidresult)>0){
        $row=nextTuple($orgidresult);
    }
    
    $orgid=$row['orgid'];
    
    //create statement to insert page into data base
    /*$insertPage="INSERT INTO pages(urlTitle, pageTitle, menuTitle, orgid, parent, bodyTitle, body, asideTitle, asideBody) VALUES('" . $urltitle . "', '" . $pagetitle . "', '"
                . $menutitle . "', " . $orgid . ", -1, '" . $bodytitle . "', '" . $body . "', '" . $asidetitle . "', '" . $asidebody . "');";*/
    //check to see if everything is filled out
    if(!$asidebody){
    $insertPage="INSERT INTO pages(urlTitle, pageTitle, menuTitle, orgid, parent, bodyTitle, body, template, image) VALUES('" . $urltitle . "', '" . $pagetitle . "', '"
                . $menutitle . "', " . $orgid . ", -1, '" . $bodytitle . "', '" . $body . "', " . $template . ", '" . $fileName . "');";
    } else { 
            $insertPage="INSERT INTO pages(urlTitle, pageTitle, menuTitle, orgid, parent, bodyTitle, body, asideTitle, asideBody, template, image) VALUES('" . $urltitle . "', '" . $pagetitle . "', '"
                . $menutitle . "', " . $orgid . ", -1, '" . $bodytitle . "', '" . $body . "', '" . $asidetitle . "', '" . $asidebody . "', " .  $template . ", '" . $fileName . "');";
    }

    
    $insertPageResult=queryDB($insertPage, $db);
    
    //now that the page and the organization have been created...
    //create statement to put the userid and orgid into the userorg table.
    //this will be for the table in the index.php page
    
    //check if the Usertype is an admin

    //create insert owner statement for administrators
    $insertadmin="INSERT INTO userorg(orgid, uid, orgacctype) VALUES(" . $orgid . ", " . $uid . ", 'orgadmin');";
    
    //run the insert statement
    $insertadminResult=queryDB($insertadmin, $db);

    //check if it worked
    if ($insertadminResult && $insertPageResult && $insertResult) {
        echo "\nSite Created";
    } else {
        echo "Something went wrong with the query. \n" . $db->error, $insertQuery;
    }

    
?>
