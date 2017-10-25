
 var StandardContextItems = [
          {
              text: 'Centrar el mapa aqui',
              classname: 'some-style-class', // add some CSS rules,
              callback: center
          },
          '-', // this is a separator,
        {
            text: 'Definir Zona',
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
                text: 'Poligono',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
               
                callback: function (obj, map) {
                    addInteraction('Polygon');
                }
            }, {
                text: 'Circulo con radio',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
                
                callback: function (obj, map) {
                    addInteraction('Circle');                    
                }
            }, {
                text: 'Limpiar',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
                
                callback: function (obj, map) {
                    clearDraw();
                }
            },
            ]

        },
        ];


 var SelectorContextMenu = [{
        text: 'FeatureA',
      
        callback: function (obj, map) {
            var ID = feature.get('ID');
            var ModelName = feature.get('ModelName')
            handleFeatureContexMenuEvent('view', ID, ModelName);
        }
    },
    {
        text: 'FeatureB',

        callback: function (obj, map) {
            var ID = feature.get('ID');
            var ModelName = feature.get('ModelName')
            handleFeatureContexMenuEvent('view', ID, ModelName);
        }
    },
    {
        text: 'FeatureC',
        callback: function (obj, map) {
            var ID = feature.get('ID');
            var ModelName = feature.get('ModelName')
            handleFeatureContexMenuEvent('view', ID, ModelName);
        }
    }];


function clearDraw() {
    map.removeInteraction(draw);
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



