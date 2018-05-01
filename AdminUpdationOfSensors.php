<?php
	
	include('DBConnect.php');
	session_start();

	$user_login = $_SESSION['user_log_in'];

	if(!isset($_SESSION['user_log_in']))
	{
		header("location:index.php");
	}

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$sensor_name = mysqli_real_escape_string($conn,$_POST['sensor_name']);
		
		$sensor_status = mysqli_real_escape_string($conn,$_POST['sensor_status']);
		$user_email = mysqli_real_escape_string($conn,$_POST['email_add']);


		date_default_timezone_set("America/Los_Angeles");
		$PresentDate = date("Y-m-d H:i:s");


	//$userStatus = $_SESSION['userStatus']
	
	$sql1 = "SELECT user_id, first_name, last_name, user_type, email FROM USERS WHERE email = '$user_email'";

	$res1 = mysqli_query($conn,$sql1);

	$row1 = mysqli_fetch_array($res1,MYSQLI_ASSOC);

	$email = $row1['email'];
	$user_name = $row1['first_name'];
	$user_id = $row1['user_id'];
	$user_type =$row1['user_type'];


		$sql2 = "SELECT * FROM sensors WHERE user_id = '$user_id' AND sensor_name = '$sensor_name'";
		$res2 = mysqli_query($conn,$sql2);

		$row2 = mysqli_fetch_array($res2,MYSQLI_ASSOC);

		$sensor_id = $row2['sensor_id'];
		$sensor_date_join = $row2['sensor_date_join'];

		if($sensor_status == "ACTIVE")
		{
				$TimeNow = strtotime($PresentDate);

				$sqlSTART = "SELECT * FROM sensorUse WHERE sensor_id = '$sensor_id' ";

				$resSTART = mysqli_query($conn,$sqlSTART);

				while($row = mysqli_fetch_array($resSTART,MYSQLI_ASSOC)){

					$S_Status = $row['sensor_status'];
					$S_update_time = $row['updateTime'];
					$S_paused_time = $row['PausedTime'];

				}

				$TimePast = strtotime($S_update_time);

				$TimeDiff = $TimeNow - $TimePast;

				$S_paused_time = $S_paused_time + ($TimeDiff/3600);
				$S_paused_time = round($S_paused_time,2);


				$sql3 = "UPDATE sensors SET sensor_status='ACTIVE' WHERE user_id = '$user_id' AND sensor_name = '$sensor_name'";
				$res3 = mysqli_query($conn,$sql3);
				
				$sqlACTIVEtime = "UPDATE sensorUse set updateTime = '$PresentDate', PausedTime = '$S_paused_time' WHERE sensor_id = '$sensor_id'";

				$resACTIVEtime = mysqli_query($conn,$sqlACTIVEtime);

				if($resACTIVEtime)
				{
					echo "Sensor ".$sensor_name." status is ACTIVE";
				}

				$sqlBillActive = "UPDATE Bill set sensor_state = 'ACTIVE' WHERE sensor_id = '$sensor_id'";

				$resBillActive = mysqli_query($conn,$sqlBillActive);

		}
		else if($sensor_status == "STOP")
		{
				
				$TimeNow = strtotime($PresentDate);

				$sqlSTOP = "SELECT * FROM sensorUse WHERE sensor_id = '$sensor_id'";

				$resSTOP = mysqli_query($conn,$sqlSTOP);

				while($row = mysqli_fetch_array($resSTOP,MYSQLI_ASSOC)){

					$S_Status = $row['sensor_status'];
					$S_update_time = $row['updateTime'];
					$S_used_time = $row['usedTime'];

				}

				$TimePast = strtotime($S_update_time);

				$TimeDiff = $TimeNow - $TimePast;
				$S_used_time = $S_used_time + ($TimeDiff/3600);
				$S_used_time = round($S_used_time,2);


				$sql4 = "UPDATE sensors SET  sensor_status='STOP' WHERE user_id = '$user_id' AND sensor_name = '$sensor_name'";
				$res4 = mysqli_query($conn,$sql4);

				$sqlSTOPtime = " UPDATE sensorUse set updateTime = '$PresentDate', usedTime = '$S_used_time'
								WHERE sensor_id = '$sensor_id'";

				$resSTOPtime = mysqli_query($conn,$sqlSTOPtime);
				
				if($resSTOPtime)
				{
				echo "Sensor ".$sensor_name." status is STOPPED";
				}

				$sqlBillStop = "UPDATE Bill set sensor_state = 'STOP' WHERE sensor_id = '$sensor_id'";

				$resBillStop = mysqli_query($conn,$sqlBillStop);


		}
		else if($sensor_status == "REMOVE")
		{
				$TimeNow = strtotime($PresentDate);

				$sqlREMOVE = " SELECT * FROM sensorUse,sensors WHERE sensorUse.sensor_id = sensors.sensor_id AND sensors.sensor_id = '$sensor_id'";

				$resREMOVE = mysqli_query($conn,$sqlREMOVE);

				while($row = mysqli_fetch_array($resREMOVE,MYSQLI_ASSOC)){

					$S_Status = $row['sensor_status'];
					$S_update_time = $row['updateTime'];
					$S_paused_time = $row['pausedTime'];
					$S_used_time = $row['usedTime'];

				}

				$TimePast = strtotime($S_update_time);

				$TimeDiff = $TimeNow - $TimePast;

				if($S_Status == "Paused")
				{
					$S_paused_time = $S_paused_time + ($TimeDiff/3600);
					$S_paused_time = round($S_paused_time,2);	
				}
				else
				{
					$S_used_time = $S_used_time + ($TimeDiff/3600);
					$S_used_time = round($S_used_time,2);

				}
				


			$sql5 = "UPDATE sensors SET sensor_status = 'REMOVED' WHERE sensor_id = '$sensor_id' ";
			
			$res5= mysqli_query($conn,$sql5);
			

			$sql6 = "UPDATE sensorUSe SET updateTime = '$PresentDate' WHERE sensor_id = '$sensor_id'";
			$res6 = mysqli_query($conn,$sql6);

			if($res6)
			{
			echo "Sensor ".$sensor_name." status is REMOVED";
			}

			$sqlBillRemove = "UPDATE Bill set sensor_state = 'REMOVE' WHERE sensor_id = '$sensor_id'";

				$resBillRemove = mysqli_query($conn,$sqlBillRemove);
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
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Manage Users <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Add Users</a></li>
                <li><a href="#">View Users</a></li>
                <li><a href="#">Delete Users</a></li>
              </ul>
            </li>
          
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i>Manage Sensor Stations <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="AdminViewClusterDetails.php"> View Cluster Details </a></li>
			    <li><a href="AdminGeographicViewOfClusters.php"> View Cluster Location Details </a></li>
			    <li><a href=""> Add/Delete/Update Clusters</a></li>
              </ul>
            </li>
           
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Manage Sensors <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="AdminViewSensorDetails11.php"> View Sensor Details </a></li>
			<li><a href="AdminAdditionOfSensors.php"> Add Sensor </a></li>
			<!-- <li><a href="AdminDeletionOfSensors.php"> Delete Sensor </a></li> -->
			<li><a href="AdminUpdationOfSensors.php"> Update active/stop/remove for Sensor </a></li>
			<li><a href="AdminGeographicView.php">Sensors Location Details </a></li>
              </ul>
            </li>
          </ul>


          <ul class="nav navbar-nav navbar-right navbar-user">
         
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Hello Admin, <?php echo ucfirst($last_name)." " . ucfirst($first_name) ?> <b class="caret"></b></a>
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
                    <h2>Update Sensor</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action = "" method = "post">

                    <div id='mapOuter'>
                        <div id="map"></div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first">User email: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name = "email_add" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first">Sensor Name : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name = "sensor_name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
            

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sensor Status: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          
                            
			                <input type="radio" checked="" value="ACTIVE" name="sensor_status" /> ACTIVE 
			                
			                </br>
			                
			                <input type="radio" checked="" value="STOP" name="sensor_status" /> STOP
		                 
		                	</br>
			                
			                <input type="radio" checked="" value="REMOVE" name="sensor_status" /> REMOVE
			               
			               
			                </br>
                           
                          
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

  </body>
</html>
