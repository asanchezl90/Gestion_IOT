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
    $name 	   = $_POST['name'];
    $notas     = $_POST['notas'];
    $sensores  = $_POST['sensores'];
	$id_old    = $_POST['id_old'];
	$ult_modi  = date("Y-m-d H:i:s");
	$user_mod  = $_SESSION[$fgmembersite->GetLoginSessionVar()];
    // Updaste User details
    $query = "UPDATE dispositivo SET id = '$id', name = '$name', notas = '$notas', sensores = '$sensores', ult_modi = '$ult_modi', user_mod = '$user_mod'  WHERE id = '$id_old'";    
	if (!$result = mysqli_query($fgmembersite->connection2, $query)) {
        exit(mysqli_error($fgmembersite->connection2));
    }
  }
  $fgmembersite->connection2->close();
?>