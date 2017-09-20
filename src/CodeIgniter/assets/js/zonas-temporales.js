$(document).ready(function() {

 var view = new ol.View({ center: [0, 0], zoom: 4 }),
    vectorLayer = new ol.layer.Vector({ source: new ol.source.Vector() }),
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
    text: 'Some Actions',
    icon: 'assets/img/view_list.png',
    items: [
      {
        text: 'Center map here',
        icon: 'assets/img/center.png',
        callback: center
      },
      {
        text: 'Add a Marker',
        icon: 'assets/img/pin_drop.png',
        callback: marker
      }
    ]
  },
  {
    text: 'Add a Marker',
    icon: 'assets/img/pin_drop.png',
    callback: marker
  },
  '-' // this is a separator
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

map.on("pointermove", function (evt) {
    var hit = this.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
        return true;
    }); 
    if (hit) {
        this.getTargetElement().style.cursor = 'pointer';
    } else {
        this.getTargetElement().style.cursor = '';
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
        coordinateFormat: ol.coordinate.createStringXY(4),
        projection: 'EPSG:4326',        
        undefinedHTML: '&nbsp;'
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
  countrycodes: 'ar'
});
map.addControl(geocoder);
  
//Listen when an address is chosen
geocoder.on('addresschosen', function(evt){
  var feature = evt.feature,
      coord = evt.coordinate;
  overlay.setPosition(coord);
});

var contextmenu = new ContextMenu({
  width: 170,
  defaultItems: true, // defaultItems are (for now) Zoom In/Zoom Out
  items: [
    {
      text: 'Center map here',
      classname: 'some-style-class', // add some CSS rules
      callback: center // `center` is your callback function
    },
    {
      text: 'Add a Marker',
      classname: 'some-style-class', // you can add this icon with a CSS class
                                     // instead of `icon` property (see next line)
      icon: 'assets/img/marker.png',  // this can be relative or absolute
      callback: marker
    },
    '-' // this is a separator
  ]
});
map.addControl(contextmenu);

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

});
