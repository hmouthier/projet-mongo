<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet"
href="http://openlayers.org/en/v3.1.1/css/ol.css" type="text/css">
    <style>
      .map {
        height: 800px;
        width: 100%;
      }
    </style>
    <script src="http://openlayers.org/en/v3.1.1/build/ol.js" type="text/javascript"></script>
    <title>OpenLayers </title>
 <script src="ajax.js" type="text/javascript"></script>
    <script src="jquery.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
     




  </head>
  <body >
   
    <div id="map" class="map"></div>
    


    <script type="text/javascript">
            // Crate a style instance given feature's properties name and radius.
     
              
              var vert=[0,255,0];
              var rouge=[255,0,0];
              var bleu=[0,0,255];
function computeFeatureStyle(feature,note) {
            parseInt((note-50)*2.55*2)
              if(note>80){
                var couleur=[0,(note-80)*12 +2,0];

              }else{
                var couleur=[255,0,0];
                
              }

                return new ol.style.Style({
                    image: new ol.style.Circle({
                        radius: feature.get('radius'),
                        fill: new ol.style.Fill({
                            color: 'rgba('+couleur[0]+','+couleur[1]+','+couleur[2]+',1)'
                        }),
                        stroke: new ol.style.Stroke({
                            color: 'rgba('+couleur[0]+','+couleur[1]+','+couleur[2]+',1)',
                            width: 1
                        })
                    })
                });
            }
            

            // Create point features
            var i,  geom, feature, features = [], style;
            var zoom=6;
               
                                // var projFrom = new OpenLayers.Projection("EPSG:4326");
                                //     var projTo = new OpenLayers.Projection("EPSG:2154")
                                // var cproj = center.transform(projFrom, projTo);
                function createcircle(lat,lon,zoom,i,note){
                 
                geom = new ol.geom.Point(
                    ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857')
                );

                
                feature = new ol.Feature({
                    geometry: geom,
                    radius: zoom,
                    name:  i 
                });
               
                features.push(feature);
               
                style = computeFeatureStyle(feature,note);
                feature.setStyle(style);
                }
function lancementopenlayer(){
      var vectorSource = new ol.source.Vector({
                features: features
            });

            var vectorLayer = new ol.layer.Vector({
                source: vectorSource
            });

            // Maps




            var map = new ol.Map({
                    target: 'map',  // The DOM element that will contains the map
                    renderer: 'canvas', // Force the renderer to be used
                    allOverlays: true,
                    layers: [
                        // Add a new Tile layer getting tiles from OpenStreetMap source
                        new ol.layer.Tile({
                            source: new ol.source.MapQuest({layer: 'osm'}),
                            transparent: "true",
                        }),
                        vectorLayer
                        ],


                    // Create a view centered on the specified location and zoom level
                    view: new ol.View({
                        center: ol.proj.transform([2.34, 46.36], 'EPSG:4326', 'EPSG:3857'),
                        zoom: zoom
                    })
                });
}



                

        var data=$.getJSON("bd.php",    // le fichier qui recevera la requête
                              {},  // les paramètres en entrée 6.0003 45.9994
                              function(return_json){                                      // la fonction qui traitera l'objet reçu
                               

                                console.log( return_json );
                                
                                for (var id in return_json) { 
                                    data=return_json[id];
                                     createcircle(parseFloat(data["Y"]),parseFloat(data["X"]),10,data["numero"],parseInt(data["reussite"]));
                                

                                }

                                lancementopenlayer();
                               
                                  

                              }
                    );
        









              


          
    </script>
  </body>
</html>