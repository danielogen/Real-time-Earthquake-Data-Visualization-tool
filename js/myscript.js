/******************************************************
*
* custom JScripts for Geo-spaital visualization
*
*******************************************************/ 	
 	
  //check internet connectivity before loading online map
    var online;
    // check whether this function works (online only)
    try {
      var x = google.maps.MapTypeId.TERRAIN;
      online = true;
    } catch (e) {
      online = false;
    }

   //extract content from database 
   // need a load to populate the array
    $.ajax({                                      
            url: 'mapdata.php',                //the script to call to get data          
            success: function (data, textStatus, jqXHR) {            
                mapdatacomplete (data);
        } 
    });
    
    //load map with location filter selected
    var selected;
   $('#name').on('change',function (e) {
            e.preventDefault();
            selected = $('select[name=places]').val();
        
        $.ajax({                                      
                url: 'mapdata.php?q=' + selected,                //the script to call to get data          
                success: function (data, textStatus, jqXHR) {
                    mapdatacomplete (data);
                }
    });
 });
 
 //general map function
 function mapdatacomplete ( data){
     var myarray = data.split('*');
            var realdata  = new Array(Math.ceil((myarray.length)/8));
            counter = 0;
            for (i = 0; i< realdata.length; i++) {
                    realdata [i]= new Array(8);
                    for (j = 0; j<8; j++) {
                            realdata [i][j] = myarray[counter];
                            counter = counter + 1;
                            //console.log( testing[i][j]);
                    }
            }

            //function to build the map
    function initialize(location) {

            var locations = location;
            
                var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 2,
                  center: new google.maps.LatLng(30.4333, 3.5463),
                  mapTypeId: google.maps.MapTypeId.ROADMAP,

                  //customize zoom position      
                  zoomControl: true,
                    zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                  }
                });

                var infowindow = new google.maps.InfoWindow();

                var marker, i;
                var iconBase = '/EarthQuake/icons/';
                var icons = {
                    red: {
                        icon: iconBase + 'red.png'
                    },
                    green: {
                        icon: iconBase + 'green_dot.png'
                    },
                    blue: {
                        icon: iconBase + 'blue_dot.png'
                    }
                };

                for (i = 0; i < locations.length; i++) {  
                     if(locations[i][2] > 2.4 && locations[i][2] < 4.0){
                      marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][5], locations[i][6]),                        
                        icon: icons['blue'].icon,
                        map: map
                      });
                     google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                          infowindow.setContent('Place: <b>' + locations[i][0]+ '</b><br>' + 'Magnitude: ' + locations[i][2]+ '<br>' + 
                                                'Date: ' + locations[i][3]+ '<br>' + 'Time: ' + locations[i][4]+ '<br>' + 
                                                'Depth(km): ' + locations[i][7]);
                          infowindow.open(map, marker);
                        }
                      })(marker, i));
                    }
                    else if(locations[i][2] > 3.9 && locations[i][2] < 5.0){
                      marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][5], locations[i][6]),                        
                        icon: icons['green'].icon,
                        map: map
                      });
                     google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                          infowindow.setContent('Place: <b>' + locations[i][0]+ '</b><br>' + 'Magnitude: ' + locations[i][2]+ '<br>' + 
                                                'Date: ' + locations[i][3]+ '<br>' + 'Time: ' + locations[i][4]+ '<br>' + 
                                                'Depth(km): ' + locations[i][7]);
                          infowindow.open(map, marker);
                        }
                      })(marker, i));
                    }
                    else if(locations[i][2] > 4.9 ){
                      marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][5], locations[i][6]),                        
                        //: icons['blue'].icon,
                        map: map
                      });
                     google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                          infowindow.setContent('Place: <b>' + locations[i][0]+ '</b><br>' + 'Magnitude: ' + locations[i][2]+ '<br>' + 
                                                'Date: ' + locations[i][3]+ '<br>' + 'Time: ' + locations[i][4]+ '<br>' + 
                                                'Depth(km): ' + locations[i][7]);
                          infowindow.open(map, marker);
                        }
                      })(marker, i));
                    }
              }
             }  

            if(online){
                google.maps.event.addDomListener(window, 'load', initialize(realdata)); //start map   
            }else{
                //alert('looks like you have lost internet connectivity')
            }    

 }
        
//auto-refresh page
function AutoRefresh( t ) {
    setTimeout("location.reload(true);", t);
}

// make the legend draggable
$(function (){
    $( "#legend" ).draggable();
});

//hide the advanced filter form until the button is clicked

$(document).ready(function(){
    $('#frm_advancedsearch').hide();
    
    $('.btn-advancedsearch').on('click', function(){
        $('#frm_advancedsearch').fadeIn(500);
    });
    
    //datepicker
    $('.bydateFr, .bydateTo').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    
    //cancel advanced search
    $('.btn-cancel').on('click', function(e){
        e.preventDefault();
        $('#frm_advancedsearch').fadeOut(800);
    });
    
});