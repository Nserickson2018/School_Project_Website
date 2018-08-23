<?php
//Informatics Project
//by Nicholas Erickson, Malachi Melville, and Jacob Sikorski
    include_once("dbutils.php");
    include_once("config.php");

     // get data from fields
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $birthday = $_POST['birth'];
    $email = $_POST['email'];
    $username = $_POST['username'];

	//echo $fname;
    
    
    // check that we have the data we need
    if (!$id) {
        echo "Hey, you didn't add an id. Please <a href='input.php'>try again</a>";
        exit;
    }

    if (!$fname) {
        echo "Hey, you didn't add your first name. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    if (!$lname) {
        echo "Hey, you didn't add your last name. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    if (!$birthday) {
        echo "Hey, you didn't add your birthdate. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    if (!$email) {
        echo "Hey, you didn't add your email. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    if (!$username) {
        echo "Hey, you didn't add a username. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    // get a handle to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

    // add escape characters to text    
    $fname = $db->real_escape_string($fname);
    $lname = $db->real_escape_string($lname);
    $birthday = $db->real_escape_string($birthday);
    $email = $db->real_escape_string($email);
	$username = $db->real_escape_string($username);
	
	//echo "hello";
    //echo $fname;
    // check if username is already in the table
    $urlCheckQuery = "SELECT * FROM pUsers WHERE username='" . $username . "' AND uid!=" . $id . ";"; 
    $result = queryDB($urlCheckQuery, $db);
    if ($result) {
        $numberofrows = nTuples($result);
        if ($numberofrows > 0) {
            punt("The username " . $username . " already exists in the database." .
                              "<p>Please <a href='input.php'>try again</a>");
        }
    } else {
        punt("Could not check if email was already in table.<p>" . $db->error, $emailCheckQuery);
    }
    
    $updateQuery = "UPDATE pUsers SET fname='" . $fname
	. "', lname='" . $lname
        . "', birthday='" . $birthday 
	. "', email='" . $email
	. "', username='" . $username
	. "' WHERE uid = " . $id . ";";
    
    $result = queryDB($updateQuery, $db);
    
    if ($result) {
        echo "Page edited";
    } else {
        echo "soemthing bad happened with the query. " . $db->error . " This was the query: " . $updateQuery;    
    }
    
?>