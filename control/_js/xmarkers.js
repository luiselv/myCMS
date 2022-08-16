// Special thanks to http://blog.sofasurfer.org/2011/06/27/dynamic-google-map-markers-via-simple-json-file/ for the post
// variable for geocoder location
var mygc = new google.maps.Geocoder();
//variable for map
var map;
//variable for marker info window
var infowindow = new google.maps.InfoWindow();
// List with all marker to check if exist
var markerList = {};
function initialize(lat, lng, defaultZoom, jsonData) {
	lat = lat || 25.7889689; // Miami
	lng = lng || -80.2264393;
	defaultZoom = defaultZoom || 12;
    var myLatlng = new google.maps.LatLng(lat,lng);
	var mapOptions = {
		zoom : defaultZoom||zoom,
		center : myLatlng,
		mapTypeId : google.maps.MapTypeId.HYBRID,
		zoomControlOptions: {
		    style: google.maps.ZoomControlStyle.LARGE,
	    }
	};
	map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
	/*google.maps.event.addListener(map, 'zoom_changed', function() {
		document.getElementById('zoom').value = map.getZoom();
	});*/
	loadMakers(jsonData);	
}

function loadMakers(jsonData){
	jQuery(document).ready(function(){
    	// load marker jSon data
		for (var i in jsonData.markers) {
			//console.info(jsonData.markers[i]['id']);
			jQuery('#markerbox').html( i );
			loadMaker(jsonData.markers[i],jsonData.markers[i]['lat'],jsonData.markers[i]['lng']);
		}
	});
}

/**
 * Load marker to map
 */
function loadMaker(markerData, markerLat, markerLng){
	// create new marker location
	var myLatlng = new google.maps.LatLng(markerLat, markerLng);
	// create new marker
	var marker = new google.maps.Marker({
	    id: markerData['id'],
	    map: map,
	    title: markerData['title'],
	    position: myLatlng,
	    description: markerData['description'],
	    picture: markerData['picture'],
	    //newvar: markerData['newvar_content'],...
	});
	marker.setIcon(markerData['icon']);
	// add marker to list used later to get content and additional marker information
	markerList[marker.id] = marker;
	// add event listener when marker is clicked
	// currently the marker data contain a dataurl field this can of course be done different
	google.maps.event.addListener(marker, 'click', function() {
		// show marker when clicked
		showMarker(marker.id);
	});
	// add event when marker window is closed to reset map location
	google.maps.event.addListener(infowindow,'closeclick', function() {});
}

function showMarker(markerId) {
	// get marker information from marker list
	var marker = markerList[markerId];
	// check if marker was found
	if( marker ){
		// get marker detail information from server
		var content = "<h2>"+marker.title+"</h2>";
		content += "<p>"+marker.description+"</p>";
		if(marker.picture){
			content += "<p><img src='thumb.php?src=upload/"+marker.picture+"&w=133&h=115&full=1&q=100'></p>";
		}
		content += "<p><a href='projects-gallery.php'>View projects</a></p>";
		infowindow.setContent(content);
		infowindow.open(map,marker);
	}else{
		alert('Error marker not found: ' + markerId);
	}
}
