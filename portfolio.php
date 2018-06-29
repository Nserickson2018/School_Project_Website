<!-- Informatics Project -->
<!-- By: Nicholas Erickson -->

<!-- this page contains code for other projects that I have done -->

<!DOCTYPE html>
    
<html lang="en">
<head>
    <?php
        include_once("config.php");
        include_once("dbutils.php");
    ?>
    <title>My Portfolio</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Set up basic stylesheets and fonts -->
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
                <h1 style="text-align: center">My Portfolio</h1>
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
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <p>These files belong to the programming assignments that I completed while at school. These files are of php, html, css, python and C++ file types.
            <br> You can download individual files or download a full copy of the project by clicking on any of the '.zip' files or you can simply view<br>
            the source code of the files by clicking 'view'.</p>
            <br>
            <br>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
                <?php
                    $db=connectDB($DBHost, $DBUser, $DBPassword, $DBName);
                    
                    echo "<table class='table table-striped table-hover'>";
                        echo "\n <caption>This Website</caption>";
                        echo "\n <thead>";
                            echo "\n <tr>";
                                echo "\n <th>File Name</th>";
                                echo "\n <th>Class or Project</th>";
                            echo "\n </tr>";
                        echo "\n </thead>";
                        echo "\n <tbody>";
                            $getFiles="SELECT * from Files WHERE Class='Informatics_Project';";
                    
                            $getFilesResult=queryDB($getFiles, $db);
                            
                            if($getFilesResult){
                                $numrow=nTuples($getFilesResult);
                                
                                for($n=0; $n<$numrow; $n++){
                                    $row=nextTuple($getFilesResult);
                                    
                                    echo "\n <tr>";
                                        echo "\n <td><a href='download.php/?fl=". $row['file_name'] . "'>" . $row['file_name'] . "</a></td>";
                                        echo "\n <td>" . $row['Class'] . "</td>";
                                        if(strpos($row['file_name'], '.zip') == false){
                                            echo "\n <td><a href='view.php/?fl=" . $row['file_name'] . "'>View</a></td>";
                                            echo "\n <td><a href='download.php/?fl=" . $row['file_name'] . "'>Download</a></td>";
                                        }
                                    echo "\n </tr>";
                                }
                            } else {
                                echo "Sorry no tuples found or there was a problem with the query.";
                            }
                        echo "\n <tbody>";
                    echo "\n </table>";
                ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
                <?php
                    echo "<table class='table table-striped table-hover'>";
                        echo "\n <caption>HTML Files</caption>";
                        echo "\n <thead>";
                            echo "\n <tr>";
                                echo "\n <th>File Name</th>";
                                echo "\n <th>Class or Project</th>";
                            echo "\n </tr>";
                        echo "\n </thead>";
                        echo "\n <tbody>";
                            $getFiles="SELECT * from Files WHERE Class='HTML5';";
                    
                            $getFilesResult=queryDB($getFiles, $db);
                            
                            if($getFilesResult){
                                $numrow=nTuples($getFilesResult);
                                
                                for($n=0; $n<$numrow; $n++){
                                    $row=nextTuple($getFilesResult);
                                    
                                    echo "\n <tr>";
                                        echo "\n <td><a href='download.php/?fl=". $row['file_name'] . "'>" . $row['file_name'] . "</a></td>";
                                        echo "\n <td>" . $row['Class'] . "</td>";
                                        if(strpos($row['file_name'], '.zip') == false){
                                            echo "\n <td><a href='view.php/?fl=" . $row['file_name'] . "'>View</a></td>";
                                            echo "\n <td><a href='download.php/?fl=" . $row['file_name'] . "'>Download</a></td>";
                                        }
                                    echo "\n </tr>";
                                }
                            } else {
                                echo "Sorry no tuples found or there was a problem with the query.";
                            }
                        echo "\n <tbody>";
                    echo "\n </table>";
                ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
                <?php
                    echo "<table class='table table-striped table-hover'>";
                        echo "\n <caption>Python files</caption>";
                        echo "\n <thead>";
                            echo "\n <tr>";
                                echo "\n <th>File Name</th>";
                                echo "\n <th>Class or Project</th>";
                            echo "\n </tr>";
                        echo "\n </thead>";
                        echo "\n <tbody>";
                            $getFiles="SELECT * from Files WHERE Class='Python';";
                    
                            $getFilesResult=queryDB($getFiles, $db);
                            
                            if($getFilesResult){
                                $numrow=nTuples($getFilesResult);
                                
                                for($n=0; $n<$numrow; $n++){
                                    $row=nextTuple($getFilesResult);
                                    
                                    echo "\n <tr>";
                                        echo "\n <td><a href='download.php/?fl=". $row['file_name'] . "'>" . $row['file_name'] . "</a></td>";
                                        echo "\n <td>" . $row['Class'] . "</td>";
                                        if(strpos($row['file_name'], '.zip') == false){
                                            echo "\n <td><a href='view.php/?fl=" . $row['file_name'] . "'>View</a></td>";
                                            echo "\n <td><a href='download.php/?fl=" . $row['file_name'] . "'>Download</a></td>";
                                        }
                                    echo "\n </tr>";
                                }
                            } else {
                                echo "Sorry no tuples found or there was a problem with the query.";
                            }
                        echo "\n <tbody>";
                    echo "\n </table>";
                ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
                <?php
                    echo "<table class='table table-striped table-hover'>";
                        echo "\n <caption>C++ Files</caption>";
                        echo "\n <thead>";
                            echo "\n <tr>";
                                echo "\n <th>File Name</th>";
                                echo "\n <th>Class or Project</th>";
                            echo "\n </tr>";
                        echo "\n </thead>";
                        echo "\n <tbody>";
                            $getFiles="SELECT * from Files WHERE Class='C++';";
                    
                            $getFilesResult=queryDB($getFiles, $db);
                            
                            if($getFilesResult){
                                $numrow=nTuples($getFilesResult);
                                
                                for($n=0; $n<$numrow; $n++){
                                    $row=nextTuple($getFilesResult);
                                    
                                    echo "\n <tr>";
                                        echo "\n <td><a href='download.php/?fl=". $row['file_name'] . "'>" . $row['file_name'] . "</a></td>";
                                        echo "\n <td>" . $row['Class'] . "</td>";
                                        if(strpos($row['file_name'], '.zip') == false){
                                            echo "\n <td><a href='view.php/?fl=" . $row['file_name'] . "'>View</a></td>";
                                            echo "\n <td><a href='download.php/?fl=" . $row['file_name'] . "'>Download</a></td>";
                                        }
                                    echo "\n </tr>";
                                }
                            } else {
                                echo "Sorry no tuples found or there was a problem with the query.";
                            }
                        echo "\n <tbody>";
                    echo "\n </table>";
                ?>
        </div>
    </div>
</div>
</body>
</html>