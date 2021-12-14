@extends('layouts.app')

@section('content')
<br />  
<div class="container">
    <div class="input-group">
        <input type="text" class="form-control" id="txtCity" name="txtCity" placeholder="City" value="Tokyo">
        <button class="btn btn-outline-secondary" type="button" onclick="getForecast()"><i class="fa fa-search"></i></button>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-12" > 
        <div class="dashboard-stat dark" style="margin-bottom: 5px;">
            <h2><span class="badge badge-dark" id="lblCity" style="float:left;">TOKYO </span></h2>
            <h2><span class="badge badge-dark" style="float:right; padding-top:0px">5 DAY WEATHER FORECAST</span></h2>
        </div>
    </div>
</div>

<div id="forecastTile" class="row">
</div>

<div class="row">
    <div class="col-md-6">
        <h3 id="lblPlaces">Common Destinations</h3>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <ul class="list-group list-group-flush" id="ulPlaces">
            
        </ul>
    </div>
    <div class="col-md-6" >
        <div id="map"></div>
    </div>
</div>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN_cd0b0fER_n9T2df91qHPreZ5Jr08VQ&callback=initMap&libraries=&v=weekly"
    async
></script>
  
@endsection

@section('footer-scripts')
    @include('scripts.weather-script')
@endsection


