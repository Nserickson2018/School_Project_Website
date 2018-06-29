<!-- Informatics Project -->
<!-- By: Nicholas Erickson, Malachi Melville, Jacob Sikorski -->

<!-- This page will display all users and a delete button if that user
needs to be removed. This will only work for administrators.-->

<!DOCTYPE html>
    
<html lang='en'>
    
    <head>
        <title>EMS Site Management System</title>
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <script src="http://code.jquery.com/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>    
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://bootswatch.com/cyborg/bootstrap.min.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
        <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Bungee+Inline|Lobster|Rokkitt|Tangerine" rel="stylesheet"> 
        <link rel="stylesheet" href="styles.css"/>
        
        <?php
            include_once('config.php');
            include_once('dbutils.php');
        ?>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-header">
                        <!-- Header -->
                        <h1 style="text-align: center">Welcome to EMS Site Management System</h1>
                    </div>
                </div>
            </div><!--Closing header tag -->
            <aside>
                <div class="btn-group-vertical" role="group">
                    <?php
                        session_start();
                        
                        if(!isset($_SESSION['username'])){
                            
                            echo "<a href='login.php' class='btn btn-default'>Login</a>";
                        } else {
                            include_once("getAccType.php");
                            echo "<a href='logout.php' class='btn btn-default'>Logout</a>";
                            echo "<a href='account.php' class='btn btn-default'>My Account</a>";
                            if($acctype=='admin'){
                                echo "<button type='button' class='btn btn-default' onclick='createsite();'>Create New Site</button>";
                                echo "<a href='create_users.php' class='btn btn-default'>Create User</a>";
                                echo "<a href='users_list.php' class='btn btn-default'>List Users</a>";
                            }
                        }
                    ?>
                </div>
            </aside>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                            // get a handle to the database
                            $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
                            echo "<table class='table table-striped table-hover'>";
                            //title of table
                            echo "\n <thead>";
                                echo "\n <tr>";
                                    echo "\n <th>First Name</th>";
                                    echo "\n <th>Last Name</th>";
                                    echo "\n <th>Username</th>";
                                    echo "\n <th>Account Type</th>";
                                    echo "\n <th>Email</th>";
                                    echo "\n <th></th>";
                                echo "\n </tr>";
                            echo "\n </thead>";
                            
                            echo "\n <tbody>";
                            $query="SELECT fname, lname, username, acctype, email FROM pUsers;";
                            
                            $result=queryDB($query, $db);
                            
                            if($result){
                                $numrows=nTuples($result);
                                for($a=0; $a<$numrows; $a++){
                                    $row=nextTuple($result);
                                    echo "\n <tr>";
                                    echo "\n <td>" . $row['fname'] . "</td>";
                                    echo "\n <td>" . $row['lname'] . "</td>";
                                    echo "\n <td>" . $row['username'] . "</td>";
                                    echo "\n <td>" . $row['acctype'] . "</td>";
                                    echo "\n <td>" . $row['email'] . "</td>";
                                    echo "\n <td>";
                                    if($row['acctype']!='admin'){
                                        echo "\n <td><button type='button' class='btn btn-default' onclick='deleteRecord(" . '"' . $row['username'] . '", "' . $row['fname'] . '"' . ");'>Delete</button></td>";
                                    }
                                    echo "\n </tr>";
                                }
                            } else {
                                echo "Something went wrong with retreiving the information from the database.";
                            }
                            echo "\n </tbody>";
                            echo "\n </table>";
                    ?>
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
        </div><!-- Closing container tag -->
        <script>
        // confirm that a user wants to delete, then call php script to do deletion
        function deleteRecord(username, name) {
            // delete record from pages table identified by id, if user agrees
            var decision = confirm("Would you like to delete " + name + "?");
            if (decision === true) {
                var xmlhttp = new XMLHttpRequest();
                
                // this part of code receives a response from deleteperson.php 
                xmlhttp.onreadystatechange=function() {
                    alert('ReadyState=' + xmlhttp.readyState + '. Status=' + xmlhttp.status);
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        if(xmlhttp.responseText == "User deleted") {
                            alert("User has been deleted");
                            location.reload();
                        } else {
                            alert("Unsuccessful delete: " + xmlhttp.responseText);
                        }
                    }
                };
                
                // this sends the data request to deleteperson.php
                xmlhttp.open("POST", "deleteusers.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send("username=" + username);
            }
        }
    </script>
    </body>
</html>
