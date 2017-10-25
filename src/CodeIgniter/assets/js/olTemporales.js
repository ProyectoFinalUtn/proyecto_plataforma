// Code goes here
var map;
var contextmenu;
var centroXY; 
var poligonXY;
var source = new ol.source.Vector({ wrapX: false });
var view = new ol.View({
    center: ol.proj.transform([-58.39, -34.63], 'EPSG:4326', 'EPSG:3857'),
    zoom: 10
});

/**
* Currently drawn feature.
* @type {ol.Feature}
*/
var sketch;

/**
* The measure tooltip element.
* @type {Element}
*/
var measureTooltipElement;


/**
* Overlay to show the measurement.
* @type {ol.Overlay}
*/
var measureTooltip;      


var attribution = new ol.control.Attribution({
      collapsible: false
});
// create a vector layer used for editing
  var stroke = new ol.style.Stroke({
                color: 'red'
            });
            var textStroke = new ol.style.Stroke({
                color: '#fff',
                width: 3
            });
            var textFill = new ol.style.Fill({
                color: '#000'
            });
  var vector = new ol.layer.Vector({
          name: 'my_vectorlayer',
          source: source,
          style: (function () {
            var textStroke = new ol.style.Stroke({
              color: '#fff',
              width: 3
            });
            var textFill = new ol.style.Fill({
              color: '#000'
            });
            return function (feature, resolution) {
                return [new ol.style.Style({
                  cursor: 'pointer',
                  text: new ol.style.Text({
                    font: '34px Calibri,sans-serif',
                    text: getAreaLabel(feature),
                    fill: textFill,
                    stroke: textStroke
                  }),
                  image: new ol.style.Circle({
                    radius: 7,
                    fill: new ol.style.Fill({
                      color: '#ff7733'
                    })
                  }),
                  fill: new ol.style.Fill({
                     color: 'rgba(255, 255, 255, 0.2)'
                  }),
                  stroke: new ol.style.Stroke({
                    color: '#ffcc33',
                    width: 2
                  })
                })];
            };
          })()
  });

  // Create a map
  map = new ol.Map({
        layers: [
            new ol.layer.Group({
                'title': 'Base maps',
                layers: [
                    new ol.layer.Group({
                        title: 'Water color',
                        type: 'base',
                        combine: true,
                        visible: false,
                        layers: [
                            new ol.layer.Tile({
                                source: new ol.source.Stamen({
                                    layer: 'watercolor'
                                })
                            }),
                            new ol.layer.Tile({
                                source: new ol.source.Stamen({
                                    layer: 'terrain-labels'
                                })
                            })
                        ]
                    }),
                    new ol.layer.Tile({
                        title: 'OSM',
                        type: 'base',
                        visible: true,
                        source: new ol.source.OSM()
                    }),
                      new ol.layer.Tile({
                        title: 'Wikimedia',
                        type: 'base',
                        visible: false,
                        source: new ol.source.XYZ(
                        {urls : ["https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png"]})
                      }),
                      new ol.layer.Tile({
                        title: 'ESRI world imagery',
                        type: 'base',                      
                        visible: false,
                        source: new ol.source.XYZ({
                        attributions: [
                        new ol.Attribution({
                        html: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
                        })
                        ],
                        url: 'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'
                        })
                      })
                      ]
            })              
        ],
        controls: ol.control.defaults({ attribution: false }).extend([attribution]),
        target: 'map',
        view: view
    });
    map.addLayer(vector);

    var layerSwitcher = new ol.control.LayerSwitcher({
       tipLabel: 'Leyenda' // Optional label for button
    });
    map.addControl(layerSwitcher);

   
  //create contextmenu
  contextmenu = new ContextMenu({
        width: 170,
        default_items: true, //default_items are (for now) Zoom In/Zoom Out
        items: StandardContextItems
  });

  map.addControl(contextmenu);
   
    
    map.getViewport().addEventListener('contextmenu', function (e) {
        e.preventDefault();
        var offset = $(this).offset();
        var mapX = e.x - offset.left;
        var mapY = e.y - offset.top;
        var clkfeatures = [];        
        var feature;
        map.forEachFeatureAtPixel([mapX, mapY], function (ft, layer) {
              if(typeof ft.get('ModelName') !== 'undefined'){
                ModelName = ft.get('ModelName');                                 
                feature = ft;
         if (!contains.call(clkfeatures, ft)){
          clkfeatures.push(ft);          
         }
            }
        });
        console.log('length : ' +clkfeatures.length);
        if (clkfeatures.length > 1) {
            contextmenu.clear();
            contextmenu.extend(SelectorContextMenu);
          
        } else if (clkfeatures.length == 1) {
            contextmenu.clear();             
            var FeatureContextMenu = [{
                text: 'View',
                callback: function (obj, map) {
               
                    handleFeatureContexMenuEvent2('view', feature, ModelName);
                }
            },
            {
                text: 'Edit',
                callback: function (obj, map) {
                    handleFeatureContexMenuEvent2('edit', feature, ModelName);
                }
            },
            {
                text: 'Guardar Area',
                callback: function (obj, map) {
                    handleFeatureContexMenuEvent2('GuardaArea', feature, ModelName, mapX, mapY);
                }
            }];
            contextmenu.extend(FeatureContextMenu);            
        }
        else {
            contextmenu.clear();
            contextmenu.extend(StandardContextItems);
        }
    });

//Instantiate with some options and add the Control
var geocoder = new Geocoder('nominatim', {
  provider: 'osm',
  lang: 'es',
  placeholder: 'Buscar ...',
  limit: 5,
  debug: true,
  autoComplete: true,
  keepOpen: true,
  preventDefault: false,
  countrycodes: 'ar' //x ahora solo busca de Argentina
});
map.addControl(geocoder);

//Listen when an address is chosen
geocoder.on('addresschosen', function(evt){
  var feature = evt.feature,
      coord = evt.coordinate;
  overlay.setPosition(coord);
});

var mousePositionControl = new ol.control.MousePosition({
        coordinateFormat: ol.coordinate.createStringXY(6),
        projection: 'EPSG:4326',        
        undefinedHTML: '&nbsp;'
});
map.addControl(mousePositionControl);
var draw; // global so we can remove it later
function addInteraction(value) {
    if (value)
        map.removeInteraction(draw);
    if (value !== 'None') {
        var geometryFunction;        
        
        if (value==='Circle'){
          geometryFunction = ol.interaction.Draw.createRegularPolygon(40);
        }        

        draw = new ol.interaction.Draw({
            source: source,
            type: /** @type {ol.geom.GeometryType} */ (value),
            geometryFunction: geometryFunction                         
        });        
        //if (value ==='Circle'){
          var listener;
          draw.on('drawstart',
              function(evt){
              // set sketch
              sketch = evt.feature;
              var geometry = sketch.getGeometry();              
              centroXY = geometry.getFirstCoordinate();              
              //centroXY = ol.proj.transform(centroXY,'EPSG:3857','EPSG:4326');
              createMeasureTooltip();              
              listener = sketch.getGeometry().on('change', function(evt) {
                var geom = evt.target;  
                var tooltipCoord = geom.getLastCoordinate();
                //var bordeCirculo = ol.proj.transform(tooltipCoord,'EPSG:3857','EPSG:4326');
                
                if (value ==='Polygon'){
                  polyCoord = geometry.getCoordinates()[0];
                  tooltipCoord = polyCoord[polyCoord.length-2];
                  centroXY = polyCoord[polyCoord.length-3];
                  console.log(centroXY);
                }
                var coordinates = [centroXY,tooltipCoord];                
                var output;
                output = formatLength( /** @type {ol.geom.LineString} */ (new ol.geom.LineString(coordinates)));                    
                measureTooltipElement.innerHTML = output;
                measureTooltip.setPosition(tooltipCoord);                
                });
              },this);
        //}  
        draw.on('drawend', function(event) {
          
          map.removeInteraction(draw);
          //if(value==='Circle'){
            //measureTooltipElement.className = 'tooltip tooltip-static';
            measureTooltip.setOffset([0, -7]);
            // unset sketch
            sketch = null;
            // unset tooltip so that a new one can be created
            measureTooltipElement = null;
            createMeasureTooltip();              
          //}       
          var title = prompt( "Please provide the Area Title:", "untitled" );            
          event.feature.setProperties({
            'ID': GetID(),
            'name': title,        
            'MapMarkerTitle': title,
            'Display': title,
            'ModelName': title,
            'MapAreaLabelText': title
          });
        });
        map.addInteraction(draw);
    }
}


function getAreaLabel(feature) {
    if(typeof feature.get('ModelName') !== 'undefined') {
        var title = feature.get('Display');
        return title;
  }
}


function handleFeatureContexMenuEvent2(option, feature, ModelName, x, y) {
    contextmenu.clear();    
    if (option == 'edit') {
       console.log('edit');
    } else if (option == 'view') {
         console.log('view');
    } else if (option == 'GuardaArea') {
        var format = new ol.format.GeoJSON();
        var geoJson = format.writeFeature(feature);
        var parsedGeoJson = JSON.parse(geoJson);
        var geometria = parsedGeoJson.geometry;
        geometria = JSON.stringify(geometria);        
        var propiedades = parsedGeoJson.properties;
        propiedades = JSON.stringify(propiedades);
        
        var zona = { id:feature.get('ID'), nombre:ModelName,detalle:'A IMPLEMENTAR',geometria: geometria , propiedades: propiedades};                      
        zona = JSON.stringify(zona);
        console.log(zona);
        $.ajax({
            type : 'POST',
            data : 'data=' + zona,
            url : 'zonas_temporales/guardar_zona_temporal'            
        });
    }
}
      /**
       * Format length output.
       * @param {ol.geom.LineString} line The line.
       * @return {string} The formatted length.
       */
      var formatLength = function(line) {
        var length = Math.round(line.getLength() * 100) / 100;
        var output;
        if (length > 100) {
          output = (Math.round(length / 1000 * 100) / 100) +
              ' ' + 'km';
        } else {
          output = (Math.round(length * 100) / 100) +
              ' ' + 'm';
        }
        return output;
      };      

      /**
       * Creates a new measure tooltip
       */
      function createMeasureTooltip() {
        if (measureTooltipElement) {
          measureTooltipElement.parentNode.removeChild(measureTooltipElement);
        }
        measureTooltipElement = document.createElement('div');
        measureTooltipElement.dataToggle = 'tooltip';
        //measureTooltipElement.className = 'tooltip tooltip-measure';
        measureTooltip = new ol.Overlay({
          element: measureTooltipElement,
          offset: [0, -15],         
          positioning: 'top-center',
          visible: true
        });
        map.addOverlay(measureTooltip);        
      }



