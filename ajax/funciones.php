<?PHP
/*
    This program is free software published under the
    terms of the GNU Lesser General Public License.
    http://www.gnu.org/copyleft/lesser.html
Referencias:
http://www.html-form-guide.com/php-form/php-registration-form.html
http://www.html-form-guide.com/php-form/php-login-form.html
*/

class FGMembersite
{
    var $db_host;
	var $username;
    var $pwd;
    var $database;
    var $tablename;  
    var $connection2;    
    var $rand_key;

    
    var $error_message;

    //-----Initialization -------
    function FGMembersite()
    {
		$this->sitename = 'localhost';
        $this->rand_key = '0iQx5oBk66oVZep';
    }
    
    function InitDB($host,$uname,$pwd,$database,$tablename)
    {
        $this->db_host   = $host;
        $this->username  = $uname;
        $this->pwd       = $pwd;
        $this->database  = $database;
        $this->tablename = $tablename;        
    }
  
    function SetRandomKey($key)
    {
        $this->rand_key = $key;
    }
     //-------Main Operations ----------------------
	function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }

	function GetSelfScript()
    {
        return htmlentities($_SERVER['PHP_SELF']);
    }
	
	function SafeDisplay($value_name)
    {
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
	
	function ValidaPass()
    {
        if(empty($_POST[$value_name1]) OR empty($_POST[$value_name2]))
        {
            return'';
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
        
        $newpass  = trim($_POST['newpass']);
        $newpass2 = trim($_POST['newpass2']);
 		
         if(!$this->DBLogin())
        {
            $this->HandleError("Error al hacer login en la BBDD");
            return false;
        }          
		$newpass_md5 = md5($newpass);
		$username = $_SESSION['name_of_user'];
		if (mysqli_query($this->connection2, "UPDATE usuarios set password = '$newpass_md5' WHERE username = '$username'") or die(mysqli_error()))
		{
			echo "Cambio Realizado";
		}
		return true;
    }
	
	function GetErrorMessage()
    {
        if(empty($this->error_message))
        {
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }
	
	function HandleError($err)
    {
        $this->error_message .= $err."\r\n";
    }
    
    function HandleDBError($err)
    {
        $this->HandleError($err."\r\n mysqlerror:".mysqli_error());
    }
	
	function Login()
    {
        if(empty($_POST['username']))
        {
            $this->HandleError("Usuario vacio!");
            return false;
        }
        
        if(empty($_POST['password']))
        {
            $this->HandleError("Password vacio!");
            return false;
        }
        
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if(!isset($_SESSION)){ session_start(); }
        if(!$this->CheckLoginInDB($username,$password))
        {
            return false;
        }        
        $_SESSION[$this->GetLoginSessionVar()] = $username; 
        
        return true;
    }
	
	function CheckLogin()
    {
         if(!isset($_SESSION)){ session_start(); }

         $sessionvar = $this->GetLoginSessionVar();
         
         if(empty($_SESSION[$sessionvar]))
         {
            return false;
         }
         return true;
    }
    
    function LogOut()
    {
        session_start();
        $sessionvar = $this->GetLoginSessionVar();
        $_SESSION[$sessionvar]=NULL;
        unset($_SESSION[$sessionvar]);
		session_destroy();
	}

	function GetLoginSessionVar()
    {
        $retvar = md5($this->rand_key);
        $retvar = 'usr_'.substr($retvar,0,10);
        return $retvar;
    }
    
    function CheckLoginInDB($username,$password)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Error al hacer login en la BBDD");
            return false;
        }          
        $username = $this->SanitizeForSQL($username);

  	    $nresult = mysqli_query($this->connection2,"SELECT * FROM $this->tablename WHERE username = '$username'") or die(mysqli_error());
         
        $no_of_rows = mysqli_num_rows($nresult);
        if ($no_of_rows > 0) {
            $nresult = mysqli_fetch_array($nresult);
            
            $encrypted_password = $nresult['password'];			
            $hash = md5($password);           
        }        
        if(!$nresult ||  $no_of_rows <= 0 || $hash <> $encrypted_password )
        {       
		 $this->HandleError("Error iniciando sesión. Usuario o Contraseña incorrectos");
            return false;
        } 
		
		// Comprueba el codigo de la instalacion
		$ins = shell_exec('cat /proc/cpuinfo | grep Serial | cut -d " " -f 2');
		$this->Guarda_ID_Instalacion($ins); 		
		
		$_SESSION['instalacion']  = $ins;
        $_SESSION['name_of_user']  = $nresult['name'];
        $_SESSION['email_of_user'] = $nresult['email'];
        		
        return true;
    }
	
	// Guarda los datos de la instalacion en caso de que no los tenga.	
	function Guarda_ID_Instalacion($ins)
	{
        if(!$this->DBLogin())
        {
            $this->HandleError("Error al hacer login en la BBDD");
            return false;
        }          
		$nresult = mysqli_query($this->connection2, "SELECT * FROM instalacion WHERE id_ins = '$ins'") or die(mysqli_error());
		
        $no_of_rows = mysqli_num_rows($nresult);
		
        if ($no_of_rows === 0) {
			if (mysqli_query($this->connection2,"DELETE FROM instalacion") or die(mysqli_error())) {
				mysqli_query($this->connection2,"INSERT INTO instalacion(id_ins) values('$ins')") or die(mysqli_error());
			}
        }  
				
		mysqli_close($this->connection2);		
		return true;
	}
	
	function SanitizeForSQL($str)
    {
        if( function_exists( "mysqli_real_escape_string" ) )
        {
              $ret_str = mysqli_real_escape_string($this->connection2, $str );
        }
        else
        {
              $ret_str = addslashes( $str );
        }
        return $ret_str;
    }
	
    
	function DBLogin()
    {
        $this->connection2 = mysqli_connect($this->db_host,$this->username,$this->pwd,$this->database);

        if(!$this->connection2)
        {   
            $this->HandleDBError("Error al hacer Login! Por favor asegurese que Usuario/Contraseña son correctos");
            return false;
        }

        if(!mysqli_select_db($this->connection2,$this->database))
        {
            $this->HandleDBError('Error al hacer Login en: '.$this->database.' Por favor asegurese que el nombre de la BBDD es correcto.');
            return false;
        }
        if(!mysqli_query($this->connection2,"SET NAMES 'UTF8'"))
        {
            $this->HandleDBError('Error configurando utf8 encoding');
            return false;
        }
        return true;
    }		
}
?>