// READ records
function abrirEnPestana(url) {
var a = document.createElement("a");
alert('la contraseña');
	a.target = "_blank";
	a.href = url;
	a.click();
	//link.parentElement.removeChild(link);
}

function readRecords() {
	$.get("ajax/readRecords.php", {}, function (data, status) {
        $(".records_content").html(data);
	//alert(data);   
    });
}

// Add Record
function addIOT() {
    // get values
	var id = $("#id").val();
    var name = $("#name").val();
    var notas = $("#notas").val();
    var sensores = $("#sensores").val();
 
    // Add record
    $.post("ajax/addIOT.php", {
        id: id,
		name: name,
        notas: notas,
        sensores: sensores
    }, function (data, status) {
        // close the popup
        $("#add_new_iot_modal").modal("hide"); 
        // read records again
        readRecords(); 
        // clear fields from the popup
        $("#id").val("");
		$("#name").val("");
        $("#notas").val("");
        $("#sensores").val("");
    });
	
}

function GetIOTDetails(id) {
    // Add iot ID to the hidden field for furture usage
    //alert(id);
	$("#hidden_iot_id").val(id);
    $.post("ajax/readIOTDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var iot = JSON.parse(data);
            // Assing existing values to the modal popup fields
			$("#update_id").val(iot.id);
            $("#update_name").val(iot.name);
            $("#update_notas").val(iot.notas);
            $("#update_sensores").val(iot.sensores);
        }
    );
    // Open modal popup
    $("#update_iot_modal").modal("show");
}

function GetUserDetails(id) {
    // Add iot ID to the hidden field for furture usage
    // alert(id);	
	$("#hidden_iot_id").val(id);
	$(".iot_title").html("Códigos RFID's registrados para el IOT " + id);
	$.post("ajax/readUserDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            //alert(data);
			$(".records_content2").html(data);
        }
    );   
	document.getElementById('ifYes').style.display = 'none';
    // Open modal popup
    $("#lista_user_modal").modal("show");
}

function CerrarCheckUser() {
    // Esta funcion se usa cuando cierrar el monitor de usarios
	$("#update_rfid").val("");
	$("#update_rfid_name").val("");
	$("#update_block").val("");
	document.getElementById('ifYes').style.display = 'none';
    $(".add-new").removeAttr("disabled");	
}

function yesnoCheck(id, id_rfid, descripcion, permite_acceso, i_u) {
	//alert(i_u);
	$(".add-new").attr("disabled", "disabled");
	if (i_u === ''){
		i_u = 'I'
	}
	$("#hidden_tipo_action").val(i_u);
	if (i_u === 'D'){
		var conf = confirm("Seguro que quiere borrar el usuario?");
		if (conf == true) {
			$.post("ajax/mov_gestion_user.php", {
			rfid: id_rfid,
			rfid_name: descripcion,
			block: permite_acceso,
			id: id,
			tipo_mov: i_u
			}, function (data, status) {
			// close the popup
				document.getElementById('ifYes').style.display = 'none';
			// read records again
				GetUserDetails(id); 
			// clear fields from the popup
				$("#update_rfid").val("");
				$("#update_rfid_name").val("");
				$("#update_block").val("");
			});
		}
	} 
	else
	{
    //if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'block';
		// inicializa valores
		//$("#hidden_iot_id").val(id);
		$("#hidden_rfid_id").val(id_rfid);		
		$("#update_rfid").val('');
		$("#update_rfid_name").val('');
		$("#update_block")[0].checked = false;
		// Si es UPDATE carga los valores		
		if (i_u === 'U' ){
			$("#update_rfid").val(id_rfid);
			$("#update_rfid_name").val(descripcion);
			if (permite_acceso === 1){ 	
			   $("#update_block")[0].checked = true;
			}
			else $("#update_block")[0].checked = false;
        }
	}
}

// Add Record
function ValidaUserDetails() {
    // get values
	var id        = $("#hidden_iot_id").val();
	var rfid_old  = $("#hidden_rfid_id").val();
	var rfid 	  = $("#update_rfid").val();
    var rfid_name = $("#update_rfid_name").val();
    var block 	  = 0;
	if ($("#update_block")[0].checked){
	   block 	  = 1;
	}
	var i_u_d = $("#hidden_tipo_action").val();
    //alert('Permite -> ' +id+ ' ' + rfid + ' ' + block);
    // Add record
    $.post("ajax/mov_gestion_user.php", {
        rfid: rfid,
        rfid_old: rfid_old,		
		rfid_name: rfid_name,
        block: block,
        id: id,
		tipo_mov: i_u_d
    }, function (data, status) {
        // close the popup
		document.getElementById('ifYes').style.display = 'none';
        //$("#add_new_iot_modal").modal("hide"); 
        // read records again
		//alert(data)
        GetUserDetails(id); 
        // clear fields from the popup
        $("#update_rfid").val("");
		$("#update_rfid_name").val("");
        $("#update_block").val("");
    });
}

 
function UpdateIOTDetails() {
    // get values
    var id = $("#update_id").val();
    var name = $("#update_name").val();
    var notas = $("#update_notas").val();
    var sensores = $("#update_sensores").val();
 
    // get hidden field value
    var id_old = $("#hidden_iot_id").val();
 
    // Update the details by requesting to the server using ajax
    $.post("ajax/updateIOTDetails.php", {
            id: id,
			id_old: id_old,
            name: name,
            notas: notas,
            sensores: sensores
        },
        function (data, status) {
            // hide modal popup
            $("#update_iot_modal").modal("hide");
            // reload Iots by using readRecords();
            readRecords();
        }
    );
}
  
function logout() {
    var conf = confirm("Desea Cerrar sesion ?");
    if (conf == true) {
		$.get("ajax/logout.php", {}, 
		function (data, status) {
        //alert(data);
		window.location.replace("index.php");
		});
	}
}
 
function DeleteIOT(id) {
    var conf = confirm("Seguro que quiere borrar el dispositivo?");
    if (conf == true) {
        $.post("ajax/deleteIOT.php", {
                id: id
            },
            function (data, status) {
                // reload Iots by using readRecords();
                readRecords();
            }
        );
    }
}  

function ValidaPassword(){
    var newpass = $('#newpass').val();
    var newpass2 = $('#newpass2').val();
    
    if(newpass.trim() == '' ){
        alert('la contraseña debe ser de al menos 6 cararacteres !!');
        $('#newpass').focus();
        return false;
    }else		
		if(newpass2.trim() != newpass.trim() ){
			   alert('Las contraseñas no coinciden !!!');
               $('#newpass2').focus();
			   return false;
             }
			 else
			   {
			// Update the details by requesting to the server using ajax
			   $.post("ajax/updatePassDetails.php", {
					newpass: newpass,
					newpass2: newpass2
				},
				function (data, status) {
					// hide modal popup
					alert(data);
					$('#newpass').val('');
					$('#newpass2').val('');
					$("#update_password_modal").modal("hide");
					// reload IOTs by using readRecords();
					readRecords();
				   }
				);
			   }
}	

$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function	
});