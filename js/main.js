function get_loc() {
var output = document.getElementById("rooms-list");
if (!navigator.geoLocation) {
        output.innerHtml = "<p>Geolocation not supported by your browser!</p>";
}
else {
        function success(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
		window.alert(latitude);
                output.innerHTML = '<p>Lat: ' + latitude + '<br>Long: ' + longitude + '</p>';
        }
        function error() {
                output.innerHTML = "Unable to retrieve your location";
        }
        navigator.geolocation.getCurrentPosition(success, error);
}
}

