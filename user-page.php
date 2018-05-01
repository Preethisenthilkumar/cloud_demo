<?php

  include('DBConnect.php');
  session_start();

  $user_login = $_SESSION['user_log_in'];

  $sql1 = "SELECT user_id, first_name, last_name, user_type, support_plan, email FROM USERS where email = '$user_login' ";

  $res1 = mysqli_query($conn,$sql1);

  $row1 = mysqli_fetch_array($res1,MYSQLI_ASSOC);

  $user_email = $row1['email'];
  $user_type = $row1['user_type'];
  $first_name = $row1['first_name'];
  $last_name = $row1['last_name'];
  $user_id = $row1['user_id'];
  $user_support_plan = $row1['support_plan'];
  $running_price = 0;
  $stop_price = 0;

  // Active Bill

  $sqlBill1 = "SELECT * FROM Bill WHERE user_plan = '$user_support_plan' AND sensor_state = 'Active'";

  $resBill1 = mysqli_query($conn,$sqlBill1);

  $rowBill1 = mysqli_fetch_array($resBill1,MYSQLI_ASSOC);

  $running_price = $rowBill1['sensor_price'];

  //echo "running price: ".$running_price;

  // Pause Bill

  $sqlBill2 = "SELECT * FROM Bill WHERE user_plan = '$user_support_plan' AND sensor_state = 'Stop'";

  $resBill2 = mysqli_query($conn,$sqlBill2);

  $rowBill2 = mysqli_fetch_array($resBill2,MYSQLI_ASSOC);

  $stop_price = $rowBill2['sensor_price'];

  //echo "stop price: ".$stop_price;
  ///

  $sqlTotal = "SELECT sensorUse.usedTime, sensorUse.PausedTime FROM sensorUse INNER JOIN sensors ON sensors.sensor_id = sensorUse.sensor_id WHERE sensors.user_id='$user_id'";

  $resTotal = mysqli_query($conn,$sqlTotal);

  $temptotal = 0;

  while($row = mysqli_fetch_array($resTotal,MYSQLI_ASSOC))
  {
    $temptotal += ((($row['usedTime']/3600)*$running_price) + (($row['PausedTime']/3600)*$stop_price));
  }

  $temptotal = round($temptotal*0.10,2);
  //$temptotal = round($temptotal,2);

  $sqlInsertBill = "UPDATE USERS SET billing = '$temptotal' WHERE user_id = '$user_id'";
  $resInsertBill = mysqli_query($conn,$sqlInsertBill);

  if($resInsertBill)
  {
    echo "success";
  }else{
    echo "Error: " . mysqli_error($conn);
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

        <div class="row">
          <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-dot-circle-o fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">5</p>
                    <p class="announcement-text">Total Sensors</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Number of active sensors
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-futbol-o fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">2</p>
                    <p class="announcement-text">Total Stations</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Number of Sensor stations located
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-dollar fa-5x" aria-hidden="true"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?php echo $temptotal."$" ?></p>
                    <p class="announcement-text">Due Bill</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                     <a href="paybill.php"> Bill Payment </a>
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-dollar fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">$1000</p>
                    <p class="announcement-text">Paid Bill</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Bill amount Paid 
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div><!-- /.row -->




            <div class="m-0 col-md-4 col-sm-4 col-xs-12" >
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h2>Sensor Status</h2>
                  
                  <div class="clearfix" style = "overflow:auto"></div>
                </div>
                <div class="m-0 panel-body">
                  <h4>Sensors classified by status</h4>
                  
                  <div class="widget_summary" style="margin: 10px 0 0 0">
                    <div class="w_left w_25">
                      <span>Active</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:60%">
                       </div>
                     </div>
                    </div>
                    <div class="w_right w_20">
                      <span></span>
                    </div>
                    <div class="clearfix"></div>
                  </div>

                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>Paused</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                       <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:20%">
                       </div>
                     </div>
                    </div>
                    <div class="w_right w_20">
                      <span></span>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>Terminated</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                      <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:10%">
                       </div>
                      </div>
                    </div>
                    <div class="w_right w_20">
                      <span></span>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  </div>
                </div>
              </div>


               <div class="m-0 col-md-4 col-sm-4 col-xs-12" >
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h2>Sensor Station Status</h2>
                  
                  <div class="clearfix" style = "overflow:auto"></div>
                </div>
                <div class="m-0 panel-body">
                  <h4>Sensor Stations classified by status</h4>
                  
                  <div class="widget_summary" style="margin: 10px 0 0 0">
                    <div class="w_left w_25">
                      <span>Active</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                       </div>
                     </div>
                    </div>
                    <div class="w_right w_20">
                      <span></span>
                    </div>
                    <div class="clearfix"></div>
                  </div>

                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>Paused</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                       <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                       </div>
                     </div>
                    </div>
                    <div class="w_right w_20">
                      <span></span>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>Terminated</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                      <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                       </div>
                      </div>
                    </div>
                    <div class="w_right w_20">
                      <span></span>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  </div>
                </div>
              </div>





              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h2>Sensor Types</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                   <div id="container" style="min-width: 310px; height: 220px; max-width: 600px; margin: 0 auto">
                     <script>
      
// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    exporting: { enabled: false },
    credits: {
      enabled: false
  },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        colorByPoint: true,
        data: [{
            name: 'Temparature',
            y: 50.41,
            sliced: true,
            selected: true
        }, {
            name: 'Pressure',
            y: 40.84
        }, {
            name: 'Humidity',
            y: 20.85
        }, {
            name: 'Speed',
            y: 34.67
        }, {
            name: 'Smoke',
            y: 27.18
        }]
    }]
});
    </script>
                   </div>
                  </div>
                </div>
              </div>





              <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h2>Sensors</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                    <p class="text-muted font-13 m-b-30">
                      
                    </p>
                    <table id="datatable1" class="table table-striped table-bordered">
                      <thead>
                         <tr>
                          <th>Name</th>
                          <th>Type</th>
                          <th>Location</th>
                          <th>Status</th>
                          <th>Start date</th>
                          <th>Used Time</th>
                          <th>Paused Time</th>
                          <th>Change Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                            <td>Humid Details</td>
                            <td>Humidity</td>
                            <td>San Francisco</td>
                            <td>Active</td>
                            <td>1 Oct 2017</td>
                            <td>2 hours 21 mins</td>
                            <td>20 hours</td>
                            
                            <td>
                           <input type="submit" name="action" class="btn btn-round btn-xs btn-success" value="Start" disabled/ >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-primary" value="Pause" / >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-danger" value="Stop" / >
                              <input type="hidden" name="id" value="">
                           
                            </td>
                            </tr>   

                             <tr>
                            <td>Pressure Sensor</td>
                            <td>Pressure</td>
                            <td>San Francisco</td>
                            <td>Active</td>
                            <td>21 Nov 2017</td>
                            <td>3 hours 12 mins</td>
                            <td>12 hours</td>
                            
                            <td>
                           <input type="submit" name="action" class="btn btn-round btn-xs btn-success" value="Start" disabled/ >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-primary" value="Pause" / >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-danger" value="Stop" / >
                              <input type="hidden" name="id" value="">
                           
                            </td>
                            </tr>    

                             <tr>
                            <td>Temperature Details</td>
                            <td>Temperature</td>
                            <td>San Francisco</td>
                            <td>Active</td>
                            <td>13 May 2017</td>
                            <td>21 hours 19 mins</td>
                            <td>57 hours</td>
                            
                            <td>
                           <input type="submit" name="action" class="btn btn-round btn-xs btn-success" value="Start" disabled/ >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-primary" value="Pause" / >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-danger" value="Stop" / >
                              <input type="hidden" name="id" value="">
                           
                            </td>
                            </tr> 

                             <tr>
                            <td>Speed Details</td>
                            <td>Speed</td>
                            <td>San Francisco</td>
                            <td>Active</td>
                            <td>13 Dec 2017</td>
                            <td>1 hours 3 mins</td>
                            <td>34 hours</td>
                            
                            <td>
                           <input type="submit" name="action" class="btn btn-round btn-xs btn-success" value="Start" disabled/ >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-primary" value="Pause" / >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-danger" value="Stop" / >
                              <input type="hidden" name="id" value="">
                           
                            </td>
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
                    <h2>Clusters</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                    <p class="text-muted font-13 m-b-30">
                      
                    </p>
                    <table id="datatable2" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>No. of Sensors</th>
                          <th>Status</th>
                          <th>Start date</th>
                          <th>Used Time</th>
                          <th>Paused Time</th>
                          <th>Change Status</th>
                        </tr>
                      </thead>

                      <tbody>
                       <tr>
                            <td>San Jose Station</td>
                            <td>5</td>
                            <td>Active</td>
                            <td>1 Oct 2017</td>
                            <td>201 hours</td>
                            <td>34 hours</td>
                            <td>
                            
                            <form method="post" action="">
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-success" value="Start" disabled/ >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-primary" value="Pause" / >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-danger" value="Stop" / >
                              <input type="hidden" name="id" value="">
                          
                            </form>
                           
                            </td>
                            </tr>

                            <tr>
                            <td>San Francisco Station</td>
                            <td>5</td>
                            <td>Active</td>
                            <td>21 Jan 2017</td>
                            <td>451 hours</td>
                            <td>56 hours</td>
                            <td>
                            
                            <form method="post" action="">
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-success" value="Start" disabled/ >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-primary" value="Pause" / >
                              <input type="submit" name="action" class="btn btn-round btn-xs btn-danger" value="Stop" / >
                              <input type="hidden" name="id" value="">
                          
                            </form>
                           
                            </td>
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
