<?php
    //include database connection and mysql_prep() function
    include("dbinfo.php");	
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_GET['q']) && !empty($_GET['q'])){

    $db_query = mysql_query("SELECT * FROM eq_details
                            WHERE eq_title LIKE '%{$_GET['q']}%'
                            ") or die(mysql_error());	
		
    $myarray = array();
    $counter = 1;
    while($row = mysql_fetch_array($db_query)) {
            if($counter == (mysql_num_rows($db_query))){
                    $myarray[$counter] =  $row['eq_title'].'*'. $row['eq_place'].'*'. $row['eq_mag'].'*'. $row['eq_date'].'*'. $row['eq_time'].'*'.$row['eq_lat'].'*'.$row['eq_long'].'*'.$row['eq_depth'];
            }else{
                    $myarray[$counter] =  $row['eq_title'].'*'. $row['eq_place'].'*'. $row['eq_mag'].'*'. $row['eq_date'].'*'. $row['eq_time'].'*'.$row['eq_lat'].'*'.$row['eq_long'].'*'.$row['eq_depth'].'*';
            }
            $counter++;

    }
    $i = 1;
    while ($i <= count($myarray)){
            echo $myarray[$i];
            $i++;
    }
}else {
    $db_query = mysql_query("SELECT * FROM eq_details") or die(mysql_error());	
		
    $myarray = array();
    $counter = 1;
    while($row = mysql_fetch_array($db_query)) {
            if($counter == (mysql_num_rows($db_query))){
                    $myarray[$counter] =  $row['eq_title'].'*'. $row['eq_place'].'*'. $row['eq_mag'].'*'. $row['eq_date'].'*'. $row['eq_time'].'*'.$row['eq_lat'].'*'.$row['eq_long'].'*'.$row['eq_depth'];
            }else{
                    $myarray[$counter] =  $row['eq_title'].'*'. $row['eq_place'].'*'. $row['eq_mag'].'*'. $row['eq_date'].'*'. $row['eq_time'].'*'.$row['eq_lat'].'*'.$row['eq_long'].'*'.$row['eq_depth'].'*';
            }
            $counter++;

    }
    $i = 1;
    while ($i <= count($myarray)){
            echo $myarray[$i];
            $i++;
    }
}


