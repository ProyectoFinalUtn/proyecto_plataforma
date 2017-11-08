
 var StandardContextItems = [
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
                callback: function (obj, map) {
                    buscaZonas();
                }
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



