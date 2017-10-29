// Ubicar en un mapa los datos de la solicitud
$(document).ready(function() {
var radio_solicitud = parseInt($("input[id='radio']").val());
var lati = parseFloat(readCookie('sol_latitud'));
var longi = parseFloat(readCookie('sol_longitud'));

// Seteo el zoom segun el radio de la solicitud
if (radio_solicitud <= 100) {
	var zoomDinamico = 18;
}
else {
	if (radio_solicitud <= 300) {
		var zoomDinamico = 17;
	}
	else {
		if (radio_solicitud <= 600) {
			var zoomDinamico = 16;
		}
		else {
			if (radio_solicitud <= 1100) {
				var zoomDinamico = 15;
			}
			else {
				var zoomDinamico = 14;
			}
		}		
	}
}

var map;
var contextmenu;
var source = new ol.source.Vector({ wrapX: false });
var view = new ol.View({
    center: ol.proj.transform([longi, lati], 'EPSG:4326', 'EPSG:3857'),
    zoom: zoomDinamico
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

// Crear el mapa
map = new ol.Map({
	layers: [
		new ol.layer.Group({
			'title': 'Base maps',
			layers: [
				  new ol.layer.Tile({
				  title: 'Wikimedia',
				  type: 'base',
				  visible: true,
				  source: new ol.source.XYZ(
				  {
					urls : ["https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png"]
				  })                      
				})
			]
		})              
	],
	controls: ol.control.defaults({ attribution: false }).extend([attribution]),
	target: 'mapa-solicitud',
	view: view
});
map.addLayer(vector);

// Defino el layer del circulo del radio de la solicitud
var vista = map.getView();
var proyeccion = vista.getProjection();
var resolutionAtEquator = vista.getResolution();
var centroMapa = map.getView().getCenter();
var radio = (radio_solicitud / ol.proj.METERS_PER_UNIT.m);
var circle = new ol.geom.Circle(centroMapa, radio);
var circleFeature = new ol.Feature(circle);
var fuenteVectorRadio = new ol.source.Vector({
projection: 'EPSG:4326'
});
fuenteVectorRadio.addFeature(circleFeature);
var capaRadio = new ol.layer.Vector({
source: fuenteVectorRadio
});

map.addLayer(capaRadio);

// Defino el layer del icono marker donde se hizo la solicitud
var iconFeature = new ol.Feature({
  geometry: new ol.geom.Point(map.getView().getCenter()),
  name: 'Ubicacion solicitada'
});

var iconStyle = new ol.style.Style({
  image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
    anchor: [0.5, 46],
    anchorXUnits: 'fraction',
    anchorYUnits: 'pixels',
    opacity: 1,
    src: 'assets/img/marker.png'
  }))
});

iconFeature.setStyle(iconStyle);

var fuenteVector = new ol.source.Vector({
  features: [iconFeature]
});

var capaIcono = new ol.layer.Vector({
  source: fuenteVector
});
map.addLayer(capaIcono);

var mousePositionControl = new ol.control.MousePosition({
        coordinateFormat: ol.coordinate.createStringXY(2),
        projection: 'EPSG:4326',        
        undefinedHTML: '&nbsp;'
});
map.addControl(mousePositionControl);

});

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

