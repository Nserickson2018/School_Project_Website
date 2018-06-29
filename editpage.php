<?php
    //check if user is logged in
    session_start();
    
    if(!isset($_SESSION['username'])) {
        //if not logged in, send them to the login page
        header('Location: login.php');
        exit;
    }
?>
<?php
    include_once("dbutils.php");
    include_once("config.php");

     // get data from fields
    $id = $_POST['editid'];
    $urlTitle = $_POST['editurlTitle'];
    $pageTitle = $_POST['editpageTitle'];
    $menuTitle = $_POST['editmenuTitle'];
    $bodyTitle = $_POST['editbodyTitle'];
    $parent = $_POST['editparent'];
    $body = $_POST['editbody'];
	$asideTitle=$_POST['editasideTitle'];
	$asideBody=$_POST['editasideBody'];
	$orgid=$_POST['editorgid'];
	$template=$_POST['edittemplate'];
    
    
    // check that we have the data we need
    if (!$id) {
        echo "Hey, you didn't add an id. Please <a href='input.php'>try again</a>";
        exit;
    }

    if (!$urlTitle) {
        echo "Hey, you didn't add a url title. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    if (!$menuTitle) {
        echo "Hey, you didn't add a menu title. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    if (!$bodyTitle) {
        echo "Hey, you didn't add a body title. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    if (!$pageTitle) {
        echo "Hey, you didn't add a page title. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    if (!$parent) {
        echo "Hey, you didn't add a parent. Parent=" . $parent;
        exit;
    }
    
    if ($parent == $id) {
		echo "Hey, you can't be your own parent";
		exit;
    }
    
        
    if (!$body) {
        echo "Hey, you didn't add a body. Please <a href='input.php'>try again</a>";
        exit;
    }
	
    if (!$orgid) {
        echo "Hey, you didn't add a Organization Id. Please <a href='input.php'>try again</a>";
        exit;
    }
	if(!$template){
		echo "Hey you did not select a template.";
		exit;
	}
	if($template!='1'){
		if(!$_FILES['editimage']['size']>0){
			echo "Could not find the image selected from the form.";
		} else {
			$tmpName=$_FILES['editimage']['tmp_name'];
			$fileName=$_FILES['editimage']['name'];
			
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

    // get a handle to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

    // add escape characters to text    
    $pageTitle = $db->real_escape_string($pageTitle);
    $menuTitle = $db->real_escape_string($menuTitle);
    $bodyTitle = $db->real_escape_string($bodyTitle);
    $body = $db->real_escape_string($body);
	$asideTitle=$db->real_escape_string($asideTitle);
	$asideBody=$db->real_escape_string($asideBody);
	$template=$db->real_escape_string($template);
	$image=$db->real_escape_string($image);
    
    // check if url title is already in the table
    $urlCheckQuery = "select * from pages where urlTitle='" . $urlTitle . "' AND id!=". $id . " AND orgid=" . $orgid . ";";
    $result = queryDB($urlCheckQuery, $db);
    if ($result) {
        $numberofrows = nTuples($result);
        if ($numberofrows > 0) {
            punt("The url title " . $urlTitle . " already exists in the database." .
                              "<p>Please <a href='input.php?orgid=" . $orgid . "'>try again</a>");
        }
    } else {
        punt("Could not check if email was already in table.<p>" . $db->error, $urlCheckQuery);
    }
    if(!$fileName){
			$updateQuery = "UPDATE pages SET urlTitle='" . $urlTitle
	. "', pageTitle='" . $pageTitle
		. "', menuTitle='" . $menuTitle 
	. "', bodyTitle='" . $bodyTitle 
	. "', body='" . $body
	. "', orgid=" . $orgid
	. ", parent=" . $parent
	. ", asideTitle='" . $asideTitle
	. "', asideBody='" . $asideBody
	. "', template=" . $template
	. " WHERE id = " . $id . ";";
	} else {
		$updateQuery = "UPDATE pages SET urlTitle='" . $urlTitle
		. "', pageTitle='" . $pageTitle
			. "', menuTitle='" . $menuTitle 
		. "', bodyTitle='" . $bodyTitle 
		. "', body='" . $body
		. "', orgid=" . $orgid
		. ", parent=" . $parent
		. ", asideTitle='" . $asideTitle
		. "', asideBody='" . $asideBody
		. "', template=" . $template
		. ", image='" . $fileName
		. "' WHERE id = " . $id . ";";
	}
    
    $result = queryDB($updateQuery, $db);
    
    if ($result) {
        echo "Page edited";
    } else {
        echo "soemthing bad happened with the query. " . $db->error . " This was the query: " . $updateQuery;    
    }
    
?>