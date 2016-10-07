<?php
    //function to parse the rss feeds
    function fetch_earthquake_data() {
            $data = simplexml_load_file('http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.atom');		
            
            foreach ($data->entry as $entry) {

                $buildtitle     = 	$entry->title;    		
                $buildtitle	= 	explode("-", $buildtitle); //only two elements created
                    if(count($buildtitle) > 2){                    //correct title after running explode 													
                        $title_sub  =	implode("-", $buildtitle); //incase more than 2 elements created
                        $title_sub  =	explode(" - ", $title_sub); // explode the original string(" - ")                                                                                       
                        $title      = 	$title_sub[1];              //and take correct title
                    }else{
                        $title      =	$buildtitle[1];				
                    }
                //build places from title
                $places 	=       explode(",", $title);				
                    if($places[1] == ""){                           //some small house keeping
                            $place = $places[0];
                    }else {
                            $place = $places[1];
                    }
                $mag		=       $buildtitle[0];
                $mag		=       explode(" ", 	$mag);     //build magnitude from the remaining string
                $magnitude	=       $mag[1];

                $updated 	= 	$entry->updated;           //use this field to build date and time
                $updated	= 	explode("T", $updated);
                $date		= 	$updated[0];
                $realtime	=	$updated[1];

                //$category	= 	$entry->category; //extract age here(past hour, past day, past month, etc)
                //$age		=	$category->children(term);

                //get coordinates
                $namespaces     = 	$entry->getNameSpaces(true);	
                $geo            = 	$entry->children($namespaces['georss']);    		    		    	 
                $loc            = 	explode(" ", $geo->point);
                $lat            =       $loc[0]; 	//latitude 
                $long           =       $loc[1];        //longitude 	
                //calculate the depth of the earthquake in km
                $depth          = 	abs(($geo->elev)/1000);

                
                //insertion each record into the database using load_extracted function 
                load_extracted($title, $place, $magnitude, $date, $realtime, $lat, $long, $depth);

             }
    }

    //loading extracted information to database
    function load_extracted ($title, $place, $mag, $date, $time, $lat, $long, $depth){
        //prepare for insertion to avoid sql injectio attack
        $eq_title		= 	mysql_prep(trim($title));
        $eq_place 		= 	mysql_prep(trim($place));
        $eq_mag 		= 	mysql_prep(trim($mag));
        $eq_date 		= 	mysql_prep(trim($date));
        $eq_time		= 	mysql_prep(trim($time));
        $eq_lat                 = 	mysql_prep(trim($lat));
        $eq_long		= 	mysql_prep(trim($long));
        $eq_depth		= 	mysql_prep(trim($depth));		

        $query_select           =       "SELECT eq_date, eq_time, eq_lat, eq_long FROM eq_details";
        $result			=	mysql_query($query_select) or die(mysql_error());
        //$result_test = mysql_fetch_assoc($result);		
        if(mysql_num_rows($result) < 1){ //This means there are no records in the database yet

                $query_insert = "INSERT INTO eq_details (eq_title, eq_place, eq_mag, eq_date, eq_time, eq_lat, eq_long, eq_depth) 
                                 VALUES('{$eq_title}', '{$eq_place}', '{$eq_mag}', '{$eq_date}', '{$eq_time}', '{$eq_lat}', 
                                         '{$eq_long}', '{$eq_depth}')";

                $query_result = mysql_query($query_insert) or die(mysql_error());
        }else{
                //check for a hit in the database
                $match_not_found = 0;  
                $match_found	 = 0;
                while($row       = mysql_fetch_array($result)) {		
                        //Avoid duplicate entry if hit is found
                        if($eq_date != "{$row['eq_date']}" || $eq_time != "{$row['eq_time']}" || $eq_lat != "{$row['eq_lat']}"
                           || $eq_long != "{$row['eq_long']}"){
                
                            $match_not_found = 0;	
                        }else { 
                            $match_found     = 1;
                        } 
                }
                if($match_not_found == 0 && $match_found == 0 ){
                    $query_insert  = "INSERT INTO eq_details (eq_title, eq_place, eq_mag, eq_date, eq_time, eq_lat, eq_long, eq_depth) 
                                      VALUES('{$eq_title}', '{$eq_place}', '{$eq_mag}', '{$eq_date}', '{$eq_time}', '{$eq_lat}', 
                                              '{$eq_long}', '{$eq_depth}')";

                    $query_result  = mysql_query($query_insert) or die(mysql_error());
                }
        }
    }
    
    //function to check internet connection
    
    function is_internet(){
      $connected = @fopen("http://www.google.com:80/","r");
      if($connected)
      {
         return true;
      } else {
         return false;
      }
      
    } 

