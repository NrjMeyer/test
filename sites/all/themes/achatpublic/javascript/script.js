$(document).ready(function(){
	var height_bloc_right = $("#right").height();
	var height_bloc_left = $("#left").height();
	
	if(height_bloc_left < height_bloc_right){
		var left_centre = $("#left_centre").height() + (height_bloc_right - height_bloc_left);
		$("#left_centre").css({'height' : left_centre+'px'});
	}
});

		
		
// Call this function when the page has been loaded
function initialize() {
	map = new google.maps.Map2(document.getElementById("map_gmap"),{ size: new GSize(675,500) } );
	gdir = new google.maps.Directions(map, document.getElementById("map_directions_content"));
	geocoder = new google.maps.ClientGeocoder();
	
	var myIcon = new google.maps.Icon();
	myIcon.image = "/sites/all/themes/achatpublic/images/picto_gmap.png";
	myIcon.iconSize = new google.maps.Size(20, 20);
	myIcon.iconAnchor = new google.maps.Point(10, 20);
	myIcon.infoWindowAnchor = new google.maps.Point(10, 1);
	markerOptions = {
		icon: myIcon
	};
	
	var myAddress = "2-6 place du Général De Gaulle, 92160 Antony";
	var infoLieu = "<img src='/sites/all/themes/achatpublic/images/achat_public_logo_gmap.png' />";
	geocoder.getLatLng(
		myAddress,
		function(point) {
			if (!point) {
				map.setCenter(new google.maps.LatLng(48.7632472, 2.309126900000024), 13);
			} else {
				map.setCenter(point, 16);
				var marker = new google.maps.Marker(point, markerOptions);
				map.addOverlay(marker);
				marker.openInfoWindowHtml(infoLieu + "<br />" + myAddress);
				google.maps.Event.addListener(marker, 'click', function() {
					marker.openInfoWindowHtml(infoLieu + "<br />" + myAddress);
				});
			}
		}
	);

	map.addControl(new GLargeMapControl3D());
	map.addControl(new GMapTypeControl());
}
