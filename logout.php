<!-- Informatics Project -->
<!-- Nicholas Erickson -->

<!-- This page logs the user out of the website. -->
<?php
    session_start();
    if (isset($_SESSION['username'])){
        unset($_SESSION['username']);
    }
    session_destroy();
    
    //redirect user to login page
    header('Location: index.php');
    exit;
?>