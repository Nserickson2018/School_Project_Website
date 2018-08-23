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
    $id = $_POST['id'];

    // check that we have an id
    if (!$id) {
        echo "No id received";
	exit;
    }
    
    // get a handle to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    $deleteQuery = "DELETE FROM pages WHERE id = " . $id . ";";
    
    $result = queryDB($deleteQuery, $db);
    
    if ($result) {
        echo "Page deleted";
        //header("Location: " . $baseURL . "input.php");
    } else {
        echo "soemthing bad happened with the query. " . $db->error . " This was the query: " . $deleteQuery;    
    }
    
?>