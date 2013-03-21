<?php
$key = "AIzaSyBs_zroV5geRbULd3G4ZY58D2s18ZcTUU4";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style type="text/css">
            html { height: 100% }
            body { height: 100%; margin: 0; padding: 0 }
            #map-canvas { height: 100% }
        </style>
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?libraries=visualization,drawing&key=<?php echo $key; ?>&sensor=false">
        </script>
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
        <script type="text/javascript">
            marker = null;
            map = null;
    
          
            /* Data points defined as an array of LatLng objects */
            var heatmapData = [
                new google.maps.LatLng(37.782, -122.447),
                new google.maps.LatLng(37.782, -122.445),
                new google.maps.LatLng(37.782, -122.443),
                new google.maps.LatLng(37.782, -122.441),
                new google.maps.LatLng(37.782, -122.439),
                new google.maps.LatLng(37.782, -122.437),
                new google.maps.LatLng(37.782, -122.435),
                new google.maps.LatLng(37.785, -122.447),
                new google.maps.LatLng(37.785, -122.445),
                new google.maps.LatLng(37.785, -122.443),
                new google.maps.LatLng(37.785, -122.441),
                new google.maps.LatLng(37.785, -122.439),
                new google.maps.LatLng(37.785, -122.437),
                new google.maps.LatLng(37.785, -122.435)
            ];

            var sanFrancisco = new google.maps.LatLng(37.774546, -122.433523);

            map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: sanFrancisco,
                zoom: 4,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var heatmap = new google.maps.visualization.HeatmapLayer({
                data: heatmapData
            });
            heatmap.setMap(map);
            var myLatlng = new google.maps.LatLng(-25.363882,131.044922)
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title:"Hello World!"
            });
            setTimeout(function(map){
     
                map.removeOverlay(marker);
            }, 2000);
      
    
        </script>
    </head>
    <body>
        <div id="map-canvas"/>

        <script type="text/javascript">
            marker = null;
            map = null;
    
          
            /* Data points defined as an array of LatLng objects */
            var heatmapData = [
                new google.maps.LatLng(37.782, -122.447),
                new google.maps.LatLng(37.782, -122.445),
                new google.maps.LatLng(37.782, -122.443),
                new google.maps.LatLng(37.782, -122.441),
                new google.maps.LatLng(37.782, -122.439),
                new google.maps.LatLng(37.782, -122.437),
                new google.maps.LatLng(37.782, -122.435),
                new google.maps.LatLng(37.785, -122.447),
                new google.maps.LatLng(37.785, -122.445),
                new google.maps.LatLng(37.785, -122.443),
                new google.maps.LatLng(37.785, -122.441),
                new google.maps.LatLng(37.785, -122.439),
                new google.maps.LatLng(37.785, -122.437),
                new google.maps.LatLng(37.785, -122.435)
            ];

            var sanFrancisco = new google.maps.LatLng(37.774546, -122.433523);
            var austin = new google.maps.LatLng(30.3389, -97.7707);
            var costaRica = new google.maps.LatLng(10.1333 , -84.4833);

            var gui = {
                maxVisitors: 30,
                visitors:  new Array(),
                heatCounter: 0,
                lastTimestamp: '',
                coordinates: [],
                useHeat: true,
                map: new google.maps.Map(document.getElementById('map-canvas'), {
                    center: sanFrancisco,
                    zoom: 4,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }),
                heatmaps: [],
                addVisitor: function(latitude, longitude, timestamp){
                    
                    position = new google.maps.LatLng(latitude, longitude);
                    this.coordinates.push(position);
                    var marker = new google.maps.Marker({
                        position: position,
                        title: timestamp.toString()
                    });
                    
                   
                   
                    if(this.useHeat){
                        this.heatCounter++;
                        if(this.heatCounter >= 30){
                            
                            newHeatmap = new google.maps.visualization.HeatmapLayer({
                                data: this.coordinates
                            });
                            newHeatmap.setOptions({radius: 10});
                            newHeatmap.setMap(this.map);
                            newCount = this.heatmaps.push(newHeatmap);
                            if(newCount >3){
                                oldMap = this.heatmaps.shift();
                                oldMap.setMap();
                                delete oldMap;
                            }
                            this.heatCounter = 0;
                        }
                    }
                    marker.setMap(this.map);
                    
                    
                    len = this.visitors.push(marker);
                    
                    if(len > this.maxVisitors){
                        toRemove = this.visitors.shift();
                        toRemove.setMap();
                        delete toRemove;
                        this.coordinates.shift();
                    }
                    
                   
                    
                },
                loop: function(){
                    response = $.ajax('api.php?action=get&timestamp=' + this.lastTimestamp,{
                        success:function(res){
                            if(res != null){
                                gui.addVisitor(res.Latitude, res.Longitude, res.Timestamp);
                                gui.lastTimestamp = res.Timestamp;
                            }
                        }
                    });
                    
                    setTimeout(function(){gui.loop();}, 500);
                }
            }
            
            
            gui.addVisitor(30.3389, -97.7707,1);
            gui.addVisitor(37.774546, -122.433523, 22);
            gui.loop();
            // gui.heatmap.setMap(gui.map);
           
            
    
        </script>
    </body>
</html>