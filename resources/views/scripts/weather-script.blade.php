<script type="text/javascript">
    var centerLng = 0.00;
    var centerLat = 0.00;
    let markers = [];
    let map;

    $(document).ready(function(){
        getForecast();
    });

    function getForecast(){
        var city = $("#txtCity").val();

        // Ajax call to retrieve and display weather details
        $.ajax({
            url: "{{route('WeatherController.getForecast')}}",
            method: "GET",
            data: {city:city},
            dataType: "json",
            success: function(data){
                if(data){
                    $("#forecastTile").html("");
                    $("#lblCity").html($("#txtCity").val().toUpperCase() + ' <span style="font-size:14px"><?php echo date('F j, Y '); ?></span>');

                    // Displaying of weather details to UI
                    data.forEach(function(item,i){
                        if(i==0){
                            $("#forecastTile").append('<div class="col-md-4">'+
                                '<div class="dashboard-stat blue">'+
                                    '<div class="details" style="text-align:center">'+
                                        '<div class="forecast-icon">'+
                                            '<img src="http://openweathermap.org/img/wn/'+item['icon']+'" alt="Clouds" width="90">'+
                                        '</div>'+
                                        '<div class="desc" ><strong>'+item['dt_txt']+'</strong></div>'+
                                        '<div class="desc" >'+capitalizeFirstLetter(item['description'])+'</div>'+
                                        '<div class="degree">'+
                                            '<div class="num desc">'+
                                                ''+Math.round(item['temp_max'])+'<sup>o</sup>C'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>');
                        }
                        else{
                            $("#forecastTile").append('<div class="col-md-2">'+
                                '<div class="dashboard-stat blue">'+
                                    '<div class="details" style="text-align:center">'+
                                        '<div class="forecast-icon">'+
                                            '<img src="http://openweathermap.org/img/wn/'+item['icon']+'" alt="Clouds" width="90">'+
                                        '</div>'+
                                        '<div class="desc" >'+item['dt_txt']+'</div>'+
                                        '<div class="desc" >'+capitalizeFirstLetter(item['description'])+'</div>'+
                                        '<div class="degree">'+
                                            '<div class="num desc">'+
                                                ''+Math.round(item['temp_max'])+'<sup>o</sup>C'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>');
                        }
                    });

                    // Instantiation and Recentering of Google map
                    centerLng = data[0]['lng'];
                    centerLat = data[0]['lat'];
                    loc = { lat: centerLat, lng: centerLng };
                    map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 14,
                        center: loc,
                    });
                }
                else{
                    toastr.error("City does not exist.");
                    return;
                }

                getPlaces(city,centerLng,centerLat);
            }
        });
    }

    function getPlaces(city,lng,lat){
        // Ajax call to retrieve and display nearby places details
        $.ajax({
            url: "{{route('WeatherController.getPlaces')}}",
            method: "GET",
            data: {city:city,lng:lng,lat:lat},
            dataType: "json",
            success: function(data){
                $("#ulPlaces").html("");

                // Resetting of Google maps markers
                setMapOnAll(null);
                deleteMarkers();

                // Displaying of nearby places to UI
                data.forEach(function(item,i){
                    $("#ulPlaces").append("<li class='list-group-item'><strong>"+item['name']+"</strong> | "+item['locality']+" | "+item['address']+"</li>");
                    addMarker({lat:item['lat'],lng:item['lng']});
                });
            }
        });
    }

    // Initial instantiation of Google map
    function initMap(){
        loc = { lat: centerLat, lng: centerLng };
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: loc,
        });

        addMarker(loc);
    }

    // Google map marker related functions
    function addMarker(position) {
        const marker = new google.maps.Marker({
            position,
            map,
        });

        markers.push(marker);
        showMarkers();
    }

    function setMapOnAll(map) {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    function hideMarkers() {
        setMapOnAll(null);
    }

    function showMarkers() {
        setMapOnAll(map);
    }

    function deleteMarkers() {
        hideMarkers();
        markers = [];
    }
    // End Google map marker related functions

    function capitalizeFirstLetter(str) {
        return str[0].toUpperCase() + str.slice(1);
    }
</script>