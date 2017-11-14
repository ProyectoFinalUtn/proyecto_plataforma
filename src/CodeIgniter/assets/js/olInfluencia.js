// Code goes here
var map;
var contextmenu;
var centroXY;
var poligonXY;
var capas_influencia = [];
var StandardContextItems = [];

function setStandardContextItems () {

    $.ajax({
        type: 'POST',
        username: "admin",
        password: "1234",
        url: 'Consulta_zonas/buscar_nombres_capas',      
        success: function(response) { 
            capas_influencia = [];
            response = response.response;
            var arrayLength = response.length;
            for (var i = 0; i < arrayLength; i++) {            
              capas_influencia.push(response[i].nombre_capa);
              console.log(capas_influencia);              
            }
        },          
        async:false
    });
    capas = capas_influencia.length;
    items = [];
    menuFt = {text:'Todas',                
              callback: function (obj, map) {
              buscaZonas();
             }
    };
    items.push(menuFt);    
    if ( capas > 0 ){
        items.push('-');            
        for (var i = 0; i < capas; i++) {
            //menuFt = JSON.parse("{text:'"+capas_influencia[i]+"',classname: 'some-style-class'}");
            var func = new Function("console.log('"+capas_influencia[i]+"');");
            //var funcCode = eval("console.log('TEXTO TEST');");
            menuFt = {text: capas_influencia[i],callback: func };            
            //menuFt = "{text:"+capas_influencia[i]+",callback: function ("+capas_influencia[i]+") {console.log("+capas_influencia[i]+");}}";
            items.push(menuFt);    
        }        
    }
    StandardContextItems = [
          {
              text: 'Centrar el mapa aquí',
              classname: 'some-style-class', // add some CSS rules,
              callback: center
          },
          '-', // this is a separator,
          {
            text: 'Mostrar Zonas',
            classname: 'some-style-class', // you can add this icon with a CSS class
            // instead of `icon` property (see next line)
            items : items
           },
          '-',
          {
                text: 'Limpiar',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
                
                callback: function (obj, map) {
                    clearDraw();
                }
          },
    ];
}

var source = new ol.source.Vector({
    wrapX: false
});
var view = new ol.View({
    center: ol.proj.transform([-58.39, -34.63], 'EPSG:4326', 'EPSG:3857'),
    zoom: 10
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
    style: (function() {
        var textStroke = new ol.style.Stroke({
            color: '#fff',
            width: 3
        });
        var textFill = new ol.style.Fill({
            color: '#000'
        });
        return function(feature, resolution) {
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
                    source: new ol.source.XYZ({
                        urls: ["https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png"]
                    })
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
    controls: ol.control.defaults({
        attribution: false
    }).extend([attribution]),
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
map.getViewport().addEventListener('contextmenu', function(e) {
    e.preventDefault();
    var offset = $(this).offset();
    var mapX = e.x - offset.left;
    var mapY = e.y - offset.top;
    var clkfeatures = [];
    var feature;
    setStandardContextItems();
    map.forEachFeatureAtPixel([mapX, mapY], function(ft, layer) {
        if (typeof ft.get('ModelName') !== 'undefined') {
            ModelName = ft.get('ModelName');
            feature = ft;
            if (!contains.call(clkfeatures, ft)) {
                clkfeatures.push(ft);
            }
        }
    });
    console.log('length : ' + clkfeatures.length);
    var FeatureContextMenu = [{
            text: 'Eliminar Capa',
            callback: function(obj, map) {
                handleFeatureContexMenuEvent2('EliminarCapa', feature, ModelName, mapX, mapY);
            }
    }];
    var SelectorContextMenu = [];
    if (clkfeatures.length > 1) {
        contextmenu.clear();        
        var arrayLength = clkfeatures.length;
        for (var i = 0; i < arrayLength; i++) {            
            for (var j = 0; j < SelectorContextMenu.length; j++){
                 // look for the entry with a matching `code` value
                if (SelectorContextMenu[j].text != clkfeatures[i].get('ModelName')){
                    menuFt = {text:clkfeatures[i].get('ModelName'),
                      items: FeatureContextMenu
                    };
                    SelectorContextMenu.push(menuFt);
                }
            }
        }
        contextmenu.extend(SelectorContextMenu);
    } else if (clkfeatures.length == 1) {
        contextmenu.clear();        
        contextmenu.extend(FeatureContextMenu);
    } else {
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
    countrycodes: 'ar' //solo busca de Argentina
});
map.addControl(geocoder);
//Listen when an address is chosen
geocoder.on('addresschosen', function(evt) {
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
function buscaZonas(value) {
    source.clear();
    $.ajax({
        type: 'POST',
        username: "admin",
        password: "1234",
        url: 'Consulta_zonas/buscar_zonas_influencia',
        success: function(response) {
            cargaZonas(response);
        }
    });    
}

function cargaZonas(data) {    
    var arrayLength = data.response.length;
    var format = new ol.format.GeoJSON();
    for (var i = 0; i < arrayLength; i++) {
        //data.response[i]; //un json con geometria y propiedades
        ft = "{\"type\":\"Feature\",\"geometry\":" + data.response[i].geometria + ",\"properties\":" + data.response[i].propiedades + "}";
        ft = format.readFeature(ft);
        ft.setProperties({
         'Display': data.response[i].nombre_capa,
         'ModelName': data.response[i].nombre_capa
        });        
        source.addFeature(ft);
        //Do something
    }

}

function getAreaLabel(feature) {
    if (typeof feature.get('ModelName') !== 'undefined') {
        var title = feature.get('Display');
        return title;
    }
}

function handleFeatureContexMenuEvent2(option, feature, ModelName, x, y) {
    contextmenu.clear();
    if (option == 'EliminarCapa') {
        eliminarCapa(feature);
    }
}

function eliminarCapa(ft) {
	bootbox.setDefaults({ backdrop: false });
    bootbox.confirm("Desea eliminar todas las zonas de la capa '" + ft.get('Display') + "' ?", function(result) {
        if (result) {            
            var capa = {
                nombre_capa: ft.get('Display')
            };
            capa = JSON.stringify(capa);
            $.ajax({
                type: 'POST',
                data: 'data=' + capa,
                url: 'zonas_influencia/eliminar_zona_influencia'
            });            
            clearDraw();
            buscaZonas();        
        }

    })
}


function clearDraw() {    
    if (source) {
        source.clear();
    }
}

function center(obj) {
  view.animate({
    duration: 700,    
    center: obj.coordinate
  });
}