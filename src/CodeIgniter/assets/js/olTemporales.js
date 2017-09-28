
// Code goes here
var map;
var contextmenu;
var source = new ol.source.Vector({ wrapX: false });
var view = new ol.View({
    center:  [11560106.846765194,148975.76812780878],
    zoom: 14
});

//window.addEventListener('load', function () {
//    map = initMap();
//});

//document.getElementById("map").addEventListener('load', function () {
//    map = initMap();
//});

//function initMap() {
	
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
              'title': 'Base map',
              layers: [
                   new ol.layer.Tile({
                       title: 'Base',
                       source: new ol.source.OSM(),
                   }),
                  vector
              ],
          })
        ],
        controls: ol.control.defaults({ attribution: false }).extend([attribution]),
        target: 'map',
        view: view
    });


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
        map.forEachFeatureAtPixel([mapX, mapY], function (ft, layer) {
              if(typeof ft.get('ModelName') !== 'undefined'){
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
            var ID = clkfeatures[0].get('ID');
            var ModelName = clkfeatures[0].get('OpenlayersMapType')
            var FeatureContextMenu = [{
                text: 'View',
                callback: function (obj, map) {
               
                    handleFeatureContexMenuEvent2('view', ID, ModelName);
                }
            },
            {
                text: 'Edit',
                callback: function (obj, map) {
                    handleFeatureContexMenuEvent2('edit', ID, ModelName);
                }
            },
            {
                text: 'Guardar Area',
                callback: function (obj, map) {
                    handleFeatureContexMenuEvent2('GuardaArea', ID, ModelName, mapX, mapY);
                }
            }];
            contextmenu.extend(FeatureContextMenu);
        }
        else {
            contextmenu.clear();
            contextmenu.extend(StandardContextItems);
        }
    });
//	return map;
//}
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
        coordinateFormat: ol.coordinate.createStringXY(2),
        projection: 'EPSG:4326',        
        undefinedHTML: '&nbsp;'
});
map.addControl(mousePositionControl);
var draw; // global so we can remove it later
function addInteraction(value) {
    if (value)
        map.removeInteraction(draw);
    if (value !== 'None') {
        var geometryFunction, maxPoints;
        if (value === 'Circle') {
        //TODO    
        } 
        draw = new ol.interaction.Draw({
            source: source,
            type: /** @type {ol.geom.GeometryType} */ (value),
            geometryFunction: geometryFunction,
            maxPoints: maxPoints
        });
        map.addInteraction(draw);
		
		draw.on('drawend', function(event) {
            map.removeInteraction(draw);
       
            var title = prompt( "Please provide the Area Title:", "untitled" );
            
			event.feature.setProperties({
				'id': title + GetID(),
				'name': title,
				'MapMarkerTitle': title,
				'Display': title,
				'ModelName': title,
				'MapAreaLabelText': title
			  });
        });
    }
}

function getLongLatFromPoint(loc) {
    return ol.proj.transform(loc, 'EPSG:3857', 'EPSG:4326')
}

function getAreaLabel(feature) {
    if(typeof feature.get('ModelName') !== 'undefined') {
        var title = feature.get('Display');
        return title;
	}
}
	

function handleFeatureContexMenuEvent2(option, ID, ModelName, x, y) {
    contextmenu.clear();
    if (option == 'edit') {
       console.log('edit');
    } else if (option == 'view') {
         console.log('view');
    } else if (option == 'GuardaArea') {
        var allFeatures = vector.getSource().getFeatures();
        var format = new ol.format.GeoJSON();
        var routeFeatures = format.writeFeatures(allFeatures);
        console.log(routeFeatures);        
    }
}
