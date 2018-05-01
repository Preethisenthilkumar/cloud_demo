<?php

	include("DBConnect.php");
	session_start();

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
		$last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		$password = mysqli_real_escape_string($conn,$_POST['password']);
		$street = mysqli_real_escape_string($conn,$_POST['street']);
		$city = mysqli_real_escape_string($conn,$_POST['city']);
		$state = mysqli_real_escape_string($conn,$_POST['state']);
		$zip = mysqli_real_escape_string($conn,$_POST['zip']);
		$phone = mysqli_real_escape_string($conn,$_POST['phone']);
		$credit_card = mysqli_real_escape_string($conn,$_POST['credit_card']);
		$expiry_date = mysqli_real_escape_string($conn,$_POST['expiry_date']);
		$cardHolderName = mysqli_real_escape_string($conn,$_POST['cardHolderName']);
		$support_plan = mysqli_real_escape_string($conn,$_POST['optionsRadios']);
		$user_type = mysqli_real_escape_string($conn,$_POST['user_type']);



		$sql = "INSERT INTO USERS(first_name, last_name, email, password, street, city, state, zip, phone_no, credit_card_no, expiry_date, card_holder_name, support_plan, user_type) VALUES ('$first_name', '$last_name', '$email', '$password', '$street', '$city', '$state', '$zip', '$phone', '$credit_card', '$expiry_date', '$cardHolderName','$support_plan','$user_type')";

		$res = mysqli_query($conn,$sql);


		if ($res) 
		{
    		//echo "New record created successfully";
    		header("location: index.php");
		} else {
    		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sensor Cloud! | Register</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <style>
      .center-div
      {
        position: absolute;
        margin: auto;
        right: 0;
        left: 0;
      }
    </style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        

        

        <!-- page content -->
        <div>
          <div>
            <div class="page-title">
              <div style="text-align:center;">
                <h3>REGISTRATION FORM</h3>
              </div>

              
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-9 col-sm-9 col-xs-9 center-div">
                <div class="x_panel">
                  
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="post" action="" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="x_title">
                    <h2>Login Credentials</h2>
                    
                    <div class="clearfix"></div>
                  </div>

                      <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">First Name: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="first_name" required="" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="last_name" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">My e-mail address is: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="email" name="email" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Type it again: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="email" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Enter a new password: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="password" name="password" class="form-control col-md-7 col-xs-12" type="password" name="password">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Type it again: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="password" class="date-picker form-control col-md-7 col-xs-12" required="required" type="password">
                            </div>
                          </div>
                          <br />

                          <div class="x_title">
                    <h2>Contact Information</h2>
                    
                    <div class="clearfix"></div>
                  </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Full Name: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Country: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="country" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="street" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">City: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="middle-name" name="city" class="form-control col-md-7 col-xs-12" type="text" name="middle-name">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">State / Province or Region: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="birthday" name="state" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Postal Code: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="middle-name" name="zip" class="form-control col-md-7 col-xs-12" type="number" name="middle-name">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="phone" class="form-control" required="required" data-inputmask="'mask' : '(999) 999-9999'">
                            </div>
                          </div>
                          <br />
                          <div class="x_title">
                    <h2>Payment Information</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Credit/Debit Card Number: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="credit_card" class="form-control" required="required" data-inputmask="'mask' : '9999-9999-9999-9999'">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Expiration Date: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="expiry_date" class="form-control" required="required" data-inputmask="'mask': '99/99'">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cardholder's Name: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="cardHolderName" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <br />

                          <div class="x_title">
                    <h2>Support Plan <small>(<a href="pricing-tables.php" target="_blank">View Plan Details</a>)</small></h2>
                    
                    <div class="clearfix"></div>
                  </div>

                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Support Plan: <span class="required">*</span>
                            </label>
                             <div class="col-md-9 col-sm-9 col-xs-12">
                          
                          <div class="radio">
                            <label>
                              <input type="radio" checked="" value="Basic Plan" id="optionsRadios1" name="optionsRadios"> Basic
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="Premium Plan" id="optionsRadios2" name="optionsRadios"> Premium
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="Pro" id="optionsRadios2" name="optionsRadios"> Pro
                            </label>
                          </div>
                        </div>
                      </div>     


                      <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User Type: <span class="required">*</span>
                            </label>
                             <div class="col-md-9 col-sm-9 col-xs-12">
                          
                          <div class="radio">
                            <label>
                              <input type="radio" checked="" value="user" name="user_type"> User:
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="admin" name="user_type"> Admin
                            </label>
                          </div>
                        </div>
                      </div>     


                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary" name="cancel">Cancel</button>
                          <button type="submit"  name="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>

           
        </div>
        <!-- /page content -->

        
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- jQuery Smart Wizard -->
    <script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
    <!-- jquery.inputmask -->
    <script src="vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

   
  </body>
</html>

<?php

mysqli_close($conn);
?>