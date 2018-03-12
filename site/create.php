<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
 $name = $address = $email = $age = $country = $sex = "";
 $name_err = $address_err = $email_err = $age_err = $country_err = $sex_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
  
  // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }
     
    // Validate address
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
  
  //validate age
  
  $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter your age.";     
    } else{
        $age = $input_age;
    }
  
  // validate country
  $input_country = trim($_POST["country"]);
    if(empty($input_country)){
        $country_err = "Please enter your country .";     
    } else{
        $country = $input_country;
    }
  //validate sex
  $input_sex = trim($_POST["sex"]);
    if(empty($input_sex)){
        $sex_err = "Please enter your sex .";     
    } else{
        $sex = $input_sex;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($email_err) && empty($age_err) && empty($country_err)  && empty($sex_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Driver (name, address, email, age, country, sex) VALUES (:name, :address, :email, :age, :country, :sex )";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters 
          $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':address', $param_address);
            $stmt->bindParam(':email', $param_email);
          $stmt->bindParam(':age', $param_age);
          $stmt->bindParam(':country', $param_country);
          $stmt->bindParam(':sex', $param_sex);
            
            // Set parameter
            $param_name = $name;
            $param_address = $address;
            $param_email = $email;
           $param_age = $age;
           $param_country = $country;
           $param_sex = $sex;          
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html>
<body>
		
 <div class="row">
        <div class="col-md-6 col-md-offset-0">
            <form enctype="multipart/form-data" method="post" action="/site/csv/import.php">
                <div class="form-group">
                    <label for="file">Select .CSV file to Import Employee Record</label>
                    <input name="file" type="file" class="form-control">
                </div>
                <div class="form-group">
                    <?php echo $message; ?>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit"/>
                </div>
            </form>
            <div class="form-group">
                <?php echo $users; ?>
            </div>
        </div>
    </div>
 
</form>

</body>
</html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add Driver record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        
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
                            <label>email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                      <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                            <label>age</label>
                            <input type="text" name="age" class="form-control" value="<?php echo $age; ?>">
                            <span class="help-block"><?php echo $age_err;?></span>
                        </div>
                      <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                            <label>country</label>
                            <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                            <span class="help-block"><?php echo $country_err;?></span>
                        </div>
                      <div class="form-group <?php echo (!empty($sex_err)) ? 'has-error' : ''; ?>">
                            <label>sex</label>
                            <input type="text" name="sex" class="form-control" value="<?php echo $sex; ?>">
                            <span class="help-block"><?php echo $sex_err;?></span>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
