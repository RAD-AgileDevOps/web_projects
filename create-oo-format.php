<?php
// Include config file
require_once "config-oo-format.php";
 
// Define variables and initialize with empty values
$first_name = $last_name = $address = $salary = "";
$first_name_err = $last_name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate first name
    $input_Fname = trim($_POST["first_name"]);
    if(empty($input_Fname)){
       $first_name = "Please enter a name.";
    } elseif(!filter_var($input_Fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
       $first_name_err = "Please enter a valid name.";
    } else{
        $first_name = $input_Fname;
    }
    // Validate surname
    $input_Lname = trim($_POST["last_name"]);
    if(empty($input_Lname)){
        $last_name = "Please enter a name.";
    } elseif(!filter_var($input_Lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
       $last_name_err = "Please enter a valid name.";
    } else{
        $last_name = $input_Lname;
    }
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($first_name_err) &&  empty($last_name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (first_name, last_name, address, salary) VALUES (?, ?, ?, ?)";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param ("ssss", $param_first_name, $param_last_name, $param_address, $param_salary);
            
            // Set parameters
            $param_first_name = $first_name;
			$param_last_name = $last_name ;
            $param_address = $address ;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index-oo-format.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
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
		
		body {
			
			background-image : url(https://cdn.pixabay.com/photo/2018/09/20/22/23/auto-repair-3691962__340.jpg);
			
			background-size : cover;
		}
		
		h2#rad001 {color: white;}
		#rad002{color: #E6E4DF} //light grey
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2 id="rad001">Create Record</h2>
                    </div>
                    <p id="rad002">Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label id="rad002">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
                            <span class="help-block"><?php echo $first_name_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label id="rad002">Surname</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
                            <span class="help-block"><?php echo $last_name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label id="rad002">Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label id="rad002">Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index-oo-format.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>