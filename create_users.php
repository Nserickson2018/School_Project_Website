<!-- Informatics Project -->
<!-- Nicholas Erickson -->

<!-- This webpage will be used to input user infor into the database
where it will be stored and used for logging into the website.-->

<?php
    include_once("dbutils.php");
    include_once("config.php");
    session_start();
    //echo "acctype " . $acctype;
    /*if(!isset($_SESSION['username'])) {
        //if not logged in, send them to the login page
        header('Location: login.php');
        exit;
    }
    //see if the user has admin permissions
    include_once("getAccType.php");
    if($acctype!='admin'){
        //if the user is not an admin, send them to the login page
        header('Location: index.php');
        exit;
    }*/
    
?>

<html lang="en">
<head>
    <Title>Create Account</Title>

    <link rel="stylesheet" href="https://bootswatch.com/cyborg/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Bungee+Inline|Lobster|Rokkitt|Tangerine" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Bungee+Inline|Lobster|Rokkitt|Tangerine" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"/>

</head>

<body>
<div class="container">
    <!--Visible Title-->
    <div class="row" style="text-align: center; background-color: black">
        <div class="col-xs-12" style="margin-left: 1%; margin-right: 2%">
            <h1 style="color: white">Create Account</h1>
            
            <!--Beginning of Navigation Bar-->
            <div class="row">
                <div class="col-xs-12">
                    <nav class="navbar navbar-inverse" role="navigation">
                        <div class="container-fluid">
                            <ul class="nav navbar-nav lead">
                                <li><a href="index.php">Home</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!--End of Navigation Bar-->
            
        </div>
    </div>
    
    <!--php code for handling data entry-->
    <div class="row">
        <div class="col-xs-12">
            <?php
            $db=connectDB($DBHost, $DBUser, $DBPassword, $DBName);
            
            $selectquery="SELECT * FROM organizations";
            
            $selectresult=queryDB($selectquery, $db);
            
            if($selectresult){
                $numRows=nTuples($selectresult);
                
                $orgSelect="<select class='form-control' type='number' name='orgid'>\n";
                
                
                for($i=0; $i<$numRows; $i++){
                    $selectRow=nextTuple($selectresult);
                    
                    $orgSelect=$orgSelect . "\t<option value=" . $selectRow['orgid'] . ">" . $selectRow['orgid'] . " " . $selectRow['orgName'] .  "</option>\n";
                }
                $orgSelect=$orgSelect . "</select>\n";
            } else {
                punt("Oop! Something went wrong when retreiving the information from the database. The error code was: " . $db->error . "<p>" . $selectquery);
            }
            
            //Code to handle input from form
            //
            if (isset($_POST['submit'])) {
                //only run if form was submitted
                $fname=$_POST['fname'];
                $lname=$_POST['lname'];
                $birthday=$_POST['birthday'];
                $email=$_POST['email'];
                $orgacctype = $_POST['orgacctype'];
                $acctype=$_POST['acctype'];
                $username=$_POST['username'];
                $password=$_POST['password'];
                $pasword2=$_POST['password2'];
                $orgid=$_POST['orgid'];
                //$organization=$_POST['organization'];
                
                
                $errorMessage="";
                $isComplete=true;
                //check for required fields
                if (!$fname){
                    $errorMessage="Please enter your first name.";
                    $isComplete=false;
                }
                if (!$lname){
                    $errorMessage="Please enter your last name.";
                    $isComplete=false;
                    
                if (!$birthday){
                    $errorMessage="Please enter your birthdate.";
                    $isComplete=false;
                }
                }
                if (!$email){
                    $errorMessage="Please enter an email address.";
                    $isComplete=false;
                } else  {
                    $email=makeStringSafe($db, $email);
                }
                //enter code for the acctype
                /*if(!$orgacctype){
                    $errorMessage="Please type either 'admin' or 'user'";
                    $isComplete = false;
                }*/

                
                if (!$username){
                    $errorMessage="Please enter your desired username.";
                    $isComplete=false;
                }
                
                if (!$password){
                    $errorMessage="Please eneter a password";
                    $isComplete=false;
                }
                
                if (!$pasword2){
                    $errorMessage="Please enter your password again.";
                    $isComplete=false;
                }
                
                if ($password != $pasword2) {
                    $errorMessage="Your passwords don't match.";
                    $isComplete=false;
                }
                /*
                if(!$organization){
                    $errorMessage="Please enter an organization.";
                    $isComplete=false;
                }
                */
                
                if (!$isComplete){
                    punt($errorMessage);
                }
                
                //code to check if email is already in the database
                $query="SELECT * FROM pUsers WHERE email='" . $email . "';";
                $result=queryDB($query, $db);
                if(nTuples($result)>0){
                    punt("Sorry but the email " . $email . " is already being used. Please enter another email, or click on <a href='reset.php'>forgot password</a>.");
                }
                
                
                //code to check if the username is already in the database
                $queryU="SELECT * FROM pUsers WHERE username='" . $username . "';";
                $resultU=queryDB($queryU, $db);
                if(nTuples($resultU)>0){
                    punt("Sorry but the username " . $username . " is already being used. Please enter a different usename or click on <a href='reset.php'>forgot pasword</a>.");
                }
                
                //set up code to generate hashedpass
                $hashedpass=crypt($password, getSalt());
                
                //put together sql code to insert tuple or record
                $insert="INSERT INTO pUsers(fname, lname, birthday, email, acctype, username, hashedpass) VALUES ('" . $fname . "', '" . $lname . "', '" . $birthday . "', '" . $email . "', '" . $acctype . "', '" . $username . "', '" . $hashedpass . "');";
                //include_once('getuid.php');

                //run the insert statement
                $result=queryDB($insert, $db);
                
                if(isset($_SESSION['username'])){
                    $getuid="SELECT uid FROM pUsers WHERE username='" . $username . "';";
                    $uidresult=queryDB($getuid, $db);
                    if(nTuples($uidresult)>0){
                        $uidrow=nextTuple($uidresult);
                        
                        $insert2="INSERT INTO userorg(orgid, uid, orgacctype) VALUES('" . $orgid . "', '"  . $uidrow['uid'] . "', '" . $orgacctype . "')";
                        $result2=queryDB($insert2, $db);
                    } else {
                        echo "Could not get User id from database for user " . $username;
                    }
                }

                
                //succefully completed statement
                echo ("Successfully entered " . $fname . " into the database.");
                echo "\n";
                //send them back to login.php
                //header('Location: login.php');
                
            }
            ?>
        </div>    
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <p>If you already have an account, click <a href="login.php">here</a> to login.</p><br>
            <p>All fields marcked with a <em>*</em> are required.</p>
        </div>
    </div>
    
    <!--form for inputting data-->
    <div class="row">
        <div class="col-xs-12">
            <form action="create_users.php" method="post">
                <!-- First Name -->
                <div class="form-group">
                    <label for="fname">First Name <em>*</em></label>
                    <input type="text" class="form-control" name="fname" autofocus required/>
                </div>
                
                <!-- Last Name -->
                <div class="form-group">
                    <label for="lname">Last Name <em>*</em></label>
                    <input type="text" class="form-control" name="lname" autofocus required/>
                </div>
                
                <!-- Birthday -->
                <div class="form-group">
                    <label for="birthday">Birthdate <em>*</em></label>
                    <input type="date" class="form-control" name="birthday" placeholder="mm/dd/yyyy" autofocus required/>
                </div>
                
                <!--Email-->
                <div class="form-group">
                    <label for="email">Email <em>*</em></label>
                    <input type="text" class="form-control" name="email" placeholder="john@doe.com" autofocus required/>
                </div>
                
                <!--AccType-->
                <div class="form-group">
                    <label for="orgacctype">Select Organization Account Type <em>*</em></label>
                    <?php
                        echo "\n<select class='form-control' name='orgacctype' id='orgacctype' autofocus required>";
                        echo "\n<option value='orgadmin'>Organization Administrator</option>";
                        echo "\n<option value='user'>Organization User</option>";
                        echo "\n</select>";
                    ?>
                </div>
                
                <!--AccType-->
                <div class="form-group">
                    <label for="acctype">Select EMS Site Account Type <em>*</em></label>
                    <?php
                        if(isset($_SESSION['username'])){
                            if($acctype=='admin'){
                                echo "\n<select class='form-control' name='acctype' id='acctype' autofocus required>";
                                echo "\n<option value='admin'>Administrator</option>";
                                echo "\n<option value='user'>User</option>";
                                echo "\n</select>";
                            } else {
                                echo "\n<input type='text' class='form-control' name='acctype' value='user' disabled/>";
                            }
                        } else {
                            echo "\n<input type='text' class='form-control' name='acctype' value='user' disabled/>";
                        }
                    ?>
                </div>
                
                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username <em>*</em></label>
                    <input type="text" class="form-control" name="username" autofocus required/>
                </div>
                
                <!--Password-->
                <div class="form-group">
                    <label for="password">Password <em>*</em></label>
                    <input type="password" class="form-control" name="password" autoforcus required/>
                </div>
                
                <!--Password Again-->
                <div class="form-group">
                    <label for="password2">Enter password again <em>*</em></label>
                    <input type="password" class="form-control" name="password2" autofocus required/>
                </div>
                <?php
                    if(isset($_SESSION['username'])){
                        if($acctype=='admin'){
                            echo "\n<div class='form-group'>";
                            echo "\n<label for='orgid'>Select Organization ID <em>*</em></label>";
                            echo "\n" . $orgSelect;
                            echo "\n</div>";
                        }
                    }
                ?>
                
                <button type="submit" class="btn btn-default" name="submit">Add</button>
                <button type="reset" class="btn btn-default" name="reset">Clear Form</button>
            </form>
        </div>
    </div>
</div>
</body>  
</html>