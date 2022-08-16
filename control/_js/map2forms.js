function loadGMap(lat, lng) {
	//var myLatlng = new google.maps.LatLng(-8.111830376461585, -79.0286901204833);
	//latitud = typeof(lat) != 'undefined' ? lat : -8.111830376461585;
	//longitud = typeof(lng) != 'undefined' ? lat : -79.0286901204833;
	lat = lat || 25.7889689; // Miami
	lng = lng || -80.2264393;
	
	var myLatlng = new google.maps.LatLng(lat, lng);
	var myOptions = {
		zoom : 12,
		center : myLatlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	var marker = new google.maps.Marker({
		position : myLatlng,
		map : map,
		draggable : true
	});
	
	google.maps.event.addListener(marker, 'drag', function() {
		(function($){
			jQuery('#lat_en').val( marker.position.lat() );
			jQuery('#lng_en').val( marker.position.lng() );
		})(jQuery);
	});
}

