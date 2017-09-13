<style>
    #mapZonas { height: 580px;width: 580px;  }
</style>

<div id="map-container">
    <div id="mapZonas"></div>
</div>
<script>
    function cargarMapa(){
        var mymap = L.map('mapZonas').setView([-34.60, -58.38], 13);
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoiZmdndXRuIiwiYSI6ImNqNnJnaWlmZjA5aW8zM282ZjRsMTZ4dmUifQ.i50kwQl1oJTjZ_jVIqDtpA'
        }).addTo(mymap);
    }
    cargarMapa();
</script>
 
