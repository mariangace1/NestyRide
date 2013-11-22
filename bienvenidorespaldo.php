<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Static Top Navbar Example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="navbar-static-top.css" rel="stylesheet"> -->

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

<!--Mapa-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
  <script src="http://maps.googleapis.com/maps/api/js?&sensor=false"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  
  <script>
	var initialLocation;
    var siberia = new google.maps.LatLng(60, 105);
    var newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);
    var browserSupportFlag =  new Boolean();
  

    function initialize() {
        var myOptions = {
            zoom: 11,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        var marker;
        var destinoMarker;


             function populateInputs(ori) {
            document.getElementById("ox").value=ori.lat()
            document.getElementById("oy").value=ori.lng();
            
            
        }

        function placeMarker(origen, destino) {
            if (marker) {
                marker.setPosition(origen);
            } else {
               marker = new google.maps.Marker({
                    position: origen,
                    map: map,
                    draggable: true
                });
                google.maps.event.addListener(marker, "drag", function (mEvent) {
                    populateInputs(mEvent.latLng);
                });

                destinoMarker = new google.maps.Marker({
                    position: destino,
                    map: map,
                    draggable: true
                });
                google.maps.event.addListener(destino, "drag", function (mEvent) {
                    populateInputs(mEvent.latLng);
                });
            }
            
            console.log(origen.ob);
            console.log(origen.pb);
            populateInputs(origen,destino);

        }

        myListener = google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng,event.latLng);
        });
        //google.maps.event.addListener(map, 'drag', function(event) {
          //  placeMarker(event.latLng);
            
        //});

        // Try W3C Geolocation (Preferred)
        if(navigator.geolocation) {
            browserSupportFlag = true;
            navigator.geolocation.getCurrentPosition(function(position) {
                initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                map.setCenter(initialLocation);
            }, function() {
                handleNoGeolocation(browserSupportFlag);
            });
            // Try Google Gears Geolocation
        } else if (google.gears) {
            browserSupportFlag = true;
            var geo = google.gears.factory.create('beta.geolocation');
            geo.getCurrentPosition(function(position) {
                initialLocation = new google.maps.LatLng(position.latitude,position.longitude);
                map.setCenter(initialLocation);
            }, function() {
                handleNoGeoLocation(browserSupportFlag);
            });
            // Browser doesn't support Geolocation
        } else {
            browserSupportFlag = false;
            handleNoGeolocation(browserSupportFlag);
        }

        function handleNoGeolocation(errorFlag) {
            if (errorFlag === true) {
                alert("Geolocation service failed.");
                initialLocation = newyork;
            } else {
                alert("Your browser doesn't support geolocation. We've placed you in Siberia.");
                initialLocation = siberia;
            }
        }



    }

    google.maps.event.addDomListener(window, 'load', initialize);

  </script>

<!--EndMapa-->

  </head>

  <body style="">

    <!-- Static navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../navbar/">Default</a></li>
            <li class="active"><a href="./">Static top</a></li>
            <li><a href="../navbar-fixed-top/">Fixed top</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Navbar example</h1>
        <div id="map_canvas" style="width:1000px;height:600px;"></div>
        <p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>To see the difference between static and fixed top navbars, just scroll.</p>
        <p>
          
            <form class="navbar-form" role="search">
                <div class="form-group">
                <h4>Origen</h4>
                </div>
                <div class="form-group">
                <input type="text" class="form-control" id="ox" placeholder="Latitud">
                </div>
                <div class="form-group">
                <input type="text" class="form-control" id="oy" placeholder="Longitud">
                </div>
            </form>

            <form class="navbar-form" role="search">
                <div class="form-group">
                <h4>Destino</h4>
                </div>
                <div class="form-group">
                <input type="text" class="form-control" id="ox" placeholder="Latidud">
                </div>
                <div class="form-group">
                <input type="text" class="form-control" id="oy" placeholder="Longitud">
                </div>
            </form>
            <a class="btn btn-lg btn-primary" href="components/#navbar" role="button">View navbar docs »</a>
        </p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>-->
    <script src="dist/js/bootstrap.min.js"></script>
  

</body></html>