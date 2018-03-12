<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$name = $address = $email = $age = $country = $sex = "";
$name_err = $address_err = $email_err = $age_err = $country_err = $sex_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }
    
    // Validate address address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Please enter an address.';     
    } else{
        $address = $input_address;
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter the email address.";     
    } else{
        $email = $input_email;
    }

    // Validate age
    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter valid age.";     
    } elseif(!ctype_digit($input_age)){
        $age_err = 'Please enter a positive integer value.';
    } else{
        $age = $input_age;
    }
    
    
    // validate country
  $input_country = trim($_POST["country"]);
    if(empty($input_country)){
        $country_err = "Please enter your country name .";     
    } else{
        $country = $input_country;
    }
    
    //validate sex
  $input_sex = trim($_POST["sex"]);
    if(empty($input_sex)){
        $sex_err = "Please enter sex.";     
    } else{
        $sex = $input_sex;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($email_err) && empty($age_err) && empty($country_err)  && empty($sex_err)) {
        // Prepare an insert statement
        $sql = "UPDATE driver SET name=:name, address=:address, email=:email, age=:age, country=:country, sex=:sex  WHERE id=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':address', $param_address);
            $stmt->bindParam(':email', $param_email);
            $stmt->bindParam(':age', $param_age);
            $stmt->bindParam(':country', $param_country);
            $stmt->bindParam(':sex', $param_sex);
            $stmt->bindParam(':id', $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_email = $email;
            $param_age = $age;
            $param_country = $country;
            $param_sex = $sex;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM driver WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':id', $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $name = $row["name"];
                    $address = $row["address"];
                    $email = $row["email"];
                    $age = $row["age"];
                    $country = $row["country"];
                    $sex = $row["sex"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>e-mail</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                            <label>Age</label>
                            <input type="text" name="age" class="form-control" value="<?php echo $age; ?>">
                            <span class="help-block"><?php echo $age_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                            <label>Country</label>
                            <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                            <span class="help-block"><?php echo $country_err;?></span>
                        </div>

                         <div class="form-group <?php echo (!empty($sex_err)) ? 'has-error' : ''; ?>">
                            <label>Sex</label>
                            <input type="text" name="sex" class="form-control" value="<?php echo $sex; ?>">
                            <span class="help-block"><?php echo $sex_err;?></span>
                        </div>
                        
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>