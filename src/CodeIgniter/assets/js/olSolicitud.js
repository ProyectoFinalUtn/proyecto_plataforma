// Code goes here
var lati = parseFloat(readCookie('sol_latitud'));
var longi = parseFloat(readCookie('sol_longitud'));
var map;
var contextmenu;
var source = new ol.source.Vector({ wrapX: false });
var view = new ol.View({
    center: ol.proj.transform([longi, lati], 'EPSG:4326', 'EPSG:3857'),
    zoom: 15
});


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
                      {
                        urls : ["https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png"]
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


var mousePositionControl = new ol.control.MousePosition({
        coordinateFormat: ol.coordinate.createStringXY(2),
        projection: 'EPSG:4326',        
        undefinedHTML: '&nbsp;'
});
map.addControl(mousePositionControl);

function getLongLatFromPoint(loc) {
    return ol.proj.transform(loc, 'EPSG:3857', 'EPSG:4326')
}

function getAreaLabel(feature) {
    if(typeof feature.get('ModelName') !== 'undefined') {
        var title = feature.get('Display');
        return title;
  }
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

