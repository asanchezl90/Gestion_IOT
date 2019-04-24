<?php 
  require_once("ajax/membersite_cfg.php");

  if(!$fgmembersite->CheckLogin()) 
  {
    $fgmembersite->RedirectToURL("index.php");
    exit;
  } 
  if(!$fgmembersite->DBLogin())
  {
    $this->HandleError("Database login failed!");
    return false;
  }    
?>
<!DOCTYPE html>
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
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
				    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">IOT Domotica</a>
				<a class="navbar-brand" data-toggle="modal" data-target="#update_password_modal">Gestion</a>
				<a class="navbar-brand" href="http://192.168.0.80:8080" target="_blank">Estadisticas</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav navbar-right">
				<li>
                    <a href="javascript:logout();" class="pull-right"> <strong> User ->  <?php echo " ".$_SESSION[$fgmembersite->GetLoginSessionVar()]. "  " ;  ?> </strong>					
					<button type="button" class="btn btn-default btn-link btn-xs" aria-label="Centre Align">
							<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
					</button>  				
					</a>
				</li>					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
<!-- Page Content -->
	<div class="container">
      <div class="jumbotron">
        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Lista de IOT's</h1>
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">Lista IOTs</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="content">
						    <h3> Instalación :  <?php echo " ".$_SESSION['instalacion']; ?> 
							  <div class="pull-right">
							     <button class="btn btn-success" data-toggle="modal" data-target="#add_new_iot_modal"> Nuevo Dispositivo</button>
							  </div>
							</h3>
							<div class="row">
								<div class="col-md-12">
									<!-- Datos desde readRecords.php -->				
									<div class="records_content"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>			
	  </div>
	</div>
<!-- /Content Section -->
<!-- Bootstrap Modals -->
<!-- Modal - Add New Record/IOT -->
<div class="modal fade" id="add_new_iot_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Añadir Nuevo Dispositivo</h4>
            </div>
            <div class="modal-body">
				<div class="form-group">
                    <label for="name">ID</label>
                    <input type="text" id="id" placeholder="ID" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" placeholder="Nombre Dispositivo" class="form-control"/>
                </div> 
                <div class="form-group">
                    <label for="notas">Descripción</label>
                    <input type="text" id="notas" placeholder="Descripción Instalación" class="form-control"/>
                </div> 
                <div class="form-group">
                    <label for="sensores">Sensores</label>
                    <input type="text" id="sensores" placeholder="Sensores del dispositivo" class="form-control"/>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="addIOT()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal ******************--> 
<!-- Modal - Update Iot details -->
<div class="modal fade" id="update_iot_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modificar Datos</h4>
            </div>
            <div class="modal-body"> 
				<div class="form-group">
                    <label for="name">ID</label>
                    <input type="text" id="update_id" placeholder="ID" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="update_name" placeholder="Nombre Dispositivo" class="form-control"/>
                </div> 
                <div class="form-group">
                    <label for="notas">Descripción</label>
                    <input type="text" id="update_notas" placeholder="Descripción Instalación" class="form-control"/>
                </div> 
                <div class="form-group">
                    <label for="sensores">Sensores</label>
                    <input type="text" id="update_sensores" placeholder="Sensores del dispositivo" class="form-control"/>
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="UpdateIOTDetails()" >Guardar Cambios</button>
                <input type="hidden" id="hidden_iot_id">
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->

<!-- Modal para el cambio de contraseña -->
<!-- Modal - Update IOT details -->
<div class="modal fade" id="update_password_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Cambio de Contraseña</h4>
            </div>
            <div class="form-group">
            <!-- Modal Body -->
            <div class="modal-body">
			<div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                  <input class="form-control" data-minlength="6"  type="password" id="newpass" placeholder="Nueva Contraseña" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-log-in"></span></div>
                  <input class="form-control" data-minlength="6" type="password" id="newpass2" data-match="#newpass" data-match-error="Whoops, these don't match" placeholder="Repetir Contraseña" required>
                </div>
              </div> 
            </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary submitBtn" onclick="ValidaPassword()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->

<!-- Modal Lista Usuarios RFID -->
<!-- Modal - Lista -->

<!-- // Modal -->
<div class="modal fade" id="lista_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><div class="iot_title"></div>
				  <div class="pull-right">
					<button type="button" class="btn btn-info add-new" onclick="javascript:yesnoCheck();"> New</button>
				  </div>
				</h4>
			</div>
            <div class="form-group">
            <!-- Modal Body -->
              <div class="modal-body">
				
				<div class="records_content2"></div>		   
            
				<!-- Si queremos modificar datos  -->				
				<div id="ifYes" style="display:none">
				    <h4 class="modal-title" id="myModalLabel">Añadir/Modificar RFID</h4>
					<div class="form-group">
					<div class="input-group">
						<label for="name">RFID</label>
						<input type="text" id="update_rfid" placeholder="RFID" class="form-control"/>
					</div> 
					</div>
					<div class="form-group">
						<label for="name">Nombre</label>
						<input type="text" id="update_rfid_name" placeholder="Nombre RFID" class="form-control"/>
					</div> 
					<div class="form-group">
						<label for="name">Permitir
						<input type="checkbox" id="update_block" value=1 placeholder="Permitir2" class="form-control"/>
						</label>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default"  onclick="CerrarCheckUser()">Cerrar</button>
						<button type="button" class="btn btn-primary submitBtn" onclick="ValidaUserDetails()">Aceptar</button>
					    <input type="hidden" id="hidden_rfid_id">
						<input type="hidden" id="hidden_tipo_action">
					</div>
				</div>
              </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary submitBtn" onclick="ValidaPassword()">Aceptar</button>-->
            </div>
        </div>
    </div>
</div>
 
<!-- Jquery JS file -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<!-- Bootstrap JS file -->
<script type="text/javascript" src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<!-- Custom JS file -->
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>