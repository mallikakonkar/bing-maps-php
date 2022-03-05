<!DOCTYPE html>
<html>
  <head>
    <script>
      var Locations1=[];
      var LocationCoordinates=[];
    </script>
  <?php

  session_start();
  $ip_add = getenv("REMOTE_ADDR");
  include "db.php";
  $user_id = $_SESSION["uid"];
  if (isset($_SESSION["uid"])) 
  {
    $sql2 = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,a.product_cat 
             FROM products a,cart b
             WHERE a.product_id=b.p_id AND b.user_id = '$user_id'";
  }

  $res=mysqli_query($con,$sql2); 
  $list=mysqli_fetch_all($res);

  // print_r($list);

  for($i=0;$i<sizeof($list);$i++)
  {
    ?>

    <script>
      
      Locations1.L1=<?php echo $list[$i][0]?>;
      Locations1.L2=<?php echo $list[$i][0]?>;

      LocationCoordinates.push(Locations1);
      Locations1=[];

    </script>

    <?php
  } 
  ?>

    <title></title>
    <meta charset="utf-8" />
    <script type="text/javascript">
      var map;
      // console.log(Locations1);
      console.log(LocationCoordinates);
      var directionsManager;
      var distance=1.88;
      var Locations = [
        {
        "L1": 40.740620,
        "L2": -73.616745
        },
        {
        "L1": 40.737354,
        "L2": -73.614042
        },
        {
        "L1": 40.739629,
        "L2": -73.614214
        }
        ];

      //console.log(Locations[0].L1);

      var Mat=[];

      for (let i = 0; i< 3; i++) 
      {
        for(let j = 0; j< 3; j++) 
        {
          Mat[i] = [];
        }
      }

      // console.log(Mat);
      
      function GetMap()
      {
        map = new Microsoft.Maps.Map('#myMap', {});

        //Load the directions module.
        Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
        
        //Create an instance of the directions manager.
        directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);

        //Specify where to display the route instructions.
        directionsManager.setRenderOptions({ itineraryContainer: '#directionsItinerary' });

        //Specify the where to display the input panel
        directionsManager.showInputPanel('directionsPanel');

        for(var i=0;i<3;i++)
        {
          for(var j=0;j<3;j++)
          {
            var Waypoint1 = new Microsoft.Maps.Directions.Waypoint({ address:  [Locations[i].L1, Locations[i].L2] });
            directionsManager.addWaypoint(Waypoint1);

            var Waypoint2 = new Microsoft.Maps.Directions.Waypoint({ address: [Locations[j].L1, Locations[j].L2] });
            directionsManager.addWaypoint(Waypoint2);

            Microsoft.Maps.Events.addHandler(directionsManager, 'directionsUpdated', directionsUpdated)                          
            directionsManager.calculateDirections();
            console.log(distance);     
            console.log(i+' '+j); 
            Mat[i][j]=distance; 

            
                
            // //Calculate directions.
            // let promise1 = new Promise(function(res, rej){
            //   directionsManager.calculateDirections();
            //   setTimeout(()=>res(),10000);
            // });

            // promise1.then(()=>{
            //   console.log(distance);     
            //   console.log(i+' '+j); 
            //   Mat[i][j]=distance;   
              // arr = [0, 1, 2, ......, 8];

              /* function 1Dto2Darr () {
                mat = [
                  [0,1,2],
                  [3,4,5],
                  [6,7,8]
                ]
              }
              */
              // console.log(Mat[i][j]);        
            // });
            

           
            
           /* 
           console.log(distance);
              
            console.log(i+' '+j); 

            

           Mat[i][j]=distance;

            
           console.log(Mat[i][j]); */

            // directionsManager.clearAll();

          }
            // directionsManager.clearAll();
        }

            // console.log(Mat);
        });
      };

      distMat=[[0,10,15,7,2],[5,0,9,10,80],[6,13,0,12,60],[5,8,4,0,45],[2,8,10,6,0]];  

      var count=0;
      var node=0;
      var shopNodes=[];
      shopNodes.push(0);
      while(count!=distMat.length)
      {
        node=getMinimum(distMat[node],shopNodes);
        shopNodes.push(node);
        count=count+1;
      }

      // console.log(shopNodes);

      function getMinimum(Arr,shopNodes)
      {
        var min=100000;
        var minPos=0;

        for( var i=0;i<Arr.length;i++)
        {
          if(Arr[i]<min && Arr[i]!=0 && !shopNodes.includes(i))
          {
            min=Arr[i];
            minPos=i;
          }
        }

        return minPos;
      }
              

             



     function directionsUpdated(e){
        console.log('enter');
        //Get the current route index.
        var routeIdx = directionsManager.getRequestOptions().routeIndex;
      
        //Get the distance of the route, rounded to 2 decimal places.
        distance = Math.round(e.routeSummary[routeIdx].distance * 100)/100;
      
        //Get the distance units used to calculate the route.
        var units = directionsManager.getRequestOptions().distanceUnit;
        var distanceUnits = '';
      
        if (units == Microsoft.Maps.Directions.DistanceUnit.km) {
            distanceUnits = 'km'
            } else {
                     //Must be in miles
                     distanceUnits = 'miles'
                 }
      
                 //Time is in seconds, convert to minutes and round off.
                 var time = Math.round(e.routeSummary[routeIdx].timeWithTraffic / 60);
      

                 document.getElementById('routeInfoPanel').innerHTML = 'Distance: ' + distance + ' ' + distanceUnits + '<br/>Time with Traffic: ' + time + ' minutes';
                 console.log('in directions updated',distance);
                 //resolve(distance);
      };
         
       

    </script>
    <style>
      html,
      body {
        padding: 0;
        margin: 0;
        height: 100%;
      }

      .directionsContainer {
        width: 380px;
        height: 100%;
        overflow-y: auto;
        float: left;
      }

      #myMap {
        position: relative;
        width: calc(100% - 380px);
        height: 100%;
        float: left;
      }
    </style>
    <script
      type="text/javascript"
      src="http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=At-lrfxKKabyaCNitz2t2aItuHKJf6dO5ltDlMLaQSTsiTPXs10CdJ3eg07vT6Ap"
      async
      defer
    ></script>
    <!-- <script type='text/javascript' src='http://dev.virtualearth.net/REST/V1/Routes/Walking?wp.0=11025%20NE%208th%20St%20Bellevue%20WA&wp.1=700%20Bellevue%20Way%20NE%20Bellevue%20WA&key=At-lrfxKKabyaCNitz2t2aItuHKJf6dO5ltDlMLaQSTsiTPXs10CdJ3eg07vT6Ap'async defer></script> -->
  </head>
  <body>
    <div class="directionsContainer">
      <div id="directionsPanel"></div>
      <div id="directionsItinerary"></div>
      <div id="routeInfoPanel"></div>
    </div>
    <div id="myMap"></div>
  </body>
</html>
