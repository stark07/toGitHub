<?php
/*
* iTech Empires:  How to Import Data from CSV File to MySQL Using PHP Script
* Version: 1.0.0
* Page: Import.PHP
*/

// Database Connection
require 'db_connection.php';

$message = "";
if (isset($_POST['submit'])) {
    $allowed = array('csv');
    $filename = $_FILES['file']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed)) {
        // show error message
        $message = 'Invalid file type, please use .CSV file!';
    } else {

        move_uploaded_file($_FILES["file"]["tmp_name"], "files/" . $_FILES['file']['name']);

        $file = "files/" . $_FILES['file']['name'];

        $query = <<<eof
        LOAD DATA LOCAL INFILE '$file'
         INTO TABLE driver
         FIELDS TERMINATED BY ','
         LINES TERMINATED BY '\n'
         IGNORE 1 LINES
        (name,address,email,age,country,sex)
eof;
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        $message = "CSV file successfully imported!";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSV Data Importer</title>
    <!-- Bootstrap CSS File  -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
</head>
<body>
<div class="container">
    <h2>
        CSV Data Importer
    </h2>
    <br><br>

    <div class="row">
        <div class="col-md-6 col-md-offset-0">
            <form enctype="multipart/form-data" method="post" action="../index.php">
                <div class="form-group">
                    <label for="file">Select .CSV file to Import</label>
                    <input name="file" type="file" class="form-control">
                </div>
                <div class="form-group">
                    <?php echo $message; ?>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Go Back"/>
                </div>
            </form>
            <div class="form-group">
                <?php echo $users; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
