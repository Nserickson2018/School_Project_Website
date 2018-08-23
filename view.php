<html>
<body>
<?php
    $file=$_GET['fl'];
    
    if(file_exists($file)){
        show_source($file);
    }
?>
</body>
</html>