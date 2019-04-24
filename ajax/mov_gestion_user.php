<?php
// include Database connection file
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
 
// check request
  if(isset($_POST))
  {
    // get values
    $id 	   = $_POST['id'];
    $rfid 	   = $_POST['rfid'];
	$rfid_old  = $_POST['rfid_old'];
    $rfid_name = $_POST['rfid_name'];
    $block     = $_POST['block'];
	$tipo_mov  = $_POST['tipo_mov'];
    // Updaste User details
	if ($tipo_mov == 'U'){
		$query = "UPDATE accesos SET  id_rfid = '$rfid', nombre = '$rfid_name', permite_acceso = '$block'  WHERE id_iot = '$id' AND id_rfid = '$rfid_old'";    	
	}
	else
	{
		if ($tipo_mov == 'D'){
			$query = "DELETE FROM accesos WHERE id_iot = '$id' AND id_rfid = '$rfid'";
		} else{
			$query = "INSERT INTO accesos (id_iot, id_rfid, nombre, permite_acceso) VALUES ('$id','$rfid','$rfid_name', '$block')";    	
		}
	}
	if (!$result = mysqli_query($fgmembersite->connection2, $query)) {
        exit(mysqli_error($fgmembersite->connection2));
    }
	echo $tipo_mov. ' -- ' .$query;
  }
  $fgmembersite->connection2->close();
?>