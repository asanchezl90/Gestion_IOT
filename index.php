<?PHP
require_once('ajax/membersite_cfg.php');
// Carga la varible de Sesion, si la tiene.
$fgmembersite->CheckLogin();
if(isset($_POST['submitted']))
{
   if($fgmembersite->Login())
   {
        $fgmembersite->RedirectToURL("lista.php");
   }
}
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IOT DOMÓTICA</title>
	<meta name="description" content="Entorno de control de dispositivos conectados">
	<link rel="stylesheet" type="text/css" href="bootstrap-3.3.7-dist/css/bootstrap.css"/>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">IOT Domótica</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
				<li>
 					<?php
					    $s = $_SESSION[$fgmembersite->GetLoginSessionVar()] ;
						if ($s != ''){
						echo '<a href="javascript:logout();" class="pull-right"> <strong> User -> '.$s.' </strong>					
							<button type="button" class="btn btn-default btn-link btn-xs" aria-label="Centre Align">
								<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
							</button>  				
							</a>'; 
						}
					?>			
				</li>
				<li>
                        <a href="lista.php">Registro Dispositivos</a>
                </li>
              </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header Carousel -->
    <header id="myCarousel" class="carousel slide">
		<img src="img/logo1.jpg" class="img-fluid" alt="Responsive image">
        <!-- Wrapper for slides -->
    
    </header>
    <!-- Page Content -->	
	  <div class="container">	  
        <!-- Marketing Icons Section -->
        <div class="row justify-content-center">         
                <h1 class="page-header">
                    Acceso de Usuario
                </h1>            
				<div class="col-md-4">
				  <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-compass"></i> Control de Acceso</h4>
                    </div>
                    <div class="panel-body">
					<div id='fg_membersite'>
					<form id='Control de Acceso' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
					   <fieldset > 
							<input type='hidden' name='submitted' id='submitted' value='1'/>		
							<div class='short_explanation'>* campos obligatorios</div>
							<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
							  <div class='container'>
										<label for='username' >Usuario*:</label><br/>
										<input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
										<span id='login_username_errorloc' class='error'></span>
							  </div>
							<div class='container'>
										<label for='password' >Contraseña*:</label><br/>
										<input type='password' name='password' id='password' maxlength="50" /><br/>
										<span id='login_password_errorloc' class='error'></span>
							</div>

							<div class='container'>
							    <br>
								<input type='submit' name='Submit' value='Comprobar' />
							</div>
					   </fieldset>
					</form>
					</div>
					</div>
				</div>
            </div>
            
        </div>
        <!-- /.row -->		
        <!-- Footer -->
        <?php include("footer.html");?>
    </div>	
	<!-- /.container -->
    <!-- jQuery -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<!-- Custom JS file -->
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>
