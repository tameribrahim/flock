// Google Maps
{
    var map; var marker;
    var lat, lng, zoom;
    function initialize() {
        var myLatlng = new google.maps.LatLng(lat, lng);
        var myZoom = Number(zoom);

        var myOptions = {
            zoom: myZoom,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: map.getCenter(),
            draggable: false
        });
    }

    function loadMapScript(locale, lat, lng, zoom) {
        this.lat = lat;
        this.lng = lng;
        this.zoom = zoom;
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.google.com/maps/api/js?sensor=true&callback=initialize&language="+locale;
        document.body.appendChild(script);
    }
}
