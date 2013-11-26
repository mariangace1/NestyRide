<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: login.php');
}

?>

<?php  

include('config.inc');
$user = $_SESSION['username'];
$sql = "select * from entrada where usuario = '{$user}'";
$data = query($sql);

?>


<!DOCTYPE html>
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
          <a class="navbar-brand" href="#">Nesty Ride</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../navbar-fixed-top/"><?php echo $_SESSION['username']; ?></a></li>
            <li><a type="submit" class="btn btn-success" href="logout.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <?php if(isset($guardado_ok)): ?>
		<div class="container">
		<div class="alert alert-success">a</div>
		 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<div class="alert alert-success alert-dismissable">Petici&oacute;n guardada correctamente</div>
	</div>
	<?php endif; ?>
    
    
    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Mis solicitudes/ofertas</h1>
        
        <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Rol</th>
                  <th>Tiempo</th>
                  <th>opciones</th>
                </tr>
              </thead>
              <tbody>
				  <?php foreach($data as $key => $row): ?>
				<tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['rol']; ?></td>
                  <td><?php echo $row['tiempo']; ?></td>
                  <td><a href = "mis_rides.php?id=<?php echo $row['id']; ?>" > Encontrar match</a></td>
                  
                </tr>
				  <?php endforeach; ?>
                
                
              </tbody>
            </table>

      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>-->
    <script src="dist/js/bootstrap.min.js"></script>
  

</body></html>
