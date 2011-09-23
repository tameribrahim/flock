// Google Maps
{
    var map; var marker;
    var browserSupportFlag =  new Boolean();
    function initialize() {
        var myLatlng;
        var myZoom = 14;
        var skipGeolocation = false;
        if ('' != $('#flock_lat').val() && '' != $('#flock_lng').val() && '' != $('#flock_zoom').val()) {
            myLatlng = new google.maps.LatLng($('#flock_lat').val(), $('#flock_lng').val());
            myZoom = Number($('#flock_zoom').val());
            skipGeolocation = true;
        } else {
            myLatlng = new google.maps.LatLng(35.685708, 139.702148);
        }

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
        });
        updateLatLngZoom();

        google.maps.event.addListener(marker, 'dragend', setPosition);
        google.maps.event.addListener(map, 'click', moveMarker);
        google.maps.event.addListener(map, 'zoom_changed', updateLatLngZoom);

        marker.setAnimation(google.maps.Animation.DROP);

        if (skipGeolocation) {
            return true;
        }

        if(navigator.geolocation) {
            browserSupportFlag = true;
            navigator.geolocation.getCurrentPosition(function(position) {
                initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                map.setCenter(initialLocation);
                marker.setPosition(map.getCenter());
                updateLatLngZoom();
            }, function() {
                handleNoGeolocation(browserSupportFlag);
            });
        } else if (google.gears) {
                // Try Google Gears Geolocation
                browserSupportFlag = true;
                var geo = google.gears.factory.create('beta.geolocation');
                geo.getCurrentPosition(function(position) {
                initialLocation = new google.maps.LatLng(position.latitude,position.longitude);
                contentString = "Location found using Google Gears";
                map.setCenter(initialLocation);
                marker.setPosition(map.getCenter());
                updateLatLngZoom();
            }, function() {
              handleNoGeolocation(browserSupportFlag);
            });
        } else {
            // Browser doesn't support Geolocation
            browserSupportFlag = false;
            handleNoGeolocation(browserSupportFlag);
        }
    }

    function handleNoGeolocation(errorFlag) {
        if (errorFlag == true) {
          alert("Geolocation service failed. We've placed you in Tokyo. Find your way through");
          initialLocation = new google.maps.LatLng(35.68138, 139.76608);
        } else {
          alert("Your browser doesn't support geolocation. We've placed you in Tokyo. Find your way through");
          initialLocation = new google.maps.LatLng(35.68138, 139.76608);
        }
        map.setCenter(initialLocation);
    }

    function updateLatLngZoom(){
        //set the lat lng and zoom property
        $('#flock_lat').val(marker.getPosition().lat());
        $('#flock_lng').val(marker.getPosition().lng());
        $('#flock_zoom').val(map.getZoom());
    }

    function setPosition() {
        map.setCenter(marker.getPosition());
        marker.setPosition(map.getCenter());
        updateLatLngZoom();
    }

    function moveMarker(){
        marker.setAnimation(google.maps.Animation.DROP);
        marker.setPosition(map.getCenter());
    }

    function loadMapScript(locale) {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.google.com/maps/api/js?sensor=true&callback=initialize&language="+locale;
        document.body.appendChild(script);
    }
}
