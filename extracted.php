<?php
	//include database connection and mysql_prep() function
	include("dbinfo.php");	
	//includes functions (user_defined)
	include("functions.php");
         //check internet connection before fetching earthquake data
        if(is_internet()){
            //my main function
            fetch_earthquake_data();
        }
	
?>