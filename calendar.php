<!-- This page is the home page for the website.

<?php
    //check if user is logged in
    session_start();
    
    /*if(!isset($_SESSION['username'])) {
        //if not logged in, send them to the login page
        header('Location: login.php');
        exit;
    }*/
    if(isset($_GET['orgid'])){
        $orgid=$_GET['orgid'];
    } else {
        punt('Unable to revrieve infromation from Get variable.');
    }
?>
<?php
    include_once("dbutils.php");
    include_once("config.php");

    // get the page we are in
    if (isset($_GET['page'])) {
        $urlTitle = $_GET['page'];
    } else {
        $urlTitle = 'home';
    }
    
    // get all the information about the page based on urlTitle
    // get a handle to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

    $query = "select id, pageTitle, menuTitle, parent, bodyTitle, body from pages where urlTitle='" . $urlTitle . "'";
    
    $result = queryDB($query, $db);
    if ($result) {
        $numberofrows = nTuples($result);
        
        if ($numberofrows > 0) {
            $row = nextTuple($result);
            $id = $row['id'];
            $pageTitle = $row['pageTitle'];
            $menuTitle = $row['menuTitle'];
            $parent = $row['parent'];
            $bodyTitle = $row['bodyTitle'];
            $body = $row['body'];
        } else {
        punt("Something went wrong when retrieving pages from the database.<p>" .
                          "This was the error: " . $db->error . "<p>", $query);
        }
    } else {
        punt("Something went wrong when retrieving pages from the database.<p>" .
                          "This was the error: " . $db->error . "<p>", $query);
    }   
?>

<!-- get basic html for starting the page here -->
<html>

<head>
    <title>Calendar</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>    
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
      
    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">-->
    <?php
        $myquery="SELECT S.link, O.orgName FROM organizations as O, stylesheets as S WHERE O.orgid=" . $orgid . " AND S.sheetid=O.stylesheetid;";
        
        $myresult=queryDB($myquery, $db);
        
        if($myresult){
            $rows=nTuples($myresult);
            if($rows>0){
                $row=nextTuple($myresult);
                $link=$row['link'];
                $orgName=$row['orgName'];
                
            }
            echo "<link rel='stylesheet' href='" . $link . "'/>";
        } else {
            punt("problem getting stylesheet from data base.");
        }
    ?>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Bungee+Inline|Lobster|Rokkitt|Tangerine" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"/>

</head>

<body>
    
<div class="container">

<!-- if you have a site table, you'd get this from there -->
<div class="row">
    <div class="col-xs-10">
        
    </div>
    <div class="col-xs-12">
        <ul class="nav nav-pills">
            <?php
                if(isset($_SESSION['username'])){
                    //echo "<li><a href='input.php'>Edit Site</a></li>";
                    //echo "<li><a href='account.php'>My Account</a></li>";
                    echo "<li><a href='logout.php' style='color: red'>Logout</a></li>";
                } else {
                    echo "<li><a href='login.php'>Login</a></li>";
                }
            ?>
        </ul>
    </div>
</div>
    
<div class="row">
    <div class="col-xs-12">
        <div class="page-header">
            <!-- Header -->
            <!-- Click on site name to go home -->
            <h1><?php echo "<a href='home.php?orgid=" . $orgid . "'>" . $orgName . "</a>"?></h1>
        </div>
    </div>
</div>

<!-- generate top menu bar -->
<div class="row">
    <div class="col-xs-12">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container-fluid">
                <ul class="nav navbar-nav lead">
                    <?php
                        echo "<li><a href='home.php?orgid=" . $orgid . "'>Home</a></li>";
                    ?>
<?php   
    // query to get all child pages to the parent
    // here we assume that the home page has an id=1
    $query = "select urlTitle, menuTitle from pages where parent=1";
    
    $result = queryDB($query, $db);
    if ($result) {
        $numberofrows = nTuples($result);
        
        for($i=0; $i < $numberofrows; $i++) {
            $row = nextTuple($result);

            
            if ($row['urlTitle']==$urlTitle) {
                echo "<li>";
            } else {
                echo "<li>";
            }
            echo "<a href='home.php?page=" . $row['urlTitle'] . "'>" . $row['menuTitle'] . "</a></li>\n";
        }
    } else {
        punt("Something went wrong when retrieving pages from the database.<p>" .
                          "This was the error: " . $db->error . "<p>", $query);
    }
?>
                    <?php
                        echo "<li><a href='calendar.php?orgid=" . $orgid . "'>Calendar</a></li>";
                    ?>
                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=vo0mdmd987gv6fdv0se7401dvo%40group.calendar.google.com&amp;color=%235229A3&amp;ctz=America%2FChicago" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- This is the footer -->
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default" style="padding-top: 2%">
                <div class="panel-body">
                    <?php
                        $queryft="SELECT footerText FROM organizations WHERE orgid=" . $orgid . ";";
                        $resultft=queryDB($queryft, $db);
                        
                        if(nTuples($resultft)>0){
                            $rowft=nextTuple($resultft);
                        
                            echo $rowft['footerText'];
                        }
                        echo "<p style='text-align: right'>Powered by <a href='index.php'>EMS Site Management Service</a></p>";
                    ?>
                </div>
            </div>
        </div>        
    </div>

<!-- close container div -->
</div>

</body>
</html>

<?php
    $db->close();
?>