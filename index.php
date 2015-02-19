<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet"
href="http://openlayers.org/en/v3.1.1/css/ol.css" type="text/css">
    <style>
      .map {
        height: 800px;
        width: 70%;
        display: inline-block;
      }

section
{
    display: inline-block;    
    border: 1px solid blue;
    width: 29%;
    vertical-align: top;
}




.Degrade {
background-image:linear-gradient(to right,#00FF00, black);
}
    </style>
    <script src="http://openlayers.org/en/v3.1.1/build/ol.js" type="text/javascript"></script>
    <title>OpenLayers </title>
 <script src="js/ajax.js" type="text/javascript"></script>
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/camenbert.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
     




  </head>
  <body >
   
    <div id="map" class="map"></div>
    <section>
    <h1>Lycées de France</h1>
    <p>Le rouge indique un lycée ayant un taux de réussite inferieur à 80%</p>
    <div class="Degrade">

  <p  align="center">Réussite supérieur à 80%</p>
</div>


   <p id="id01"></p>
   <p id="id02"></p>
   <p id="id03"></p>
   <p id="id04"></p>
   <p id="id05"></p>
  <!--   <canvas id="camembert"  height="400"></canvas>
    <canvas id="diagramme"  height="400"></canvas> -->
    </section>
    


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


            map.on("click", function(e) {
        map.forEachFeatureAtPixel(e.pixel, function (feature, layer) {
            var mafeature=feature.o.name;
            $.getJSON("php/element.php",    // le fichier qui recevera la requête
                              {"numero": mafeature},  
                              function(return_json){  // la fonction qui traitera l'objet reçu
                               for (var id in return_json) { 
                                    if (id==0){
                                    data=return_json[id];
                                    document.getElementById("id01").innerHTML = data["appellation_officielle_uai"];
                                    }else {
                                        data=return_json[id];
                                    document.getElementById("id02").innerHTML ="Réussite totale de "+ data["reussite_total"]+"% pour un effectif de "+data["effectif_total"]+" élèves.";
                                   document.getElementById("id03").innerHTML ="Réussite en série S de "+ data["reussite_S"]+"% pour un effectif de "+data["effectif_S"]+" élèves.";
                                   document.getElementById("id04").innerHTML ="Réussite en série ES de "+ data["reussite_ES"]+"% pour un effectif de "+data["effectif_ES"]+" élèves.";
                                   document.getElementById("id05").innerHTML ="Réussite en série L de "+ data["reussite_L"]+"% pour un effectif de "+data["effectif_L"]+" élèves.";
                                   
                                    }
                                }
// "effectif_L",
//              "effectif_ES",
//              "effectif_S",
//              "effectif_STG",
//              "effectif_STI",
//              "effectif_STL",
//              "effectif_ST2S",
//              "effectif_total",
//              "reussite_L",
//              "reussite_ES",
//              "reussite_S",
//              "reussite_STG",
//              "reussite_STI",
//              "reussite_STL",
//              "reussite_ST2S",
//              "reussite_total"
                                // document.getElementById("id01").innerHTML = "hello "+return_json["effectif_S"]+" toto";
                              }
                    );
            
            
        })
    });


}



                

        $.getJSON("php/bd.php",    // le fichier qui recevera la requête
                              {},  // les paramètres en entrée 6.0003 45.9994
                              function(return_json){  // la fonction qui traitera l'objet reçu
                               

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