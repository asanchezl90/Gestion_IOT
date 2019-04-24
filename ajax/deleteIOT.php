<?php
// *****************************************************************
// Fichero deleteIOT.php
// Elimina un dispositivo a la BBDD. En la tabla 'dispositivo'
// *****************************************************************
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
// check request
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
    // get user id
    $iot_id = $_POST['id'];
    // delete User
    $query = "DELETE FROM dispositivo WHERE id = '$iot_id'";
    if (!$result = mysqli_query($fgmembersite->connection2, $query)) {
        exit(mysqli_error($fgmembersite->connection2));
    }
    $fgmembersite->connection2->close();
}
?>