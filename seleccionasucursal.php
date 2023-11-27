<?php
session_start();
include("seguridad.php");
unset($_SESSION["sucursal"]);
?>
<html>
<head>
<title>Agricola Paredes :: Validacion de XML</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="./css/estilos.css">

<link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript" src="js/Chart.js"></script>
<script type="text/javascript" src="js/jquery.easing.js"></script>
<script type="text/javascript" src="js/jquery.ulslide.js"></script>
<script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
<!----Calender -------->
<script src="js/underscore-min.js"></script>
<script src= "js/moment-2.2.1.js"></script>
<script src="js/clndr.js"></script>
<script src="js/site.js"></script>
<!----End Calender -------->
<script>
	$(":file").filestyle({buttonBefore: true});
</script>
<script src="js/sweet-alert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="js/sweet-alert.css">
<script type="text/javascript" src="js/moment.js"></script>
<script>
$(function() {
	var now = moment().format("DD-MMM-YYYY, h:MM A");
	//$('#date').append(now);
});
</script>
</head>
<body>			       
     <div class="wrap">	 
        <div class="header">
      		<img id="logo" src="img/logo2.png">
      		<div id="prueb">      			
      			<span id="date"><?php  echo $_SESSION['user']; ?></span>
      			<?php if(@$_SESSION["bScursal"]==1){ ?>
      			
      			<?php }?>
				<a id="cerrar" href="logout.php">Cerrar sesi&oacute;n</a>
				<div class="clear"></div>	
      		</div>
		</div>	  					     
	</div>
	    <div class="main">  
	    	<div class="wrap"> 
	    	
		  	    <div class="column_left2">
		  	    	<h1 style="text-align:center; font-size:2em;">Selecciona la sucursal para cargar los comprobantes fiscales</h1>
	        		<table style="width: 100%;text-align: center;float:right;">
						<tr>
							<td><span><a href="inicio-normal.php?prmSucursal=001"><div class="map"></div></a></span><div class="clear"></div></td>
							<td><span><a href="inicio-normal.php?prmSucursal=003"><div class="map"></div></a></span><div class="clear"></div></td>
						</tr>
						<tr>
							<td><span><a id="carga" href="inicio-normal.php?prmSucursal=001">Culiac&aacute;n, Sinaloa.</a></span><div class="clear"></div></td>
							<td><span><a id="carga" href="inicio-normal.php?prmSucursal=003">Cd. Guzm&aacute;n, Jalisco</a></span><div class="clear"></div></td>
						</tr>
					</table>
	  			</div> 
		  		<div id="popup">
					<a href="#" id="close"><img src="img/error.png" /></a>
					<div id="cpopup"></div>
				</div>            
	    		<div class="clear"></div>
 			</div>
    	</div>
    	
     <footer class="footer">
        <p>© 2024 Agricola Paredes S.A.P.I. de C.V.</p>
        <p>Paseo Niños Heroes Ext.520 Culiacán,Sinaloa. México CP.80000</p>
     </footer>
    
  	
</body>
</html>
