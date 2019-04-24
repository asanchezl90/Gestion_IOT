<?php
// include Database connection file
  require_once(dirname(__DIR__).'/ajax/membersite_cfg.php');
// readUserDetails.php 
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
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    // get iot ID
    $iot_id = $_POST['id'];
 
    // Get iot Details
    $query = "SELECT * FROM dispositivo WHERE id = '$iot_id'";
    if (!$result = mysqli_query($fgmembersite->connection2, $query)) {
        exit(mysqli_error($fgmembersite->connection2));
    }
    $response = array();
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
        }
    }
    else
    {
        $response['status'] = 200;
        $response['message'] = "Data not found!";
    }
    // display JSON data
    echo json_encode($response);
}
else
{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}
$fgmembersite->connection2->close();
?>