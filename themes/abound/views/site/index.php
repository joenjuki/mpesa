<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl; 
?>
<style type="text/css">
#map{
	height: 800px;
	margin: 0px;
	padding: 0px
}

</style>

<div class="row-fluid">
  <div>
	<?php echo CHtml::dropDownList('carDropdown', '', $carsDropDownArray, array(
	'id' => 'carsDropDown',
	'data-placeholder' => 'Select Car'
	)); ?>
  </div>
  <div id="map">

  </div>
</div>
<script>
// var map;
// $(document).ready(function() {
  // Stuff to do as soon as the DOM is ready;
  // create a map in the "map" div, set the view to a given place and zoom
//drawMap = function() {

	var map = L.map('map').setView([0.0105, 37.0725], 13);

	// add an OpenStreetMap tile layer
	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	  attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
	  key: 'BC9A493B41014CAABB98F0471D759707'
	}).addTo(map);
// }
// drawMap();
//add a marker in the given location, attach some popup content to it and open the popup
// L.marker([0.0105, 37.0725]).addTo(map)
//   .bindPopup('A pretty CSS3 popup. <br> Easily customizable.');
  // .openPopup();

$('#carsDropDown').chosen();
$('#carsDropDown').on('change', function() {
	if (this.value != '') {
		console.log(this.value);
	  	$.ajax({
			type: 'POST',
			url: <?php echo "'" . CController::createUrl('site/getCarCoords') . "'"; ?>,
			data: {
			  phoneNumber: this.value
			},
			dataType: "json",
			success: function(data) {
				// console.log(data);
				if (data.marker != 'undefined') {
					// map.removeLayer(geoJsonLayer);
					var bounds = [];
					
					// map.remove();
					// drawMap();
					var geoJsonLayer = L.geoJson(null, {
						
						// pointToLayer: function (feature, latlng) {
						// 	//return L.circleMarker(latlng, geojsonMarkerOptions);
						// 	// return L.marker(latlng);
						// },
						// coordsToLatLngs(data.bounds, 0),
						onEachFeature: function (feature, layer) {
							console.log(feature.properties.popupContent);

							layer.bindPopup(feature.properties.popupContent);
							// bounds.push(feature.geometry.coordinates);
							// console.log(feature.geometry.coordinates);
							// bounds.push(feature.geometry.coordinates[0]);
						}
					}).addTo(map);
					// console.log(bounds);
					latLngBounds = L.latLngBounds(data.bounds);

					geoJsonLayer.addData(data.marker);
					var myStyle = {
					    "color": "#ff7800",
					    "weight": 5,
					    "opacity": 0.65
					};
					var myLines = [{
					    "type": "LineString",
					    "coordinates": data.lines
					}];
					L.geoJson(myLines, {
					    style: myStyle
					}).addTo(map);
					L.polylineDecorator(data.bounds, {
						patterns: [
						{offset: '25%', repeat: '50%', symbol: L.Symbol.arrowHead({pixelSize: 12, pathOptions: {fillOpacity: 1, weight: 0}})}
						]
					}).addTo(map);
					map.fitBounds(latLngBounds);
					//map.invalidateSize();

				}


			},
			error: function(data) {

			}
		  
	  });
	}
});
// });
</script>

