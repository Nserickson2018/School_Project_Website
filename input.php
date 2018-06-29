<?php
    include_once("dbutils.php");
    include_once("config.php");
    //check if user is logged in
    session_start();
    
    if(!isset($_SESSION['username'])) {
        //if not logged in, send them to the login page
        header('Location: login.php');
        exit;
    }
    //see if the user has admin permissions
    include_once("getAccType.php");
    if($acctype!='admin' && $orgacctype!='orgadmin'){
        //if the user is not an admin, send them to the login page
        header('Location: index.php');
        exit;
    }
?>
<?php


    if(isset($_GET['orgid'])){
        $orgid=$_GET['orgid'];
    } else {
        punt('Unable to revrieve infromation from Get variable.');
    }
    
    //
    // We use this bit of code to generate a list of possible parents for the data entry portion
    //
    
    // get a handle to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    // prepare sql statement
    $query = "select id, urlTitle from pages order by parent;";
    
    // execute sql statement
    $result = queryDB($query, $db);
        
    // check if it worked
    if ($result) {
        $numberofrows = nTuples($result);
        
        // this one is for input
        $selectStatement = "<select class='form-control' name='parent' autofocus>\n";
    
        // this one is for editing    
        $editselectStatement = "<select class='form-control' name='editparent' id='editparent' autofocus>\n";
        
        $editselectStatement = $editselectStatement .  "\t<option value='-1'>No parent</option>\n";
        
        for ($i=0; $i<$numberofrows; $i++) {
            $row = nextTuple($result);
            $selectStatement = $selectStatement . "\t<option value='" . $row['id'] . "'>" . $row['urlTitle'] . "</option>\n";
            $editselectStatement = $editselectStatement . "\t<option value='" . $row['id'] . "'>" . $row['urlTitle'] . "</option>\n";
        }
        
        $selectStatement = $selectStatement . "</select>\n";
        $editselectStatement = $editselectStatement . "</select>\n";
    } else {
        punt("Something went wrong when retrieving pages from the database.<p>" .
                          "This was the error: " . $db->error . "<p>", $query);
    }
    
    $queryOrg='SELECT orgid, orgName FROM organizations ORDER BY orgid';
    
    $resultOrg=queryDB($queryOrg, $db);
    
    if ($resultOrg){
        $numRows=nTuples($resultOrg);
        
        $selectOrg= "<select class='form-control' name='orgid' autofocus>\n";
        
        $editOrgid="<select class='form-control' name='editorgid' id='editorgid' autofocus>\n";
        
        for ($a=0; $a<$numRows; $a++){
            $row=nextTuple($resultOrg);
            $selectOrg=$selectOrg . "\t<option value='" . $row['orgid'] . "'>" . $row['orgName'] . "</option>\n";
            $editOrgid=$editOrgid . "\t<option value='" . $row['orgid'] . "'>" . $row['orgName'] . "</option>\n";
        }
        $selectOrg=$selectOrg . "</select>\n";
        $editOrgid=$editOrgid . "</select>\n";
    } else {
        punt("Something went wrong when retrieving pages from the database.<p>" .
                          "This was the error: " . $db->error . "<p>", $query);
    }
?>

<html>

<head>
    <title>Pages entry</title>

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
    <!--<link rel="stylesheet" href="https://bootswatch.com/cyborg/bootstrap.min.css">-->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Bungee+Inline|Lobster|Rokkitt|Tangerine" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"/>
    
    <script>
        /*
        function hello(){
            alert("1");
        }
        */
    </script>
    
</head>

<body>
    
<div class="container" style="width: 1024px">

<div class="row">
    <div class="col-xs-12">
        <div class="page-header">
            <!-- Header -->
            <h1 style="color: white">New Page Data Entry</h1>
            <!--<a href="home.php">View site</a>-->
            <?php
                echo "<a href='home.php?orgid=" . $orgid . "'>View Site</a>";
            ?>
        </div>
    </div>  
</div>

<div class="row">
<div class="col-xs-12">
<form action="insertpage.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="urlTitle">URL Title</label>
        <input type="text" class="form-control" name="urlTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="parent">Parent Page</label>
        <?php echo $selectStatement ?>
    </div>
    
    <div class="form-group">
        <label for="pageTitle">Page Title</label>
        <input type="text" class="form-control" name="pageTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="menuTitle">Menu Title</label>
        <input type="text" class="form-control" name="menuTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="bodyTitle">Body Title</label>
        <input type="text" class="form-control" name="bodyTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="body">Body</label>
        <textarea class="form-control" name="body" rows="5" autofocus></textarea>
    </div>
    
    <div class="form-group">
        <label for="asideTitle">Side Panel Title(optional)</label>
        <input type="text" class="form-control" name="asideTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="asideBody">Side Panel Body(optional)</label>
        <textarea class="form-control" name="asideBody" autofocus></textarea>
    </div>
    
    <!--<div class="form-group">
        <label for="orgid">Select the organization ID for the page.</label>
        <?php //echo $selectOrg; ?>
    </div>-->
    
    <div class="form-group">
      <label class="col-lg-2 control-label">Template(optional)</label>
      <div class="col-lg-10">
        <div class="radio">
          <label  style="margin-top: 10px">
            <input name="template" id="template1" value="1" type="radio">
            Default, no images or videos
          </label>
        </div>
        <div class="radio">
          <label>
            <input name="template" id="template2" value="2" type="radio">
            One image/video, middle of page below the menu bar
          </label>
        </div>
        <div class="radio">
          <label>
            <input name="template" id="template3" value="3" type="radio">
            One image/video, right side of page below body text
          </label>
        </div>
        <div class="radio">
          <label>
            <input name="template" id="template4" value="4" type="radio">
            One image/video, left side of page below body text
          </label>
        </div>
      </div>
    </div>
    
    <div class="form-group">
        <label for="image">Image Name(optional)</label>
        <input type="file" class="form-control" name="image" id="image" autofocus/>
        <span id="imageText">Current File: <?php echo $image; ?></span>
    </div>
    
    <?php
        echo "<input type='hidden' class='form-control' name='orgid' id='orgid' value=" . $orgid . ">";
    ?>
    
    <button type="submit" class="btn btn-default">Add</button>
</form>
</div> <!-- close column -->
</div> <!-- close row -->

<!---------------->
<!-- List data  -->
<!---------------->
<p>
    <br/>
    <br/>
    <h2>Pages in the database</h2>
</p>

<table class="table table-striped">
    
    <!-- Titles for table -->
    <tr>
        <td>urlTitle</td>
        <td> </td>
        <td> </td>
    </tr>
    
<?php
    // prepare sql statement
    $query = "select id, urlTitle, pageTitle, menuTitle, parent, bodyTitle, body, asideTitle, asideBody, orgid, template, image from pages where orgid=" . $orgid . " order by parent;";
    
    // execute sql statement
    $result = queryDB($query, $db);
    
    // check if it worked
    if ($result) {
        $numberofrows = nTuples($result);
        
        for($i=0; $i < $numberofrows; $i++) {
            $row = nextTuple($result);
            $image=$row['image'];
            echo "\n <tr>";
            echo "\n <td>" . $row['urlTitle'] . "</td>";
            echo "\n <td>";
            if ($row['parent'] >= 0) {
                echo "<button type='button' class='btn btn-default' onclick='deleteRecord(" . '"' . $row['id'] . '", "' .
                $row['urlTitle'] . '"' . ");'>Delete</button>";
            } else {
                echo " ";
            }
            echo "</td>";
            
            
            echo "\n <td><button type='button' class='btn btn-default' onclick='" . "editRecord(" . '"' . $row['id'] . '", "' .
                $row['urlTitle'] . '", "' . $row['pageTitle'] . '", "' . $row['menuTitle'] .
                '", "' . $row['bodyTitle'] . '", ' . str_replace('\'', '&#39;', json_encode($row['body'])) .
                ', "' . $row['asideTitle'] . '", ' . str_replace('\'', '&#39;', json_encode($row['asideBody'])) . ', "' . $row['parent'] . '", "' . $row['orgid'] .
                '", "' . $row['template'] . '", "' . $row['image'] . '"' . ");'>Edit</button></td>";
            echo "\n </tr>";
        }
        
    } else {
        punt("Something went wrong when retrieving pages from the database.<p>" .
                          "This was the error: " . $db->error . "<p>", $query);
    }
    

    
?>    
    
</table>
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
                        $db->close();
                    ?>
                </div>
            </div>
        </div>        
    </div>

</div> <!-- Closing container div -->

<!-- Code for editing form -->
<div id="dialog-form" title="Edit page" style="display: none">
<form>
    <fieldset>
    <div class="form-group">
        <label for="editurlTitle">URL Title</label>
        <input type="text" class="form-control" name="editurlTitle" id="editurlTitle" autofocus/>
    </div>
    
    <div class="form-group">
        <label for="editparent">Parent Page</label>
        <?php echo $editselectStatement ?>
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
        <label for="editorgid">Select the organization ID for the page.</label>
        <?php echo $editOrgid; ?>
    </div>
    <div class="form-group">
      <label class="col-lg-2 control-label">Template(optional)</label>
      <div class="col-lg-10">
        <div class="radio">
          <label  style="margin-top: 10px">
            <input name="edittemplate" id="edittemplate1" value="1" type="radio">
            Default, no images or videos
          </label>
        </div>
        <div class="radio">
          <label>
            <input name="edittemplate" id="edittemplate2" value="2" type="radio">
            One image/video, middle of page below the menu bar
          </label>
        </div>
        <div class="radio">
          <label>
            <input name="edittemplate" id="edittemplate3" value="3" type="radio">
            One image/video, right side of page below body text
          </label>
        </div>
        <div class="radio">
          <label>
            <input name="edittemplate" id="edittemplate4" value="4" type="radio">
            One image/video, left side of page below body text
          </label>
        </div>
      </div>
    </div>
    
    <div class="form-group">
        <label for="editimage">Image Name(optional)</label>
        <input type="file" class="form-control" name="editimage" id="editimage" autofocus/>
        <span id="editimageText">Current File: <?php echo $image; ?></span>
    </div>
    
    <input type="hidden" name="editorgid" id="editorgid"/>
    <input type="hidden" name="editid" id="editid"/>
    </fieldset>
</form>
</div>


<script>
    // confirm that a user wants to delete, then call php script to do deletion
    function deleteRecord(id, name) {
        // delete record from pages table identified by id, if user agrees
        var decision = confirm("Would you like to delete " + name + "?");
        if (decision === true) {
            var xmlhttp = new XMLHttpRequest();
            
            // this part of code receives a response from deleteperson.php 
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    if(xmlhttp.responseText == "Page deleted") {
                        location.reload();
                    } else {
                        alert("Unsuccessful delete: " + xmlhttp.responseText);
                    }
                }
            };
            
            // this sends the data request to deleteperson.php
            xmlhttp.open("POST", "deletepage.php", true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("id=" + id);
        }
    }
    
    // pop up a form to edit a record that provides option to cancel or save changes
    function editRecord(id, urlTitle, pageTitle, menuTitle, bodyTitle, body, asideTitle, asideBody, parent, orgid, template, image) {
        document.getElementById("editurlTitle").value = urlTitle;
        document.getElementById("editpageTitle").value = pageTitle;
        document.getElementById("editbodyTitle").value = bodyTitle;
        document.getElementById("editmenuTitle").value = menuTitle;
        document.getElementById("editbody").value = body;
        document.getElementById("editasideTitle").value=asideTitle;
        document.getElementById("editasideBody").value=asideBody;
        document.getElementById("editorgid").value=orgid;
        document.getElementById("editparent").value = parent;
        $('input:radio[name=edittemplate]').val([template]);
        //document.getElementById("edittemplate").value=template;
        document.getElementById("editimageText").value="Current file: " + image;
        
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
                    xmlhttp.open("POST", "editpage.php", true);
                    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    
                    // get variables
                    var editurlTitle = document.getElementById("editurlTitle").value;
                    var editpageTitle = document.getElementById("editpageTitle").value;
                    var editbodyTitle = document.getElementById("editbodyTitle").value;
                    var editmenuTitle = document.getElementById("editmenuTitle").value;
                    var editbody = document.getElementById("editbody").value;
                    var editparent = document.getElementById("editparent").value;
                    var editid = document.getElementById("editid").value;
                    var editasideTitle=document.getElementById("editasideTitle").value;
                    var editasideBody=document.getElementById("editasideBody").value;
                    var editorgid=document.getElementById("editorgid").value;
                    //var edittemplate=document.getElementById("edittemplate").value;
                    $('input:radio[name=edittemplate]').val([edittemplate]);
                    var editimage=document.getElementById("editimage").value;
                    
                    // send data to editpage.php
                    xmlhttp.send("id=" + editid + "&urlTitle=" + editurlTitle + "&pageTitle=" + editpageTitle + "&bodyTitle=" +
                                 editbodyTitle + "&menuTitle=" + editmenuTitle + "&body=" + editbody + "&parent=" + editparent +
                                 "&asideTitle=" + editasideTitle + "&asideBody=" + editasideBody + "&orgid=" + editorgid + "&template=" +
                                 edittemplate + "&image=" + editimage);
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