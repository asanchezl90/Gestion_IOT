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
                            <th>No.</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
							<th>sensores</th>							
							<th>Registro</th>
							<th>ult_modi</th>
							<th>user_mod</th>
							<th>Acciones</th>                            
                        </tr>';

    $qry = "SELECT id, name, notas, instalacion, sensores, registrado, ult_modi, user_mod FROM dispositivo Order by 1";	
    $query=mysqli_query($fgmembersite->connection2, $qry);
    $totalData = mysqli_num_rows($query);
  
    // Comprueba que la Select devuelva registros 
    if ($totalData > 0) 
    {
         while( $row = mysqli_fetch_array($query))
        {
  		     $cadena = '<button onclick="GetIOTDetails(\''.$row['id'].'\')"class="glyphicon glyphicon-pencil btn btn-warning"></button>
                    <button onclick="DeleteIOT(\''.$row['id'].'\')"class="glyphicon glyphicon-trash btn btn-danger"></button>
					<button onclick="GetUserDetails(\''.$row['id'].'\')"class="glyphicon glyphicon-user btn btn-info"></button>'; 
			  $data .= '<tr> 
                <td>'.$row['id'].'</td>
                <td>'.$row['name'].'</td>
                <td>'.$row['notas'].'</td>
                <td>'.$row['sensores'].'</td> 
				<td>'.$row['registrado'].'</td>
				<td>'.$row['ult_modi'].'</td> 
				<td>'.$row['user_mod'].'</td>				
                <td>'.$cadena.'</td>
               </tr>';   
         }  
    }
    else
    {
        // records now found 
        $data .= '<tr><td colspan="6">No hay Registros!</td></tr>';
    } 
    $data .= '</table>';
	echo $data;
	$fgmembersite->connection2->close();
?>
