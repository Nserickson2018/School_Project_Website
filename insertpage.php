<?php
    //check if user is logged in
    session_start();
    
    if(!isset($_SESSION['username'])) {
        //if not logged in, send them to the login page
        header('Location: login.php');
        exit;
    }
?>
<html>

<head>
    <title>Insert page feedback</title>
</head>

<body>

<h1>
    Insert page feedback
</h1>

<?php
    include_once("dbutils.php");
    include_once("config.php");

    // get data from fields
    $urlTitle = $_POST['urlTitle'];
    $pageTitle = $_POST['pageTitle'];
    $menuTitle = $_POST['menuTitle'];
    $bodyTitle = $_POST['bodyTitle'];
    $parent = $_POST['parent'];
    $body = $_POST['body'];
    $asideTitle=$_POST['asideTitle'];
    $asideBody=$_POST['asideBody'];
    $orgid=$_POST['orgid'];
    $template=$_POST['template'];

    echo $orgid;
    
    // check that we have the data we need
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
        echo "Hey, you didn't add a parent. Please <a href='input.php'>try again</a>";
        exit;
    }
    
        
    if (!$body) {
        echo "Hey, you didn't add a body. Please <a href='input.php'>try again</a>";
        exit;
    }
    
    if (!$orgid) {
        echo "Hey, you didn't add an Organization id. Please <a href='input.php'>try again</a>";
        exit;
    }
    if(!$template){
        echo "Hey, you did't select a Template type. Please <a href='input.php'>try again</a>";
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
    
    // get a handle to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    // add escape characters to text    
    $pageTitle = $db->real_escape_string($pageTitle);
    $menuTitle = $db->real_escape_string($menuTitle);
    $bodyTitle = $db->real_escape_string($bodyTitle);
    $body = $db->real_escape_string($body);
    $asideTitle=$db->real_escape_string($asideTitle);
    $asideBody=$db->real_escape_string($asideBody);
    $orgid=$db->real_escape_string($orgid);
    $template=$db->real_escape_string($template);
    $image=$db->real_escape_string($image);

    // check if url title is already in the table
    $urlCheckQuery = "select * from pages where urlTitle='" . $urlTitle . "' and orgid=" . $orgid . ";";
    $result = queryDB($urlCheckQuery, $db);
    if ($result) {
        $numberofrows = nTuples($result);
        if ($numberofrows > 0) {
            punt("The url title " . $urlTitle . " already exists in the database." .
                              "<p>Please <a href='input.php'>try again</a>");
        }
    } else {
        punt("Could not check if email was already in table.<p>" . $db->error, $emailCheckQuery);
    }
    
    // prepare sql statement
    $query = "insert into pages (urlTitle, pageTitle, menuTitle, orgid, parent, bodyTitle, body, asideTitle, asideBody, template, image)
        values ('" . $urlTitle . "', '" . $pageTitle . "', '" . $menuTitle . "', " . $orgid . ", " .
        $parent . ", '" . $bodyTitle . "', '" . $body . "', '" . $asideTitle . "', '" . $asideBody . "'," . $template . ", '" . $fileName . "');";
    
    // execute sql statement
    $result = queryDB($query, $db);
    
    // check if it worked
    if ($result) {
        echo $urlTitle . " was added to the database.";
		echo "<p>";
        echo "<a href='input.php?orgid=" . $orgid . "'>Add more pages</a><br>";
        echo "<a href='home.php?orgid=" . $orgid . "'>Go to home page.</a>";
    } else {
        echo "Something went horribly wrong when adding " . $u . ".";
        echo "<p>This was the error: " . $db->error;
        echo "<p>This was the sql statement: " . $query;
        echo "<p>Please <a href='input.php?orgid=" . $orgid . "'>try again</a>";
    }
    
    $db->close();
?>

</body>

</html>