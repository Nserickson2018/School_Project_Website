<!-- Informatics Project -->
<!-- Nicholas Erickson -->

<!-- This webpage is used to login users into the website. -->

<?php
    include_once('config.php');
    include_once('dbutils.php');
?>


<html lang='en'>

<head>
    <Title>Login</Title>
    
    <!-- This is the code from bootstrap -->        
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>    
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
      
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://bootswatch.com/cyborg/bootstrap.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Bungee+Inline|Lobster|Rokkitt|Tangerine" rel="stylesheet"> 
    <link rel="stylesheet" href="styles.css"/>
</head>

<body>
<div class="container">
    <!--Visible Title-->
    <div class="row" style="text-align: center; background-color: black">
        <div class="col-xs-12" style="margin-left: 1%; margin-right: 2%">
            <h1 style="color: white">Login</h1>
        </div>
    </div>
    
    <!--php code for handling data entry-->
    <div class="row">
        <div class="col-xs-12">
            <?php
            //
            //Code to handle input from form
            //
            
            $db=connectDB($DBHost, $DBUser, $DBPassword, $DBName);
            
            if (isset($_POST['submit'])) {
                //only run if form was submitted
                $username=$_POST['username'];
                $password=$_POST['password'];
                
                $isComplete=true;
                $errorMessage="";
                
                //check for required fields
                if (!$username) {
                    $errorMessage="Please enter your username";
                    $isComplete=false;
                }
                
                if (!$password) {
                    $errorMessage="Please enter your password.";
                    $isComplete=false;
                }
                
                if (!$isComplete){
                    punt($errorMessage);
                }
                
                //get the hashed password from the user with the email and password
                $query="SELECT hashedpass FROM pUsers WHERE username='" . $username . "';";
                $result=queryDB($query, $db);
                if (nTuples($result)>0) {
                    //there is an account corresponding to the entered account
                    //get hashed password for that account
                    $row=nextTuple($result);
                    $hashedpass=$row['hashedpass'];
                    
                    //compare entered password to password in the database
                    if($hashedpass==crypt($password, $hashedpass)) {
                        //pasword was entered correctly
                        
                        //start a session
                        if(session_start()) {
                            $_SESSION['username']=$username;
                            header('Location: index.php');
                            exit;
                        } else {
                            //if we can't start a session
                            punt("Unable to start session when logging in.");
                        }
                    } else {
                        $hashedpass2=crypt($password, $hashedpass);
                        punt("Wrong password. <a href='login.php'>Try Again</a>.");
                    }
                } else {
                    //email is not in the users table
                    punt("This username is not in our system. <a href='login.php'>Try Again</a>.");
                }
            }
            ?>
        </div>    
    </div>
    <!--form for inputting data-->
    <div class="row">
        <div class="col-xs-12">
            <form action="login.php" method="post">
                <!--username-->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" autofocus required"/>
                </div>
                <!--Password-->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" autofocus required"/>
                </div>
                
                <button type="submit" class="btn btn-default" name="submit">Login</button>
                <button type="reset" class="btn btn-default" name="reset">Clear Form</button>
                <!--<a href="create_users.php" class="btn btn-default" role="button">Creat Account</a>-->
            </form>
            <p><a href="reset_user.php">Forgot Password?</a></p>
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