
<!-- /* Need to Complete */ -->

<?php

  include('DBConnect.php');
  session_start();

  $user_login = $_SESSION['user_log_in'];

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    
    $email_add = mysqli_real_escape_string($conn,$_POST['email_add']);

    $sql1 = "SELECT * FROM USERS where email = '$email_add' ";


    $res1 = mysqli_query($conn,$sql1);

    $row1 = mysqli_fetch_array($res1,MYSQLI_ASSOC);

    $user_email = $row1['email'];
    $user_type = $row1['user_type'];
    $first_name = $row1['first_name'];
    $last_name = $row1['last_name'];
    $user_id = $row1['user_id'];
    $user_support_plan = $row1['support_plan'];
    $user_bill = $row1['billing'];

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
                <li><a href="AdminViewSensorDetails.php"> View Sensor Details </a></li>
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



        <form action="" method = "post">
      Enter User Email Address:
      <input type="text" name="email_add" required="">
    </form>


        <div class="row">
          <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  
                  <div class="col-xs-6 text-left">
                    <p class="announcement-heading"><?php 
      $sqla = "SELECT COUNT(*) as countValue from sensors where user_id ='$user_id'";
      $resa = mysqli_query($conn,$sqla);
      $rowa = mysqli_fetch_array($resa,MYSQLI_ASSOC);

      $tempa = $rowa['countValue'];

      echo $tempa;

    ?></p>
                    <p class="announcement-text">Total Sensors</p>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
         
          
          <div class="col-lg-3">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  
                  <div class="col-xs-6 text-left">
                    <p class="announcement-heading"><?php
    echo "".$user_bill."$</br>"; 
    ?></p>
                    <p class="announcement-text">Bill</p>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div><!-- /.row -->



              <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h2>Sensors Status</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                    <p class="text-muted font-13 m-b-30">
                      
                    </p>
                    <table id="datatable1" class="table table-striped table-bordered">
                      <thead>
                         <tr>
                          <th>Active</th>
                          <th>Stopped</th>
                          <th>Removed</th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                            <td> <?php 

      $sqlb = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_status = 'ACTIVE'";
      $resb = mysqli_query($conn,$sqlb);
      $rowb = mysqli_fetch_array($resb,MYSQLI_ASSOC);

      $tempb_1 = $rowb['countValue'];
      $tempb_2 = ($tempb_1/$tempa)*100;

      echo round($tempb_2,2); 
      ?>%</td>
                            <td><?php 

      $sqlc = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_status = 'STOP'";
      $resc = mysqli_query($conn,$sqlc);
      $rowc = mysqli_fetch_array($resc,MYSQLI_ASSOC);

      $tempc_1 = $rowc['countValue'];
      $tempc_2 = ($tempc_1/$tempa)*100;

      echo round($tempc_2,2); 
      ?>%</td>
                            <td> <?php 

      $sqld = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_status = 'Removed'";
      $resd = mysqli_query($conn,$sqld);
      $rowd = mysqli_fetch_array($resd,MYSQLI_ASSOC);

      $tempd_1 = $rowd['countValue'];
      $tempd_2 = ($tempd_1/$tempa)*100;

      echo round($tempd_2,2); 
      ?>%
      <br>
    
      </td>
                            
                            </tr>   

                             <tr>
                            <td><?php 

      $sqlb = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_status = 'ACTIVE'";
      $resb = mysqli_query($conn,$sqlb);
      $rowb = mysqli_fetch_array($resb,MYSQLI_ASSOC);

      $tempb_1 = $rowb['countValue'];
      $tempb_2 = ($tempb_1/$tempa)*100;

       echo $tempd_1; 
      ?></td>
                            <td><?php 

      $sqlc = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_status = 'STOP'";
      $resc = mysqli_query($conn,$sqlc);
      $rowc = mysqli_fetch_array($resc,MYSQLI_ASSOC);

      $tempc_1 = $rowc['countValue'];
      $tempc_2 = ($tempc_1/$tempa)*100;

      echo $tempd_1; 
      ?></td>
                            <td><?php 

      $sqld = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_status = 'Removed'";
      $resd = mysqli_query($conn,$sqld);
      $rowd = mysqli_fetch_array($resd,MYSQLI_ASSOC);

      $tempd_1 = $rowd['countValue'];
      $tempd_2 = ($tempd_1/$tempa)*100;

      echo $tempd_1;
      ?></td>                          
                            
                            </tr>             
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              </div>





              <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h2>Sensor Types</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                    <p class="text-muted font-13 m-b-30">
                      
                    </p>
                    <table id="datatable2" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Temperature</th>
                          <th>Turbidity</th>
                          <th>Humidity</th>
                          
                        </tr>
                      </thead>

                      <tbody>
                      <tr>
                            <td> <?php
      $sqle = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_type = 'Temperature'";
      $rese = mysqli_query($conn,$sqle);
      $rowe = mysqli_fetch_array($rese,MYSQLI_ASSOC);

      $tempe_1 = $rowe['countValue'];
      $tempe_2 = ($tempe_1/$tempa)*100;

      echo round($tempe_2,2); 
      ?>%</td>
                            <td><?php
      $sqlf = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_type = 'Turbidity'";
      $resf = mysqli_query($conn,$sqlf);
      $rowf = mysqli_fetch_array($resf,MYSQLI_ASSOC);

      $tempf_1 = $rowf['countValue'];
      $tempf_2 = ($tempf_1/$tempa)*100;

      echo round($tempf_2,2); 
      ?>%</td>
                            <td> <?php
      $sqlg = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_type = 'Humidity'";
      $resg = mysqli_query($conn,$sqlg);
      $rowg = mysqli_fetch_array($resg,MYSQLI_ASSOC);

      $tempg_1 = $rowg['countValue'];
      $tempg_2 = ($tempg_1/$tempa)*100;

      echo round($tempg_2,2); 
      ?>%
      <br>
    
      </td>
                            
                            </tr>   

                             <tr>
                            <td><?php
      $sqle = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_type = 'Temperature'";
      $rese = mysqli_query($conn,$sqle);
      $rowe = mysqli_fetch_array($rese,MYSQLI_ASSOC);

      $tempe_1 = $rowe['countValue'];
      $tempe_2 = ($tempe_1/$tempa)*100;

      echo $tempe_1; 
      ?></td>
                            <td><?php
      $sqlf = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_type = 'Turbidity'";
      $resf = mysqli_query($conn,$sqlf);
      $rowf = mysqli_fetch_array($resf,MYSQLI_ASSOC);

      $tempf_1 = $rowf['countValue'];
      $tempf_2 = ($tempf_1/$tempa)*100;

      echo $tempf_1;
      ?></td>
                            <td><?php
      $sqlg = "SELECT COUNT(*) as countValue from sensors where user_id='$user_id' AND sensor_type = 'Humidity'";
      $resg = mysqli_query($conn,$sqlg);
      $rowg = mysqli_fetch_array($resg,MYSQLI_ASSOC);

      $tempg_1 = $rowg['countValue'];
      $tempg_2 = ($tempg_1/$tempa)*100;

     echo $tempg_1;
      ?></td>                          
                            
                            </tr>             
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>







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
