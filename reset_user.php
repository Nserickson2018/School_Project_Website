<!-- Informatics Project -->
<!-- by Nicholas Erickson, Malachi Melville, Jacob Sikorski -->

<!-- this page will be used in resetting a forgotten password/username. It
will verify the email of the account and send the user a link to reset the
information via their email. -->

<?php
    include_once("config.php");
    include_once("dbutils.php");
    
    //connect to database
    $db=connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    if (isset($_POST['email'])) {
        
        $email=$_POST['email'];
        
        $isComplete=true;
        if (!$email) {
            $isComplete=false;
            punt("Please enter your email address.");
        }
        
        //check if the email is in the database
        $query="SELECT * FROM pUsers WHERE email='" . $email . "';";
        $result=queryDB($query, $db);
        if(nTuples($result)>0){
            //get data from table
            $row=nextTuple($result);
            //extract username and hashedpassword 
            $hashedpass=$row['hashedpass'];
            $username=$row['username'];
            
            //generate link to be sent to email
            $link=$Proto . $Host . $Base . "/reset.php?u=" . $username . "&h=" . $hashedpass;
            
            //create the message for the email
            $msg="Hello, this email will let you reset your password.\n\n
            To reset your password click on the link below\n" . $link;
            
            //send email
            mail($email, "Password Reset", $msg);
            
            punt("We have sent a link to reset the password to" . $email);
        } else {
            punt("The email you entered doen not exist in our system.");
        }
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
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Reset Password</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <form action="reset_user.php" method="post">
                <label for="email">Email</label>
                <input class="form-control" name="email" id="email" autofocus>
                
                <button type="submit" class="btn btn-default" name="Submit">Send Email</button>
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