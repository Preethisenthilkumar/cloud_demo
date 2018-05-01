<?php
	
	include('DBConnect.php');
	session_start();
	$user_login = $_SESSION['user_log_in'];
	
	$sql1 = "SELECT user_id, first_name, last_name, user_type,support_plan, email FROM USERS WHERE email = '$user_login'";
	$res1 = mysqli_query($conn,$sql1);
	$row1 = mysqli_fetch_array($res1,MYSQLI_ASSOC);
	$email = $row1['email'];
	$user_name = $row1['first_name'];
	$user_id = $row1['user_id'];
	$user_plan = $row1['support_plan'];
	
	if(!isset($_SESSION['user_log_in']))
	{
		header("location:index.php");
	}
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$sensor_name = mysqli_real_escape_string($conn,$_POST['sensor_name']);
		$sensor_latitude = mysqli_real_escape_string($conn,$_POST['sensor_latitude']);
		$sensor_longitude = mysqli_real_escape_string($conn,$_POST['sensor_longitude']);
		$sensor_location = mysqli_real_escape_string($conn,$_POST['sensor_location']);
		$sensor_type = mysqli_real_escape_string($conn,$_POST['sensor_type']);
		date_default_timezone_set("America/Los_Angeles");
		$PresentDate = date("Y-m-d H:i:s");
		$sql2 = "INSERT INTO sensors (user_id, sensor_name, sensor_type, sensor_latitude, sensor_longitude, sensor_location, sensor_status, sensor_date_join) VALUES ('$user_id','$sensor_name','$sensor_type', '$sensor_latitude', '$sensor_longitude', '$sensor_location', 'ACTIVE', '$PresentDate')";
		$res2 = mysqli_query($conn,$sql2);
		if($res2)
		{
			$sql3 = "SELECT sensor_id, sensor_date_join, sensor_status FROM sensors WHERE user_id = '$user_id' AND sensor_name = '$sensor_name' AND sensor_latitude = '$sensor_latitude' AND sensor_longitude = '$sensor_longitude' ";
			
			$res3 = mysqli_query($conn,$sql3);
			$row3 = mysqli_fetch_array($res3,MYSQLI_ASSOC);
			$sensor_id = $row3['sensor_id'];
			$sensor_date_join = $row3['sensor_date_join'];
			$sensor_status = $row3['sensor_status'];
			$sql4 = "INSERT INTO sensorUse(user_id,sensor_id,updateTime) VALUES('$user_id','$sensor_id','$sensor_date_join')";
			$res4 = mysqli_query($conn,$sql4);
			if($user_plan === 'Basic Plan')
			{
				$price = 0.5;
			}else if($user_plan === 'Premium Plan')
			{
				$price = 0.3;
			}else if($user_plan === 'PRO')
			{
				$price = 0.1;
			}
			//echo "price: ".$price;
			$sql5 = "INSERT INTO Bill(user_plan,sensor_state,sensor_price,user_id,sensor_id) VALUES('$user_plan','$sensor_status','$price','$user_id','$sensor_id')";
			$res5= mysqli_query($conn,$sql5);
		}
		
		
	}
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mobile Sensor Cloud</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
   

    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyAe6jtM83BDhNdL49jySjJ3XA1sODx-WmI"></script>
  
    <link rel="stylesheet" type="text/css" href="css/cssFile.css">

    <script src="js/script.js?update=444"></script>


  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">Mobile Sensor Cloud</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li class="active"><a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Manage Sensors <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="UserViewSensorDetails.php"> View Sensor Details </a></li>
                <li><a href="UserAdditionOfSensors.php"> Add Sensor </a></li>
                <!-- <li><a href="DeletionOfSensors.php"> Delete Sensor </a></li> -->
                <li><a href="UserUpdationOfSensors.php"> Update Sensor </a></li>
                <li><a href="UserGeographicView.php">Sensors Location Details </a></li>
              </ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i>Manage Sensor Stations <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="ViewClusterDetails.php"> View Cluster Details </a></li>
                <li><a href="GeographicViewOfClusters.php"> View Cluster Location Details </a></li>
              </ul>
            </li> 
            
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
         
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo ucfirst($last_name)." " . ucfirst($first_name) ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="Logout.php"><i class="fa fa-power-off"></i> Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>Dashboard <small>Statistics Overview</small></h1>
            <ol class="breadcrumb">
              <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
            </ol>
          </div>
        </div><!-- /.row -->




        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
               
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add a new sensor</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action = "" method = "post">

                    <div id='mapOuter'>
                        <div id="map"></div>
                      </div>

                      

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first">Sensor Name : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name = "sensor_name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="latitude">Sensor Latitude : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name = "sensor_latitude" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="longitude">Sensor Longitude : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name = "sensor_longitude" required="required" class="form-control col-md-7 col-xs-12">
                          <a class='selectLatLon' onclick='latlonSelect()' title='Select location'><image src='images/map.jpg' width=25 height=25></a>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="latitude">Sensor Location : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name = "sensor_location" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Type <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name = "sensor_type">
                            <option>Choose type</option>
                            <option>Temperature</option>
                            <option>Humidity</option>
                            <option>Turbidity</option>
                           
                          </select>
                        </div>
                      </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <input type="submit" class="btn btn-success" value="Submit" name="submit1">
                          
                        </div>
                      </div>

                    </form>

                  </div>
                </div>
              </div>
            </div>
                </div>


              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->



      </div><!-- /#page-wrapper -->



    </div><!-- /#wrapper -->

 
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Page Specific Plugins -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>
     <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
</html>
