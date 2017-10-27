
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
            },
            ]

        },
        {
            text: 'Mostrar Zonas',
            classname: 'some-style-class', // you can add this icon with a CSS class
            // instead of `icon` property (see next line)
            items: [{
                text: 'Activas',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
               
                callback: function (obj, map) {
                    buscaZonas('ACTIVAS');
                }
            }, {
                text: 'Futuras',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
                
                callback: function (obj, map) {
                    buscaZonas('FUTURAS');
                }
            }, {
                text: 'Todas',
                classname: 'some-style-class', // you can add this icon with a CSS class
                // instead of `icon` property (see next line)
                                
                callback: function (obj, map) {
                    buscaZonas('TODAS');
                }
            },
            ]

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



