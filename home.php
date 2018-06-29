<!-- This page is the home page for the website.-->

<?php
    include_once("dbutils.php");
    include_once("config.php");
    //check if user is logged in
    session_start();
    
    /*if(!isset($_SESSION['username'])) {
        //if not logged in, send them to the login page
        //header('Location: login.php');
        $user="SELECT * FROM ";
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
    //include_once("getAccType.php");

    // get the page we are in
    if (isset($_GET['page'])) {
        $urlTitle = $_GET['page'];
    } else {
        $urlTitle = 'home';
    }
    
    // get all the information about the page based on urlTitle
    // get a handle to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

    $query = "SELECT * FROM pages WHERE urlTitle='" . $urlTitle . "' AND orgid=" . $orgid . ";";
    
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
            $asideTitle=$row['asideTitle'];
            $asideBody=$row['asideBody'];
            $template=$row['template'];
            $image=$row['image'];
        } else {
        punt("Something went wrong when retrieving pages from the database.<p>" .
                          "This was the error: " . $db->error . "<p>", $query);
        }
    } else {
        punt("Something went wrong when retrieving pages from the database.<p>" .
                          "This was the error: " . $db->error . "<p>", $query);
    }
    
    $query2="SELECT orgid, orgName FROM organizations WHERE orgid=" . $orgid . ";";
    
    $result2=queryDB($query2, $db);
    
    if($result2){
        
    }
?>

<!DOCTYPE html>
<!-- get basic html for starting the page here -->
<html>

<head>
    <title><?php echo $pageTitle ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>    
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

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
                    include_once("getAccType.php");
                    //if($acctype=='admin'){
                    //    echo "<li><a href='input.php?orgid=" . $orgid . "'>Add Page</a></li>";
                    //}
                    if($orgacctype=='orgadmin'){
                        echo "<li><a href='input.php?orgid=" . $orgid . "'>Add Page</a></li>";
                    }
                    $editquery="SELECT * from pages WHERE orgid=" . $orgid . " AND id=" . $id . " ORDER BY parent;";
                    
                    $editqueryResult=queryDB($editquery, $db);
                    
                    if($editqueryResult){
                        $numRows=nTuples($editqueryResult);
                        
                        for($x=0; $x<$numRows; $x++){
                            $editRow=nextTuple($editqueryResult);
                            if($acctype=='admin'){
                            echo "<li><a onclick='" . "editRecord(" . '"' . $editRow['id'] . '", "' .
                                $editRow['urlTitle'] . '", "' . $editRow['pageTitle'] . '", "' . $editRow['menuTitle'] .
                                '", "' . $editRow['bodyTitle'] . '", ' . str_replace('\'', '&#39;', json_encode($editRow['body'])) .
                                ', "' . $editRow['asideTitle'] . '", ' . str_replace('\'', '&#39;', json_encode($editRow['asideBody'])) . ', "' . $editRow['parent'] .
                                '", "' . $editRow['orgid'] . '", "' . $editRow['template'] . '", "' . $editRow['image'] . '"' . ");' href='javascript:void(0)'>Edit Page</a></li>";
                            }
                            elseif($orgacctype=='orgadmin'){
                                echo "<li><a onclick='" . "editRecord(" . '"' . $editRow['id'] . '", "' .
                                $editRow['urlTitle'] . '", "' . $editRow['pageTitle'] . '", "' . $editRow['menuTitle'] .
                                '", "' . $editRow['bodyTitle'] . '", ' . str_replace('\'', '&#39;', json_encode($editRow['body'])) .
                                ', "' . $editRow['asideTitle'] . '", ' . str_replace('\'', '&#39;', json_encode($editRow['asideBody'])) . ', "' . $editRow['parent'] .
                                '", "' . $editRow['orgid'] . '", "' . $editRow['template'] . '", "' . $editRow['image'] . '"' . ");' href='javascript:void(0)'>Edit Page</a></li>";
                           
                            }
                        }
                    }

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
            <?php
                echo "<h1><a href='home.php?orgid=" . $orgid . "'>" . $orgName . "</a></h1>";
            ?>
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
    $query = "select urlTitle, menuTitle from pages where parent=1 and orgid=" . $orgid . ";";
    
    $result = queryDB($query, $db);
    if ($result) {
        $numberofrows = nTuples($result);
        
        for($i=0; $i < $numberofrows; $i++) {
            $row = nextTuple($result);

            
            if ($row['urlTitle']==$urlTitle) {
                echo "<li class='active'>";
            } else {
                echo "<li>";
            }
            echo "<a href='home.php?page=" . $row['urlTitle'] . "&orgid=" . $orgid . "'>" . $row['menuTitle'] . "</a></li>\n";
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

<!-- Generate left-side menu if necessary -->
<?php
    // use this boolean to check whether we are having this menu or not
    $leftSideMenuOn = false;

    // check if this page needs to display a left-side menu
    if ($parent > 0) {
        
        if ($parent == 1) {
            // if it's a second level page, show its children on the left side menu
            $query = "select urlTitle, menuTitle from pages where parent=" . $id . " and orgid=" . $orgid . " order by menuTitle";
        } else {
            // if it's a third or lower level page, show its siblings on the left side menu
            $query = "select urlTitle, menuTitle from pages where parent=" . $parent . " and orgid=" . $orgid . " order by menuTitle";
        }
        
        $result = queryDB($query, $db);
        if ($result) {
            $numberofrows = nTuples($result);
            
            if ($numberofrows > 0) {
                // if this is the case, then we show it
                $leftSideMenuOn = true;
                
                $leftSideMenu = "\t<div class='col-xs-2'>\n";
                $leftSideMenu .= "\t\t<table class='table table-hover text-left'>\n";
            
                for($i=0; $i < $numberofrows; $i++) {
                    $row = nextTuple($result);
                    
                    $leftSideMenu .= "\t\t\t<tr><td><a href='home.php?page=" . $row['urlTitle'] . "&orgid=" . $orgid ."'>". $row['menuTitle'] ."</a></td></tr>\n";
                }
                
                $leftSideMenu .= "\t\t</table>\n";
                $leftSideMenu .= "\t</div>\n";
                $leftSideMenu .= "\t<div class='col-xs-10'>\n";
            } 
        }
    }
    if (!$leftSideMenuOn) {
        $leftSideMenu = "\t<div class='col-xs-12'>\n";
    }
?>

<!-- Generate breadcrumbs if necessary -->
<?php
    $breadcrumbs = "";
    
    // if this is at least a third-level page (assuming home has parent -1 and is of id 1)
    if ($parent > 1) {
        // setup the breadcrumbs
        $breadcrumbs = "<ol class='breadcrumb'>\n";
        
        $currParent = $parent;
        $innerLinks = "";
        
        // we will iterate all the way to the home page and stop when the parent = -1, meaning we got to the home page
        while ($currParent != -1) {
            // get the parent
            $query = "select urlTitle, menuTitle, parent from pages where id=" . $currParent . " and orgid=" . $orgid . ";";
            
            $result = queryDB($query, $db);
            if ($result) {
                $numberofrows = nTuples($result);
                if ($numberofrows > 0) {
                    $row = nextTuple($result);
                    
                    // add <li> item to breadcrumbs before the previous items, because we are moving up the hierarchy
                    $innerLinks = "\t\t\t<li><a href='home.php?page=" . $row['urlTitle'] . "&orgid=" . $orgid ."'>" . $row['menuTitle'] . "</a></li>\n" . $innerLinks;
                    
                    $currParent = $row['parent'];
                } else {
                    $currParent = -1;
                }
            } else {
                $currParent = -1;
            }               
        }
        
        $breadcrumbs .= $innerLinks;
        $breadcrumbs .= "\t\t\t<li class='active'>" . $menuTitle . "</li>\n";
        $breadcrumbs .= "\t\t</ol>\n    ";
    }
?>

<!-- Middle area of site -->
<div class="row">
<!-- Add left-side menu if necessary -->
<?php echo $leftSideMenu; ?>
        
        <!-- This is the spot for the main content -->
        <?php echo $breadcrumbs; ?>
        <!-- Area for pictures -->
        <?php
            if($template==2){
                echo "<img src='images/" . $image . "' class='image-responsive' alt='index' style='display:block; margin:auto; vertical-align: middle'/>" ;
            }
        ?>
    <aside>
        <h4><?php echo $asideTitle; ?></h4>
        <p>
            <?php echo $asideBody; ?>
        </p>
    </aside>
    <h2><?php echo $bodyTitle; ?></h2>
        <p>
           <?php echo $body; ?>
        </p>
        <?php
         if($template==3){
             echo "<img src='images/" . $image . "' class='image-responsive' alt='index' style='display:block; float:right; padding-top:8%'/>";
         } elseif($template==4) {
             echo "<img src='images/" . $image . "' class='image-responsive' alt='index' style='display:block; float:left; padding-top: 8%'/>";
         }
        ?>

    </div> <!-- close content area of page-->
</div>

<!-- This is the footer -->
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default" id="myPanel">
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

<!-- Code for editing form -->
<div id="dialog-form" title="Edit page">
<form enctype="multipart/form-data" id="editform">
    <fieldset>
    <div class="form-group">
        <label for="editurlTitle">URL Title</label>
        <input type="text" class="form-control" name="editurlTitle" id="editurlTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editparent">Parent Page</label>
        <?php
            if($parent=='Home'){
                echo "<input type='text' class='form-control' name='editparent' id='editparent' disabled='disabled' autofocus/>";
            } else {
                echo "<input type='text' class='form-control' name='editparent' id='editparent' autofocus/>";
            }
        ?> 
    </div>
    
    <div class="form-group">
        <label for="editpageTitle">Page Title</label>
        <input type="text" class="form-control" name="editpageTitle" id="editpageTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editmenuTitle">Menu Title</label>
        <input type="text" class="form-control" name="editmenuTitle" id="editmenuTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editbodyTitle">Body Title</label>
        <input type="text" class="form-control" name="editbodyTitle" id="editbodyTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editbody">Body</label>
        <textarea class="form-control" name="editbody" id="editbody" rows="5" autofocus></textarea>
    </div>

    <div class="form-group">
        <label for="editasideTitle">Side Panel Title(optional)</label>
        <input type="text" class="form-control" name="editasideTitle" id="editasideTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editasideBody">Side Panel Body(optional)</label>
        <textarea class="form-control" name="editasideBody" id="editasideBody" autofocus></textarea>
    </div>
    
    <div class="form-group">
      <label class="col-lg-2 control-label">Template(optional)</label>
      <div class="col-lg-10">
        <div class="radio">
          <label  style="margin-top: 10px">
            <input name="edittemplate" id="edittemplate1" value="1" type="radio"/>
            Default, no images or videos
          </label>
        </div>
        <div class="radio">
          <label>
            <input name="edittemplate" id="edittemplate2" value="2" type="radio"/>
            One image/video, middle of page below the menu bar
          </label>
        </div>
        <div class="radio">
          <label>
            <input name="edittemplate" id="edittemplate3" value="3" type="radio"/>
            One image/video, right side of page below body text
          </label>
        </div>
        <div class="radio">
          <label>
            <input name="edittemplate" id="edittemplate4" value="4" type="radio"/>
            One image/video, left side of page below body text
          </label>
        </div>
      </div>
    </div>
    
    <div class="form-group">
        <label for="editimage">Image Name(optional)</label>
        <input type="file" class="form-control" name="editimage" id="editimage" autocomplete='off'/>
        <span id="editimageText"><?php echo "Current File: " . $image; ?></span>
    </div>
    
    <input type="hidden" name="editorgid" id="editorgid">
    <input type="hidden" name="editid" id="editid">
    </fieldset>
</form>
</div>
<script type="text/javascript">
    // pop up a form to edit a record that provides option to cancel or save changes
    function editRecord(id, urlTitle, pageTitle, menuTitle, bodyTitle, body, asideTitle, asideBody, parent, orgid, template, image) {
        //alert('Hello1');
        document.getElementById("editurlTitle").value = urlTitle;
        document.getElementById("editpageTitle").value = pageTitle;
        document.getElementById("editbodyTitle").value = bodyTitle;
        document.getElementById("editmenuTitle").value = menuTitle;
        document.getElementById("editbody").value = body;
        document.getElementById("editasideTitle").value=asideTitle;
        document.getElementById("editasideBody").value=asideBody;
        document.getElementById("editparent").value = parent;
        document.getElementById("editorgid").value=orgid;
        //document.getElementById("edittemplate").value=template;
        $('input:radio[name=edittemplate]').val([template]);
        //document.getElementById("editimage").value=image;

       if (parent == -1) {
            $("#editparent").hide();
        } else {
            $("#editparent").show();
        }   
        
        document.getElementById("editid").value = id;
        
        $("#dialog-form").dialog("open");

    }
    
    $("#dialog-form").dialog(
        {
            autoOpen: false,
            height: 600,
            width: 600,
            modal: true,
            buttons: {
                "Save": function() {
                    var xmlhttp = new XMLHttpRequest();
            
                    // this part of code receives a response from editpage.php 
                    xmlhttp.onreadystatechange=function() {
                        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                            if(xmlhttp.responseText == "Page edited") {
                                alert('getting response');
                                alert(xmlhttp.responseText);
                                location.reload();
                            } else {
                                alert("Unsuccessful save: " + xmlhttp.responseText);
                                location.reload();
                            }
                        }
                    };
                                      
                    // get handle to edit form
                    //alert("hello2");
                    var form = document.getElementById('editform');
                    var formData = new FormData(form);
                    //alert("hello3");
                    // this sends the data request to deleteperson.php
                    xmlhttp.open("POST", "editpage.php", true);
                    //xmlhttp.setRequestHeader("Content-Type","multipart/form-data");
                    
                    xmlhttp.send(formData);

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

<?php
    $db->close();
?>