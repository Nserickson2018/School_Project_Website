<!DOCTYPE html>
<!-- Informatics Project -->
<!-- By: Nicholas Erickson, Malachi Melville, Jacob Sikorski -->

<!-- This page will be the home page for our organization site
creation service. It will have an option to either go to a site
that has already been created or to create a new organization
based site. -->



<html lang="en">

<!-- Head (not seen)-->
<head>
    <?php
        //these files contain functions and database login information
        include_once("config.php");
        include_once("dbutils.php");
        
        // get a handle to the database
        $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
        
        //get the information from the stylesheets page
        $query="SELECT * FROM stylesheets";
        
        //run the query
        $result=queryDB($query, $db);
        
        //if there is a result...
        if($result){
            //get the number of rows for the result
            $numRows=nTuples($result);
            
            //set up the select statement for the html
            $stylesheetSelect="<select class='form-control' name='stylesheet' id='stylesheet' autofocus>\n";
            
            //make a loop to go the the number of rows
            for ($i=0; $i<$numRows; $i++) {
                //get each row of data
                $row=nextTuple($result);
                
                //get the values and set them in the select statement 
                $stylesheetSelect=$stylesheetSelect . "\t<option value='" . $row['sheetid'] . "'>" . $row['sheetName'] . "</option>\n";
            }
            //close the select statement 
            $stylesheetSelect=$stylesheetSelect . "</select>\n";
        } else {
            //if there was no result, throw an error that tells them something wetn wrong with the database.
            punt("Oops, something went wrong when retrieving stylesheets from the database.<p>" . "\nThis was the error: " . $db->error . "<p>" . $query);
        }
        
        
    ?>
    <!-- This is the site name-->
    <title>EMS Site Management System</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Set up basic stylesheets and fonts -->
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>    
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
      
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://bootswatch.com/cyborg/bootstrap.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Bungee+Inline|Lobster|Rokkitt|Tangerine" rel="stylesheet"> 
    <link rel="stylesheet" href="styles.css"/>
</head><!-- Close the head -->

<!-- Starting the body of the page -->
<body>
<div class="container"><!-- Main content of the page -->
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header"><!-- Visible Page Header -->
                <!-- Header -->
                <h1 style="text-align: center">Welcome to EMS Site Management System</h1><!-- Displayed Page Header -->
            </div>
        </div>
    </div>
    <!-- Make an aside for the page -->
    <aside>
        <div class="btn-group-vertical" role="group">
            <?php
                //start a sesion using username as the login
                session_start();
                
                //only show certain buttons if the person is logged into the site and based on what type of account they have
                if(!isset($_SESSION['username'])){
                    //if the user not logged in, only display the login button
                    echo "<a href='login.php' class='btn btn-default'>Login</a>";
                } else {
                    //if the user is logged in, display the logout, create site, and my account buttons for everyone
                    include_once("getAccType.php");
                    echo "<a href='logout.php' class='btn btn-default'>Logout</a>";
                    echo "<button type='button' class='btn btn-default' onclick='createsite();'>Create New Site</button>";
                    echo "<a href='account.php' class='btn btn-default'>My Account</a>";
                    if($acctype=='admin'){
                        //if the user is logged in as an administrator, display the buttons to create users and list users 
                        echo "<button type='button' class='btn btn-default' onclick='createsite();'>Create New Site</button>";
                        echo "<a href='create_users.php' class='btn btn-default'>Create User</a>";
                        echo "<a href='users_list.php' class='btn btn-default'>List Users</a>";
                    }
                }
            ?>
            <a href="portfolio.php" class="btn btn-default">About Me</a>
        </div>
    </aside><!-- Close Aside tag -->
    <?php
        //display different text depending on wether the user is logged in or not
        if(isset($_SESSION['username'])){//user is logged in
            echo "<p style='color: white; padding-left: 1%'>Wecome back to EMS Site Managament Service.<br> You are signed in as " . $_SESSION['username'] . ".</p>";
        } else {//user is not logged in
            echo "<p style='color: white; padding-left: 1%'>Hello, welcome to EMS Site Management Service. We offer services to help you create the perfect site for your sudent organization. If you have an account
            you may click the button to the left. <br> If you would like to create a site but don't have an account <a href='create_users.php'>click here </a> to get started.</p>";
        }
        
    ?>
    
    <div class="row"><!-- Table to display sites -->
        <div class="col-xs-12">
            <!-- If you are logged in a table of the sites you are associated with, will appear -->
            <?php
                if(isset($_SESSION['username'])){//logged in
                    //query to get the data from the 'pUsers' table
                    $getuid="SELECT * FROM pUsers WHERE username='" . $_SESSION['username'] . "';";
                    
                    //run the query
                    $uidresult=queryDB($getuid, $db);
                    
                    //if there are any results...
                    if (nTuples($uidresult)>0){
                        //get data for each row
                        $uidrow=nextTuple($uidresult);
                        
                        //get the user id from the table
                        $uid=$uidrow['uid'];
                    }
                    //set up table using html
                    echo "<table class='table table-striped table-hover'>";
                    //title of table
                    echo "\n <thead>";
                        echo "\n <tr>";
                            //table column names
                            echo "\n <th>Site Id</th>";
                            echo "\n <th>Site Name</th>";
                            echo "\n <th>Stylesheet Used</th>";
                        echo "\n </tr>";
                    echo "\n </thead>";
                    
                    echo "\n <tbody>";
                    //only show the data if the account type is admin
                    if($acctype=='admin'){//user is an administrator
                        //only need to get organization id, organization name, the stylesheet, and whether the site has been verified
                        $table="Select o.orgid, o.orgName, s.sheetName, o.verified FROM organizations as o, stylesheets as s WHERE s.sheetid=o.stylesheetid;";
                    } else {// user is not an administrator
                        //prepare sql statement to get data for the table
                        $table="SELECT O.orgid, O.orgName, S.sheetName, O.verified FROM organizations as O, userorg as U, stylesheets as S WHERE U.uid=" . $uid . " AND O.orgid=U.orgid AND S.sheetid=O.stylesheetid;";
                    }
                    
                    //run query to get organization information 
                    $tbresult=queryDB($table, $db);
                    
                    //if there is a result
                    if($tbresult){
                        //get data from each row
                        $rows=nTuples($tbresult);
                        
                        //start a loop to cycle through the number of results
                        for($n=0; $n<$rows; $n++){
                            
                            //set the data for each row
                            $tbrow=nextTuple($tbresult);
                            
                            //put the data in the table
                            if($acctype=='admin'){//is the user an administrator ...
                                if($tbrow['verified']=='yes'){//... if the site on the table has been activated, display ...
                                    echo "\n <tr>";
                                    echo "\n <td>" . $tbrow['orgid'] . "</td>";//... the organization id, ...
                                    echo "\n <td><a href='home.php?orgid=" . $tbrow['orgid'] . "'>" . $tbrow['orgName'] . "</a></td>";//... the name of the organization with a link to the homepage, ...
                                    echo "\n <td>" . $tbrow['sheetName'] . "</td>";// ... the stylesheet used ...
                                    echo "\n <td><button type='button' class='btn btn-default' onclick='deleteRecord(" . '"' . $tbrow['orgid'] . '"' . ", " . '"' . $tbrow['orgName'] . '"' . ");'>Delete</button></td>"; //... and the button to delete that site if necessary.
                                } else {// If the site has not been activated the only thing diffrent will be a 'Verify' button for the administrator to activate it
                                    echo "\n <tr>";
                                    echo "\n <td>" . $tbrow['orgid'] . "</td>";
                                    echo "\n <td><a href='home.php?orgid=" . $tbrow['orgid'] . "'>" . $tbrow['orgName'] . "</a></td>";
                                    echo "\n <td>" . $tbrow['sheetName'] . "</td>";
                                    echo "\n <td><form action='#' method='post'><input type='submit' name='Verify' value='Verify' style='color: red;'/></form></td>";
                                    if(isset($_POST['Verify'])){
                                        $verifyQuery="UPDATE organizations SET verified='yes' WHERE organizations.orgid=" . $tbrow['orgid'] . ";";
                                        $verifyQueryResult=queryDB($verifyQuery, $db);
                                        header("Refresh:0");
                                    }
                                    //use this button to run the javascript that deletes the information
                                    echo "\n <td><button type='button' class='btn btn-default' onclick='deleteRecord(" . '"' . $tbrow['orgid'] . '"' . ", " . '"' . $tbrow['orgName'] . '"' . ");'>Delete</button></td>";
                                }
                            } else {
                                if($tbrow['verified']=='yes'){
                                    echo "\n <tr>";
                                    echo "\n <td>" . $tbrow['orgid'] . "</td>";
                                    echo "\n <td><a href='home.php?orgid=" . $tbrow['orgid'] . "'>" . $tbrow['orgName'] . "</a></td>";
                                    echo "\n <td>" . $tbrow['sheetName'] . "</td>";
                                } else {
                                    echo "\n <tr>";
                                    echo "\n <td>" . $tbrow['orgid'] . "</td>";
                                    echo "\n <td><a href='#'>" . $tbrow['orgName'] . "</a></td>";
                                    echo "\n <td>" . $tbrow['sheetName'] . "</td>";
                                }
                            }
                            echo "\n </tr>";
                        }
                    }
                    echo "\n </tbody>";
                    echo "</table>";//close the table html tag
                }
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
</div><!-- close footer tag-->

<!-- form to create a new site -->
<div id="dialog-form" title="Create Form" style="display: none">
<form enctype="multipart/form-data" id="createform">
    <fieldset>
    <!-- this block will be for the basic organization information -->
    <legend style="color: black">Organization Information</legend>
    
    <!-- Organization Name -->
    <div class="form-group">
        <label for="orgName">Organization Name</label>
        <input type="text" class="form-control" name="orgName" id="orgName" autofocus/>
    </div>
    
    <!-- Specific footer text for that organization -->
    <div class="form-group">
        <label for="footerText">Footer Text</label>
        <input type="text" class="form-control" name="footerText" id="footerText" autofocus/>
    </div>
    
    <!-- select what style you would like for your site-->
    <div class="form-group">
        <label for="stylesheet">Select Stylesheet</label>
        <?php echo $stylesheetSelect; ?>
    </div>
    
    <!-- Generates a 'gallery' to give an example of the different styles that can be used -->
    <!-- This is a preview gallery only, no selections take place here. -->
    <div class="form-group">
    <div id="mydiv" style="margin-left: 50px; margin-bottom: 50px">
        <h3>Stylesheets</h3>
        <div class="gallery">
            <img alt='cerulean' src="https://bootswatch.com/cerulean/thumbnail.png"/>
            <img alt='cosmo' src="https://bootswatch.com/cosmo/thumbnail.png"/>
            <img alt='cyborg' src="https://bootswatch.com/cyborg/thumbnail.png"/>
            <img alt='darkly' src="https://bootswatch.com/darkly/thumbnail.png"/>
            <img alt='flatly' src="https://bootswatch.com/flatly/thumbnail.png"/>
            <img alt='journal' src="https://bootswatch.com/journal/thumbnail.png"/>
            <img alt='lumen' src="https://bootswatch.com/lumen/thumbnail.png"/>
            <img alt='paper' src="https://bootswatch.com/paper/thumbnail.png"/>
            <img alt='readable' src="https://bootswatch.com/readable/thumbnail.png"/>
            <img alt='sandstone' src="https://bootswatch.com/sandstone/thumbnail.png"/>
            <img alt='simplex' src="https://bootswatch.com/simplex/thumbnail.png"/>
            <img alt='slate' src="https://bootswatch.com/slate/thumbnail.png"/>
            <img alt='spacelab' src="https://bootswatch.com/spacelab/thumbnail.png"/>
            <img alt='superhero' src="https://bootswatch.com/superhero/thumbnail.png"/>
            <img alt='united' src="https://bootswatch.com/united/thumbnail.png"/>
            <img alt='yeti' src="https://bootswatch.com/yeti/thumbnail.png"/>
        </div>
    </div>
    </div>
    
    <!-- orgid is hidden because the database will automatically create an id -->
    <input type="hidden" name="orgid" id="orgid"/>
    </fieldset><!-- closes organization information -->
    
    <!-- Creates the home page -->
    <fieldset>
    <legend style="color: black">Home Page Information</legend>
            <!-- Displayed page title -->
            <div class="form-group">
                <label for="pageTitle">Page Title</label>
                <input type="text" class="form-control" name="pageTitle" id="pageTitle" autofocus/>
            </div>
            
            <!-- Name of page to be displayed in the menu -->
            <div class="form-group">
                <label for="menuTitle">Menu Title</label>
                <input type="text" class="form-control" name="menuTitle" id="menuTitle" autofocus/>
            </div>
            
            <!-- make a title for the body content of the page -->
            <div class="form-group">
                <label for="bodyTitle">Body Title</label>
                <input type="text" class="form-control" name="bodyTitle" id="bodyTitle" autofocus/>
            </div>
            
            <!-- Body content of the page -->
            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" name="body" id="body" rows="5" autofocus></textarea>
            </div>
            
            <!-- optionally, you can create an 'asside' off to the left side of the page -->
            <div class="form-group">
                <label for="asideTitle">Side Panel Title(optional)</label>
                <input type="text" class="form-control" name="asideTitle" id="asideTitle" autofocus/>
            </div>
            
            <!-- this is for the body of the aside, again this is optional -->
            <!-- but this will only work if there is an aside title -->
            <div class="form-group">
                <label for="asideBody">Side Panel Body(optional)</label>
                <textarea class="form-control" name="asideBody" id="asideBody" autofocus></textarea>
            </div>
            
            <!-- this uses radio buttons to determine if you want a picture. -->
            <!-- if you do want a picture, this also selects where it will be placed -->
            <div class="form-group">
                <label class="col-lg-2 control-label">Template</label>
                <div class="col-lg-10">
                    <div class="radio">
                    <!-- No picture -->
                    <label  style="margin-top: 10px">
                        <input name="template" id="template1" value="1" type="radio">
                        Default, no images or videos
                    </label>
                    </div>
                <!-- Picture in the middle of the page below the menu bar -->
                <div class="radio">
                  <label>
                    <input name="template" id="template2" value="2" type="radio">
                    One image/video, middle of page below the menu bar
                  </label>
                </div>
                <!-- picture is below the body text and to the right side of the page -->
                <div class="radio">
                  <label>
                    <input name="template" id="template3" value="3" type="radio">
                    One image/video, right side of page below body text
                  </label>
                </div>
                
                <!-- picture is below the body text and to the left side of the page -->
                <div class="radio">
                  <label>
                    <input name="template" id="template4" value="4" type="radio">
                    One image/video, left side of page below body text
                  </label>
                </div>
            </div>
            
            <!-- allows you to select a file to upload from your computer --> 
            <div class="form-group">
                <label for="image">Image Name(optional)</label>
                <input type="file" class="form-control" name="image" id="image" autofocus/> 
            </div>
            
            <!-- urlTitle is set automatically to home -->
            <!-- all pages created with in the organization will be able to have a urlTitle chosen for it. -->
            <input type="hidden" class="form-control" name="urlTitle" id="urlTitle" value="home" 
            <?php
                //this send the account type and user id within the form automatically
                echo "<input type='hidden' name='acctype' id='acctype' value='" . $acctype . "'/>";
                echo "<input type='hidden' name='uid' id='uid' value='" . $uid . "'/>";
            ?>

        </div>
    </fieldset>
</form><!-- Closes the form tag -->
</div><!-- close the container tag -->
<script>
    // confirm that a user wants to delete, then call php script to do deletion
    function deleteRecord(id, name) {
        alert(orgid);
        // delete record from pages table identified by id, if user agrees
        var decision = confirm("Would you like to delete " + name + "?");
        if (decision === true) {
            var xmlhttp = new XMLHttpRequest();
            
            // this part of code receives a response from deleteperson.php 
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    if(xmlhttp.responseText == "Organization deleted") {
                        location.reload();
                    } else {
                        //alert("Unsuccessful delete: " + xmlhttp.responseText);
                        location.reload();
                    }
                }
            };
            
            // this sends the data request to deleteperson.php
            xmlhttp.open("POST", "deleteorgs.php", true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("orgid=" + id);
        }
    }
        // pop up a form to edit a record that provides option to cancel or save changes
    function createsite() {
        //opens the pop up with the form inside
        $("#dialog-form").dialog("open");
    }
    
    //uses the information from the form 
    $("#dialog-form").dialog(
        {
            //set parameters for the pop up window
            autoOpen: false,
            height: 500,
            width: 600,
            modal: true,
            buttons: {
                //set up buttons
                //this one sends the data to be processed
                "Save": function() {
                    var xmlhttp = new XMLHttpRequest();
            
                    // this part of code receives a response from createsite.php 
                    xmlhttp.onreadystatechange=function() {
                        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                            if(xmlhttp.responseText == "Site Created") {
                                //if the site was created successfully, close window and reload the page
                                alert("Site Successfully Created");
                                location.reload();
                            } else {
                                //otherwise show the error message and reload the page
                                alert("Unsuccessful save: " + xmlhttp.responseText);
                                location.reload();
                            }
                        }
                    };                  
                    
                    var form = document.getElementById('createform');
                    var formData = new FormData(form);
                    //alert("hello3");
                    // this sends the data request to deleteperson.php
                    xmlhttp.open("POST", "createsite.php", true);
                    //xmlhttp.setRequestHeader("Content-Type","multipart/form-data");
                    
                    xmlhttp.send(formData);
                    
                    
                    // this sends the data request to deleteperson.php
                    //xmlhttp.open("POST", "createsite.php", true);
                    //xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    
                },
                //this closes the window without sending or saving the information
                "Cancel": function() {
                    $(this).dialog("close");       
                }
            }
        }
                             
                             );
    
</script>
</body><!-- close body tag -->
</html>
