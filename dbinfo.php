<?php
	include('constants.php');
	
	$con=mysql_connect(DB_SERVER,DB_USER,DB_PASS);
	if(!$con){
		die('server could not be started'.mysql_error());
	}
	$db=mysql_select_db(DB_NAME,$con);
	if(!$db){
		die('database not found'.mysql_error());
	}
	
	//taking care of sql injection attack - using magic_quotes and mysql_real_escape
	function mysql_prep($value){
            $magic_quotes_active = get_magic_quotes_gpc();
            $new_enough_php = function_exists("mysql_real_escape_string");
	 
	  if($new_enough_php){ 
		   if($magic_quotes_active){ $value = stripslashes($value); }
		   $value = mysql_real_escape_string($value);
	  }else{
	     	if(!$magic_quotes_active){$value = addslashes($value); }
	 }
  
  		return $value;
  }
  
 /** function logging($name, $recieptno){
	//echo time();
	date_default_timezone_set('Africa/Nairobi');
	$date=date('Y-m-d');
	$time=date('h:i:s');
	
	$qry=mysql_query("INSERT INTO logging (Name, RecieptNo, Date, Time)
					VALUES('{$name}','{$recieptno}','{$date}','{$time}')") or die(mysql_error());
}**/

?>