<?php
// *****************************************************************
// Fichero addIOT.php
// Añade un nuevo dispositivo a la BBDD. En la tabla 'dispositivos'
// *****************************************************************  
  require_once(dirname(__DIR__).'/ajax/membersite_cfg.php');
  if(!$fgmembersite->CheckLogin()) 
  {
    $fgmembersite->RedirectToURL("index.php");
    exit;
  }
  if(!$fgmembersite->DBLogin())
  {
    $fgmembersite->HandleError("Database login failed!");
    return false;
  }     

  if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['notas']) && isset($_POST['sensores']))
  {
      // get values 
	  $id          = $_POST['id'];
      $name        = $_POST['name'];
      $notas       = $_POST['notas'];
      $sensores    = $_POST['sensores'];	  
      $instalacion = $_SESSION['instalacion'];
	  $registrado  = date("Y-m-d H:i:s");
	  $ult_modi    = date("Y-m-d H:i:s");
	  $user_mod    = $_SESSION[$fgmembersite->GetLoginSessionVar()];
	 
      $query = "INSERT INTO dispositivo(id, name, notas, sensores, instalacion, registrado) VALUES( '$id', '$name', '$notas', '$sensores', '$instalacion', '$registrado')";
      if (!$result = mysqli_query($fgmembersite->connection2, $query)) {
        exit(mysqli_error($fgmembersite->connection2));
      }
      echo "1 Record Added!";
  }
  $fgmembersite->connection2->close();
?>