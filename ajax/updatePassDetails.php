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
  if(empty($_POST['newpass']))
  {
    $this->HandleError("Password vacio!");
    return false;
  }
        
  if(empty($_POST['newpass2']))
  {
    $this->HandleError("Password vacio!");
    return false;
  }
  if($_POST['newpass2']<> $_POST['newpass'])
  {
    $this->HandleError("Las contaseñas no coinciden!");
    return false;
  }
  
// check request
  if(isset($_POST))
  {
    // get values
    $newpass     = $_POST['newpass'];
    $newpass2    = $_POST['newpass2'];    
	$newpass_md5 = md5($newpass);
	$username    = $_SESSION[$fgmembersite->GetLoginSessionVar()];
	
    // Updaste User details
    $query = "UPDATE usuarios set password = '$newpass_md5' WHERE username = '$username'";
    if (!$result = mysqli_query($fgmembersite->connection2, $query)) {
        exit(mysqli_error($fgmembersite->connection2));
    }
	echo $username;
	return true;
  }
  $fgmembersite->connection2->close();
?>