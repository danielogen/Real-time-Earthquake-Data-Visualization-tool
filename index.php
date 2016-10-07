<?php
//include database connection and mysql_prep() function
include("extracted.php");
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Daniel Ogen" >

        <title>Real-Time Data - Earthquake</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="css/plugins/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jquery ui styling -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

        <!-- my custom styling -->
        <link href="css/mycss.css" rel="stylesheet" type="text/css">   

        <script src="https://maps.googleapis.com/maps/api/js"></script>


    </head>

    <body onload="JavaScript:AutoRefresh(60000);">

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Real-Time Earthquake Data</a>
                </div>
                <?php
                //get number of earthquake and their details that occurred today
                $today = date("Y-m-d");
                $db_query1 = mysql_query("SELECT eq_title, COUNT(id) AS eq_no_today FROM eq_details
                                          WHERE eq_date= '{$today}'") or die(mysql_error());
                $eq_no_today = mysql_fetch_array($db_query1);
                ?>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <span class="label label-danger"><?php echo $eq_no_today['eq_no_today']; ?> </span></a>
                        <ul class="dropdown-menu alert-dropdown">
                            <li>
                                <a href="#">Notification <span class="label label-danger"><?php echo $eq_no_today['eq_no_today']; ?></span></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a data-toggle="modal" href="#myModal">View details</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> GU <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-fw fa-bell"></i>Notification <span class="label label-danger"><?php echo $eq_no_today['eq_no_today']; ?></span></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="active">
                            <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>                        
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>

            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <div class="row">
                        <div class="col-lg-12"> 
                            <ol class="breadcrumb">
                                <li class="active">
                                    <i class="fa fa-dashboard"></i> Dashboard - Worldwide Geospatial Visualization of Real-time Earthquake Data
                                </li>
                            </ol>
                        </div>
                    </div> -->
                    <!-- /.row -->

                    <div class="row">
                        <!-- my map goes here -->
                        <div id = 'overlaying'> 
                            <?php
                            $db_query = mysql_query('SELECT eq_place, COUNT(eq_place) AS eq_no_place FROM eq_details 
                                                    GROUP BY eq_place 
                                                    ORDER BY eq_place ASC') or die(mysql_error());

                            echo '<select  id = "name" name = "places">';
                            echo "<option value = \"\">Filter by Places...</option>";
                            while ($row = mysql_fetch_array($db_query)) {
                                echo "<option value = \"{$row['eq_place']}\">{$row['eq_place']} ({$row['eq_no_place']})</option>";
                            }

                            echo '</select>';
                            ?>
                        </div> 
                        <div id = 'advancedsearch'> 
                            <button class="btn btn-warning btn-advancedsearch">Advanced Filter</button>
                            <form id="frm_advancedsearch" method="get">
                                <br/>
                                <label>By Date : From : </label> <input type="text" id="bydateFr" name="bydateFr" class="bydateFr" /> &nbsp;&nbsp;&nbsp;
                                <b>To</b> : <input type="text" id="bydateTo" name="bydateTo" class="bydateTo" /><br/>
                                <label>By Magnitude:</label> <input type="text" id="bymg" name="bymg" class="bymg" /><br/>
                                <label>By Depth(km) : </label> <input type="text" id="bydepth" name="bydepth" class="bydepth" /><br/>
                                <p><input type="submit" id="submit_filter" name="submit_filter" class="btn btn-sm btn-success submit_filter" value="Go" />
                                    <button class="btn btn-sm btn-danger btn-cancel">Cancel</button></p>
                            </form>
                        </div>
                        <div id = 'legend'> 
                            <p>Magnitude
                                <br/><br/> <img src="icons/blue_dot.png"> ------------------------------- 2.5 - 3.9
                                <br/> <img src="icons/green_dot.png"> ------------------------------ 4.0 - 4.9
                                <br/> <img src="icons/red.png"> ------------------------------ 5.0+
                            </p>
                        </div>
                        <div id="map">

                        </div>                 
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Morris Charts JavaScript
        <script src="js/plugins/morris/raphael.min.js"></script>
        <script src="js/plugins/morris/morris.min.js"></script>
        <script src="js/plugins/morris/morris-data.js"></script>
        -->
        <!-- draggable -->
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

        <script src="js/myscript.js"></script>


    </body>

</html>


<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Earthquake Today <span class="label label-danger"><?php echo $eq_no_today['eq_no_today']; ?></span></h4>
            </div>
            <div class="modal-body">

                <?php
                    $today = date("Y-m-d");
                    $db_query3 = mysql_query("SELECT * FROM eq_details WHERE eq_date= '{$today}'
                                              ORDER BY id DESC ") or die(mysql_error());
                    while($row = mysql_fetch_array($db_query3)) {
                if ($row['eq_mag'] >= 2.5 && $row['eq_mag'] <= 3.9) {
                    ?>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info">
                            <h5 class="list-group-item-heading"><?php echo "<b>" . $row['eq_title'] . "</b>"; ?></h5>
                            <p class="list-group-item-text">Date: <?php echo $row['eq_date']; ?> , Magnitude: <?php echo $row['eq_mag']; ?> , Depth(km): <?php echo $row['eq_depth']; ?> <br>
                                Lat/Long: <?php echo $row['eq_lat'] . "," . $row['eq_long']; ?> , Time: <?php echo $row['eq_time']; ?>
                            </p>
                        </a>
                    </div>
                    <?php

                }else if ($row['eq_mag'] >= 4.0 && $row['eq_mag'] <= 4.9) { ?>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action list-group-item-success">
                        <h5 class="list-group-item-heading"><?php echo "<b>" . $row['eq_title'] . "</b>"; ?></h5>
                        <p class="list-group-item-text">Date: <?php echo $row['eq_date']; ?> , Magnitude: <?php echo $row['eq_mag']; ?> , Depth(km): <?php echo $row['eq_depth']; ?> <br>
                            Lat/Long: <?php echo $row['eq_lat'] . "," . $row['eq_long']; ?> , Time: <?php echo $row['eq_time']; ?>
                        </p>
                    </a>
                </div>
                <?php
                }else{
                ?>
                <div class="list-group" >
                    <a href = "#" class="list-group-item list-group-item-action list-group-item-danger" >
                        <h5 class="list-group-item-heading" ><?php echo "<b>" . $row['eq_title'] . "</b>"; ?></h5>
                        <p class="list-group-item-text">Date: <?php echo $row['eq_date']; ?> , Magnitude: <?php echo $row['eq_mag']; ?> , Depth(km): <?php echo $row['eq_depth']; ?> <br>
                            Lat/Long: <?php echo $row['eq_lat'] . "," . $row['eq_long']; ?> , Time: <?php echo $row['eq_time']; ?>
                        </p>
                </a>
            </div>
            <?php
             }
            }
            ?>

            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn btn-success">Close</a>
            </div>
        </div>
    </div>
</div>