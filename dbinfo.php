<?php
	include('constants.php');

	$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	if(!$con){
		die('server could not be started'.mysql_error());
	}

	//taking care of sql injection attack - using magic_quotes and mysql_real_escape
	function mysqli_prep($value){
            $magic_quotes_active = get_magic_quotes_gpc();
            $new_enough_php = function_exists("mysql_real_escape_string");

	  if($new_enough_php){
		   if($magic_quotes_active){ $value = stripslashes($value); }
		   $value = mysqli_real_escape_string($value);
	  }else{
	     	if(!$magic_quotes_active){$value = addslashes($value); }
	 }

  		return $value;
  }

?>
