//$(document).ready(function() {

var vectorLayer = new ol.layer.Vector({ source: new ol.source.Vector() });


var view = new ol.View({ center: [0, 0], zoom: 4 }),
    baseLayer = new ol.layer.Tile({ source: new ol.source.OSM() }),
    map = new ol.Map({
      target: 'mapZonas',
      view: view,
      layers: [baseLayer, vectorLayer]
});

var contextmenu_items = [
  {
    text: 'Center map here',
    classname: 'bold',
    icon: 'assets/img/center.png',
    callback: center
  },
  {
    text: 'Crear Area',
    icon: 'assets/img/view_list.png',
    items: [
      {
        text: 'Definir punto',
        icon: 'assets/img/center.png',
        callback: drawPoint
      },
      {
        text: 'Definir poligono',
        icon: 'assets/img/pin_drop.png',
        callback: drawPlygon
      }
    ]
  },
  {
    text: 'Add a Marker',
    icon: 'assets/img/pin_drop.png',
    callback: marker
  },
  '-' // this is a separator
  {
            text: 'Draw',
            classname: 'some-style-class', // you can add this icon with a CSS class
            // instead of `icon` property (see next line)
            items: [{
                text: 'None',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
           
                callback: function (obj, map) {
                    addInteraction('None');
                }
            }, {
                text: 'Point',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
                callback: function (obj, map) {
                    addInteraction('Point');
                }
            }, {
                text: 'LineString',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
              
                callback: function (obj, map) {
                    addInteraction('LineString');
                }
            }, {
                text: 'Polygon',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
               
                callback: function (obj, map) {
                    addInteraction('Polygon');
                }
            }, {
                text: 'Circle',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
                
                callback: function (obj, map) {
                    addInteraction('Circle');
                }
            }, {
                text: 'Square',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
              
                callback: function (obj, map) {
                    addInteraction('Square');
                }
            }, {
                text: 'Box',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
               
                callback: function (obj, map) {
                    addInteraction('Box');
                }
            }, {
                text: 'Clean',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
                
                callback: function (obj, map) {
                    clearDraw();
                }
            },
];

var contextmenu = new ContextMenu({
  width: 180,
  items: contextmenu_items
});
map.addControl(contextmenu);


var removeMarkerItem = {
  text: 'Remove this Marker',
  classname: 'marker',
  callback: removeMarker
};

contextmenu.on('open', function(evt){
  var feature = map.forEachFeatureAtPixel(evt.pixel, function(ft, l){
    return ft;
  });
  if (feature && feature.get('type') == 'removable') {
    contextmenu.clear();
    removeMarkerItem.data = {
      marker: feature
    };
    contextmenu.push(removeMarkerItem);
  } else {
    contextmenu.clear();
    contextmenu.extend(contextmenu_items);
    contextmenu.extend(contextmenu.getDefaultItems());
  }
});



// from https://github.com/DmitryBaranovskiy/raphael
function elastic(t) {
  return Math.pow(2, -10 * t) * Math.sin((t - 0.075) * (2 * Math.PI) / 0.3) + 1;
}

function center(obj) {
  view.animate({
    duration: 700,
    easing: elastic,
    center: obj.coordinate
  });
}

function removeMarker(obj) {
  vectorLayer.getSource().removeFeature(obj.data.marker);
}


function marker(obj) {
  var coord4326 = ol.proj.transform(obj.coordinate, 'EPSG:3857', 'EPSG:4326'),
      template = 'Coordinate is ({x} | {y})',
      iconStyle = new ol.style.Style({
        image: new ol.style.Icon({ scale: .6, src: 'img/pin_drop.png' }),
        text: new ol.style.Text({
          offsetY: 25,
          text: ol.coordinate.format(coord4326, template, 2),
          font: '15px Open Sans,sans-serif',
          fill: new ol.style.Fill({ color: '#111' }),
          stroke: new ol.style.Stroke({ color: '#eee', width: 2 })
        })
      }),
      feature = new ol.Feature({
        type: 'removable',
        geometry: new ol.geom.Point(obj.coordinate)
      });

  feature.setStyle(iconStyle);
  vectorLayer.getSource().addFeature(feature);
}

var mousePositionControl = new ol.control.MousePosition({
        coordinateFormat: ol.coordinate.createStringXY(2),
        projection: 'EPSG:4326',        
        undefinedHTML: '&nbsp;'
});
map.addControl(mousePositionControl);

var draw; // global so we can remove it later

function drawPlygon() {
        draw = new ol.interaction.Draw({
          source: vectorLayer,
          type: 'Polygon'
        });
        map.addInteraction(draw);
}

function drawPoint() {
        draw = new ol.interaction.Draw({
          source: vectorLayer,
          type: 'Point'
        });
        map.addInteraction(draw);
}
  
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
  countrycodes: 'ar'
});
map.addControl(geocoder);
  
//Listen when an address is chosen
geocoder.on('addresschosen', function(evt){
  var feature = evt.feature,
      coord = evt.coordinate;
  overlay.setPosition(coord);
});

// from https://github.com/DmitryBaranovskiy/raphael
function elastic(t) {
  return Math.pow(2, -10 * t) * Math.sin((t - 0.075) * (2 * Math.PI) / 0.3) + 1;
}

function center(obj) {
  view.animate({
    duration: 700,
    easing: elastic,
    center: obj.coordinate
  });
}

function removeMarker(obj) {
  vectorLayer.getSource().removeFeature(obj.data.marker);
}

function marker(obj) {
  var coord4326 = ol.proj.transform(obj.coordinate, 'EPSG:3857', 'EPSG:4326'),
      template = 'Coordinate is ({x} | {y})',
      iconStyle = new ol.style.Style({
        image: new ol.style.Icon({ scale: .6, src: 'assets/img/pin_drop.png' }),
        text: new ol.style.Text({
          offsetY: 25,
          text: ol.coordinate.format(coord4326, template, 2),
          font: '15px Open Sans,sans-serif',
          fill: new ol.style.Fill({ color: '#111' }),
          stroke: new ol.style.Stroke({ color: '#eee', width: 2 })
        })
      }),
      feature = new ol.Feature({
        type: 'removable',
        geometry: new ol.geom.Point(obj.coordinate)
      });

  feature.setStyle(iconStyle);
  vectorLayer.getSource().addFeature(feature);
}

//});
