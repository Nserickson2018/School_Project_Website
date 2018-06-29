<?php
    include_once("config.php");
    include_once("dbutils.php");
?>
    
    
    <?php
        // process the form when submitted
        if (isset($_POST['submit'])){
            $db=connectDB($DBHost, $DBUser, $DBPassword, $DBName);
            
            $username=$_POST['username'];
            $password=$_POST['newPass'];
            $password2=$_POST['newPass2'];
            
            $isComplete=true;
            $errorMessage="";
            if (!$username){
                $errorMessage="Could not get username from form.";
                $isComplete=false;
            }
            
            if (!$password){
                $errorMessage="Please eneter a password";
                $isComplete=false;
            }
            
            if (!$password2){
                $errorMessage="Please enter your password again.";
                $isComplete=false;
            }
            
            if ($password != $password2) {
                $errorMessage="Your passwords don't match.";
                $isComplete=false;
            }
            
            echo "password1: " . $password . ", password2: " . $password2;
            
            if (!$isComplete){
                punt($errorMessage);
            }
            
            //set up code to generate hashedpass
            $newHashedpass=crypt($password, getSalt());
            
            $update="UPDATE pUsers SET hashedpass='" . $newHashedpass . "' WHERE username='" . $username . "';";
            
            $uResult=queryDB($update, $db);
            
            //send the user back to login page
            header('Location: login.php');
        }
    ?>    
    
<?php
    // code to bounce users out if the url is not properly formatted with a valid username and hashed password
    $db=connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    $username=$_GET['u'];
    $hashedpass=$_GET['h'];
    
    if (!$username){
        punt("No username found.");
    }
    
    if (!$hashedpass) {
        punt("Old password not found.");
    }
    
    $query="SELECT * FROM pUsers WHERE username='" . $username . "' AND hashedpass='" . $hashedpass . "';";
    $result=queryDB($query, $db);
    if (nTuples($result)==0){
        punt("This username and password don't exist");
        header('Location: login.php');
    }
?>


<html lang="en">
<head>
        
    <title>Reset Password</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>    
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
      
    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="https://bootswatch.com/cyborg/bootstrap.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Bungee+Inline|Lobster|Rokkitt|Tangerine" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"/>

</head>

<body>
<div class="container">
    <!--Visible Title-->
    <!--Visible Title-->
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Reset Password</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <p><?//php echo $username; ?></p>
            <form action="reset.php" method="post">
                <label for="newPass">Enter your new password</label>
                <input type="password" class="form-control" name="newPass" id="newPass" autofocus><br>
                
                <label for="newPass2">Please enter the new password again</label>
                <input type="password" class="form-control" name="newPass2" id="newPass2" autofocus><br>
                
                <input type="hidden" name="username" value="<?php echo $username;?>">
                
                <button type="submit" class="btn btn-default" name="submit">Submit</button>
                <button type="reset" class="btn btn-default" name="reset">Clear Form</button>
            </form>
        </div>
    </div>
    <!-- This is the footer -->
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default" style="padding-top: 2%">
                <div class="panel-body">
                    <p>&copy; 2016 EMS Site Management Service. All Rights Reserved.</p>
                    <p style='text-align: right'>Powered by <a href='index.php'>EMS Site Management Service</a></p>
                </div>
            </div>
        </div>        
    </div>
</div>
</body>
</html>