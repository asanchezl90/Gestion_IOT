<?php
   $nom=dirname(__DIR__).'/ajax/membersite_cfg.php';
/*  if (file_exists($nom)) {
    echo "El fichero $nom existe";
} else {
    echo "El fichero $nom no existe";
} */
  require_once($nom);
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
    // Codigo de la Instalacion
    
    $data = '<table class="table table-bordered table-striped">
                        <tr>
                            <th>RFID</th>
                            <th>Nombre</th>
                            <th>Acceso</th>		
							<th>Acción</th>								
                        </tr>';
	if(isset($_POST))
	{
		// get values
		$id     = $_POST['id'];
		$update = 'U';
		$delete = 'D';
		

		$qry = "SELECT id_iot, id_rfid, nombre, permite_acceso FROM accesos WHERE id_iot = $id Order by 1,2";	
		$query=mysqli_query($fgmembersite->connection2, $qry);
		$totalData = mysqli_num_rows($query);
  
		// Comprueba que la Select devuelva registros 
		if ($totalData > 0) 
		{
			while( $row = mysqli_fetch_array($query))
			{
  		      $id_rfid = $row['id_rfid'];
			  $nombre = $row['nombre'];
			  if ($row['permite_acceso'] == 1){
				  $permite_acceso = 'SI';
			  }
			  else
			  {
				$permite_acceso = 'NO';  
			  }
			  // Envia 'I' -> Insert, 'U' -> Update y 'D' -> Delete
			  //$cadena = '<button onclick="javascript:yesnoCheck(\''.$id.'\',\''.$id_rfid.'\',\''.$nombre.'\','.$permite_acceso.',\'U\');" name="yesno" id="yesCheck" class="glyphicon glyphicon-pencil btn btn-warning"></button>'; 
			  $cadena = '<a href="javascript:yesnoCheck(\''.$id.'\',\''.$id_rfid.'\',\''.$nombre.'\','.$row['permite_acceso'].',\''.$update.'\');" name="yesno" id="yesCheck" class="glyphicon glyphicon-pencil"></a>
			             <a href="javascript:yesnoCheck(\''.$id.'\',\''.$id_rfid.'\',\''.$nombre.'\','.$row['permite_acceso'].',\''.$delete.'\');" name="yesno" id="yesCheck" class="glyphicon glyphicon-trash"></a>';			  
			  
			  $data .= '<tr> 
                <td>'.$row['id_rfid'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$permite_acceso.'</td>                			
                <td>'.$cadena.'</td>
               </tr>';   
			}  
		}
		else
		{
			// records now found 
			$data .= '<tr><td colspan="6">No hay Registros!</td></tr>';
		}
    }  
    $data .= '</table>';
	echo $data;
	$fgmembersite->connection2->close();
?>
