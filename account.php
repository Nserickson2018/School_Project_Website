<!-- Informatics Project -->
<!-- By Nicholas Erickson, Malachi Melville, and Jacob Sikorski -->

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
    include_once('config.php');
    include_once('dbutils.php');
    
    $db=connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    $username=$_SESSION['username'];
    
    $query="SELECT * FROM pUsers WHERE username='" . $username . "';";
    $result=queryDB($query, $db);
    if(nTuples($result)>0){
        $row=nextTuple($result);
        $id=$row['uid'];
        $fname=$row['fname'];
        $lname=$row['lname'];
        $birthday=$row['birthday'];
        $email=$row['email'];
        $hashedpass=$row['hashedpass'];
        //$orgid=$row['orgid'];
    }
    
?>

<html lang="en">
<head>
    
    <title>My Account</title>
    
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
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>My Account</h1>
            </div>
            
            <!-- generate top menu bar -->
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
            
            <!-- Display the user's account information -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <p id="id">Account ID: <?php echo $id; ?></p><br>
                    <p id="fname">First Name: <?php echo $fname; ?></p><br>
                    <p id="lname">Last Name: <?php echo $lname; ?></p><br>
                    <p id="birthday">Birthdate: <?php echo $birthday; ?></p><br>
                    <p id="email">Email: <?php echo $email; ?></p><br>
                    <p id="username">Username: <?php echo $username; ?></p><br>

                    
                    <p hidden id="hashedpass"><?php echo $hashedpass; ?></p><br>
                    <?php
                        //sql statement
                        $queryedit="SELECT uid, fname, lname, birthday, email, username FROM pUsers WHERE uid=" . $id . ";";
                        
                        $resultedit=queryDB($queryedit, $db);
                        
                        if ($resultedit){
                            $numrows=nTuples($resultedit);
                            
                            for($a=0; $a<$numrows; $a++){
                                $row=nextTuple($resultedit);
                                
                                echo "\n <button type='button' class='btn btn-default' onclick='" . "editRecord(" . '"' . $row['uid'] . '", "' . $row['fname'] . '", "'
                                . $row['lname'] . '", "' . $row['birthday'] . '", "' . $row['email'] . '", "' . $row['username'] . '"' . ");'>Edit</button>";
                            }
                        } else {
                            punt("Something went wrong when retrieving pages from the database.<p>" .
                                            "This was the error: " . $db->error . "<p>", $query);
                        }
                        
                        //$db->close;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- This is the footer -->
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default" style="padding-top: 2%">
                <div class="panel-body">
                    <p>&copy; 2016 EMS Site Management Service. All Rights Reserved.</p>
                    <?php
                        echo "<p style='text-align: right'>Powered by <a href='index.php'>EMS Site Management Service</a></p>";
                    ?>
                </div>
            </div>
        </div>        
    </div>
</div>


<form id="dialog-form" title="Edit User" style="display: none">
    <fieldset>
    <div class="form-group">
        <label for="editid">User ID</label>
        <input type="text" class="form-control" name="editid" id="editid" disabled="disabled" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editfname">First Name</label>
        <input type="text" class="form-control" name="editfname" id="editfname" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editlname">Last Name</label>
        <input type="text" class="form-control" name="editlname" id="editlname" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editbirthday">Birthdate</label>
        <input type="text" class="form-control" name="editbirthday" id="editbirthday" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editemail">Email</label>
        <input type="text" class="form-control" name="editemail" id="editemail" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editusername">Username</label>
        <input type="text" class="form-control" name="editusername" id="editusername" disabled="disabled" autofocus/>
    </div>
    </fieldset>
</form>
<script>
    // pop up a form to edit a record that provides option to cancel or save changes
    function editRecord(id, fname, lname, birthday, email, username) {
        document.getElementById("editid").value=id;
        document.getElementById("editfname").value = fname;
        document.getElementById("editlname").value = lname;
        document.getElementById("editbirthday").value = birthday;
        document.getElementById("editemail").value = email;
        document.getElementById("editusername").value = username;
        
        //$("#editid").hide();

        $("#dialog-form").dialog("open");        
    }
    
    $("#dialog-form").dialog(
        {
            autoOpen: false,
            height: 700,
            width: 600,
            modal: true,
            buttons: {
                "Save": function() {
                    var xmlhttp = new XMLHttpRequest();
            
                    // this part of code receives a response from editpage.php 
                    xmlhttp.onreadystatechange=function() {
                        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                            if(xmlhttp.responseText == "Page edited") {
                                location.reload();
                            } else {
                                alert("Unsuccessful save: " + xmlhttp.responseText);
                                location.reload();
                            }
                        }
                    };
                                      
                    // this sends the data request to deleteperson.php
                    xmlhttp.open("POST", "edituser.php", true);
                    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    
                    // get variables
                    var editid=document.getElementById("editid").value;
                    var editfname=document.getElementById("editfname").value;
                    var editlname=document.getElementById("editlname").value;
                    var editbirth=document.getElementById("editbirthday").value;
                    var editemail=document.getElementById("editemail").value;
                    var editusername=document.getElementById("editusername").value;
                    
                    //alert("id: " + editid + ", username: " + editusername);
                    
                    // send data to editpage.php
                    xmlhttp.send("id=" + editid + "&fname=" + editfname + "&lname=" + editlname + "&birth=" + editbirth +
                                 "&email=" + editemail + "&username=" + editusername);
                },
                "Cancel": function() {
                    $(this).dialog("close");       
                }
            }
        }
                             
                             );
    
    
</script>
</body>
</html>