<?php
// Modificado: 18-01-2010 por Jorge Salas Carrillo
define('TZN_USER_NAME_REGEXP','/^[a-zA-Z0-9._-]+$/');
// email : define('TZN_USER_NAME_REGEXP','/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/');

class TznUser extends TznDb {

    var $_logingOut;   
		// destroying session is not effective,
    	// so have to set this to true if loggin off

    function TznUser($table) {
    	$this->_properties = array(
    		'id'				=> 'UID',
    		'username'			=> 'STR',
    		'password'			=> 'STR',
    		'salt'				=> 'STR',
    		'autologin'			=> 'BOL',
    		'timezone'			=> 'INT',
    		'lastlogindate'		=> 'DTM',
    		'lastloginaddress'	=> 'STR',
    	    'creationdate'		=> 'DTM',
			'lastchangedate'	=> 'DTM',
    		'visits'			=> 'NUM',
    		'badaccess'			=> 'NUM',
    		'enabled'			=> 'BOL',
		 	'avatar'            => 'STR',
			'email'             => 'STR',
            'levelx'         	=> 'NUM',
            'firstname'         => 'STR',
            'lastname'          => 'STR',
			'phone'		        => 'STR',
			'status'	        => 'STR',
            'lastactivity'      => 'STR'
   		);
   		$this->_table=$table;
   		$this->timeZone=0;
    }
	function getFullName() {
		$str = $this->firstname.' '.$this->lastname;
		return $str;		
	}
	function getAvatar($size='32') {
		if ($this->avatar != ''){
       		$str = "<img src='thumb.php?src=".$this->avatar."&av=".$size."&zc=1' class='avatar size".$size."' />";
      	}else{
			$str = "<img src='thumb.php?src=avatar/user.png&av=".$size."&zc=1' class='avatar size".$size."' />";
      	}		
		//$str = $this->firstName.','.$str;		
		return ($str) ? $str : $default;
	}
	function getLevelName(){
		$tt="Invitado";
		switch($this->levelx){
			case 1 :
				$tt="Administrator";
			break;
			case 2 :
				$tt="User";
			break;
		}
		return $tt;
	}
	function isAdmin(){
		return ($this->levelx==1)? true:false;
	}	
	function check($pass1, $pass2, $force=false) {
		if ($this->email) {
            $check1 = !$this->checkUnique('email',$this->email);
            if (!$check1) {
                $this->e('email','An account already exists with this address');
            }
        } else {
            $check1 = true;
        }		
		// check unique login
        $check2 = $this->setLogin($this->username);
        if ($this->enabled || $force) {
            // check and set valid password
            $check3 = $this->setPassword($pass1, $pass2, false, $this->isLoaded());
        } else {
            $check3 = true;
        }
		if ($check1 && $check2 && $check3) {
			return true;
		} else {
			// failed first tests, do not save
			return false;
		}
	}
	/* Si es necesario subir un file */
    function uploadFile($field,$c='root_file'){
    	$archivo = new TznFile();	
    	if($archivo ->upload($field)){
				$archivo -> save();
				$this->setStr($field,'');
				$this->$c=$archivo->fileName;					
				return true;
    	}else{
    		return false;
    	}
    }	
	function removeFile($field='root_file'){
    	$archivo = new TznFile();  
    	//echo $this->img;      
		$archivo->delete($this->$field);
		$this->setStr($field,'');
		$this->update($field);
    }
	function qLoginTimeZone($name='tznUserTimeZone') {
		$str = '<script type="text/javascript" language="javascript">
				var tzo=(new Date().getTimezoneOffset()*60)*(-1);
				document.write(\'<input type="hidden" name="'.$name.'" value="\'+tzo+\'" />\');
				</script>';
		print $str;
	}

	function setLogin($username) 
    {
        if ((strlen($username) < TZN_USER_NAME_MIN) 
        	|| (strlen($username) > TZN_USER_NAME_MAX)) {
            $this->_error["username"] = 
            	$GLOBALS["langTznUser"]["user_name_limit1"]
            	.TZN_USER_NAME_MIN.$GLOBALS["langTznUser"]["user_name_limit2"]
            	.TZN_USER_NAME_MAX.$GLOBALS["langTznUser"]["user_name_limit3"];
            return false;
        } else if ($this->checkUnique("username",$username)) {
            $this->_error["username"] = "Username Exists";
            return false;
        } else if (preg_match(TZN_USER_NAME_REGEXP, $username)) {
            $this->username = $username;            
            return true;
        } else {
			$this->_error["username"] ="Username Invalid";
			return false;
		}
        return true;
    }

    function setPassword($pass1, $pass2 = false, 
    	$forceEmpty = false, $noEmptyError = false)
    {
        //echo ("setpass: [ $pass1 / $pass2 ]");
        if ($pass1 || $forceEmpty) {
            // a pass has been set
            if (($pass2 !== false) && ($pass1 != $pass2)) {
                // a confirmation has been set but is different 
                $this->_error["pass"] = 
                	$GLOBALS["langTznUser"]["user_pass_mismatch"];
                return false;
            }
            $this->salt = $this->getRdm(8,
            	'abcdefghijklmnopqrstuvwxyz'
            	.'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
            if ($pass1) {
                if ((strlen($pass1) >= TZN_USER_PASS_MIN) 
                	&& (strlen($pass1) <= TZN_USER_PASS_MAX)) {
                    switch (TZN_USER_PASS_MODE) {
                    case 1:
                        $this->password = crypt($pass1 , $this->salt);
                        break;
                    case 2:
                        $this->password = "ENCRYPT('".$pass1."','"
                        	.$this->salt."')";
                        break;
                    case 3:
                        $this->password = "ENCODE('".$pass1."','"
                        	.$this->salt."')";
                        break;
					case 4:
						$this->password = "MD5('$pass1')";
						break;
                    default:
                        $iv = mcrypt_create_iv (mcrypt_get_iv_size(MCRYPT_3DES
                        	, MCRYPT_MODE_ECB), MCRYPT_RAND);
                        $crypttext = mcrypt_encrypt(TZN_USER_PASS_MODE, $this->_salt
                        	, $pass1, MCRYPT_MODE_ECB, $iv);
                        $this->password = bin2hex($crypttext);
                    }
                } else {
                    $this->_error["pass"] = 
                    	$GLOBALS["langTznUser"]["user_pass_limit1"]
                    	.TZN_USER_PASS_MIN
                    	.$GLOBALS["langTznUser"]["user_pass_limit2"]
   	                   	.TZN_USER_PASS_MAX
   	                   	.$GLOBALS["langTznUser"]["user_pass_limit3"];
                    return false;
                }
            } else {
                $this->password = "";
            }
            return true;
        } else {
            if (!$forceEmpty && !$noEmptyError) {
                $this->_error["pass"] =
                	$GLOBALS["langTznUser"]["user_pass_empty"];
                return false;
            }
            return true;
        }
    }

    function updatePassword() {
		$this->update("password, salt, lastChangeDate");
    }

    function setLoginPassword($username, $pass1, $pass2 = false, 
    	$forceEmpty = false) 
    {
        //echo ("username = $username, pass = $pass1...");
        $step1 = $this->setPassword($pass1, $pass2, $forceEmpty, false);
        $step2 = $this->setLogin($username);
        return ($step1 && $step2);
    }

    function updateLoginPassword() {
		$this->update("username, password, salt, lastChangeDate");
	}

	function add() {
		$this->setDtm('creationDate',date("Y-m-d H:i:s"));
   		$this->setDtm('date_create',date("Y-m-d H:i:s"));		
		$this->setDtm('date_update',date("Y-m-d H:i:s"));
		$this->setNum('id_person_create', $_SESSION["tznUserId"]);		
		return parent::add();
	}
	
	function updateLevel(){return $this->update("levelx,lastChangeDate");}

    function update($fields=null) {
        $this->setDtm('lastChangeDate',date("Y-m-d H:i:s"));
        $this->setDtm('date_update',date("Y-m-d H:i:s"));
        if ($fields && (!preg_match('/lastChangeDate/',$fields))) {
        	$fields .= ",lastChangeDate";
        }
        return parent::update($fields);
    }
	
	function zBadAccess() {
        $strSql = "UPDATE ".$this->gTable()." SET"
            ." badAccess=badAccess+1"
            ." WHERE ".$this->getIdKey()." = '".$this->getUid()."'";
        $this->getConnection();
        $this->query($strSql);
    }

    function zCheckPassword($password) {
        switch (TZN_USER_PASS_MODE) {
        case 1: 
            if ($this->password == "") {
                $this->password = crypt("", $this->salt);
            }    
            if (crypt($password, $this->salt) != $this->password) {
                    // password invalid
                    $this->_error['login'] = 
                    	$GLOBALS["langTznUser"]["user_pass_invalid"];
                    $this->zBadAccess();
                    return false;
            }
            break;
        case 2:
            $strSql = "SELECT ENCRYPT('$password','".$this->salt
            	."') as passHash";
            if ($result = $this->query($strSql)) {
                if ($row = $result->rNext()) {
                    if ($row->passHash == $this->password) {
                        // password OK
                        break;
                    }
                }
            }
            $this->_error['login'] = 
            	$GLOBALS["langTznUser"]["user_pass_invalid"];
            $this->zBadAccess();
            return false; // error or password mismatch
            break;
        case 3:
            $strSql = "SELECT ENCODE('$password','".$this->salt
            	."') as passHash";
            if ($result = $this->query($strSql)) {
                if ($row = $result->rNext()) {
                    if ($row->passHash == $this->password) {
                        // password OK
                        break;
                    }
                }
            }
            $this->_error['login'] = 
            	$GLOBALS["langTznUser"]["user_pass_invalid"];
            $this->zBadAccess();
            return false; // error or password mismatch
            break;
		case 4:
			if (!$this->password && !$password) {
				break;
			}
			$strSql = "SELECT MD5('$password') as passHash";
            if ($result = $this->query($strSql)) {
                if ($row = $result->rNext()) {
                    if ($row->passHash == $this->password) {
                        // password OK
                        break;
                    }
                }
            }
            $this->_error['login'] = 
            	$GLOBALS["langTznUser"]["user_pass_invalid"];
            $this->zBadAccess();
            return false; // error or password mismatch
            break;
        default:
            for ($i = 0; $i < strlen($this->password); $i += 2) { 
                $passBin .= chr(hexdec(substr($s,$i,2))); 
            }
            $iv = mcrypt_create_iv (mcrypt_get_iv_size (MCRYPT_3DES,
            	MCRYPT_MODE_ECB), MCRYPT_RAND);
            if (mcrypt_decrypt (MCRYPT_3DES, $this->salt, $passBin,
            	MCRYPT_MODE_ECB, $iv) == $password)
            {
                break;
            }
            $this->_error['login'] = 
            	$GLOBALS["langTznUser"]["user_pass_invalid"];
            $this->zBadAccess();
            return false;
            break;
        }
        return true;
    }

    function _activateLogin($withLevel = true) {
    	if ($tz = $_REQUEST['tznUserTimeZone']) {
    		if ($this->getInt('timeZone') != $tz) {
				$this->setInt('timeZone',$tz);
				$updTz = ',timeZone';
			}
    	}
        // register session
        $_SESSION["tznUserId"] = $this->id;
        if ($withLevel) {
            $_SESSION["tznUserLevel"] = $this->levelx;
        } else {
            $_SESSION["tznUserLevel"] = "0";
        }
        $_SESSION["tznUserTimeZone"] = $this->timeZone;
		$_SESSION["tznUserName"] = $this->username;
		$_SESSION["tznUserLastLogin"] = $this->lastLoginDate;
		$_SESSION["tznUserLastAddress"] = $this->lastLoginAddress;

        // update last login
        $this->setDtm('lastLoginDate',date("Y-m-d H:i:s"));
		$this->lastLoginAddress = $_SERVER['REMOTE_ADDR'];
        $this->badAccess = 0;
		$this->visits++;
        $this->update('lastLoginDate,lastLoginAddress,badAccess,visits'.$updTz);
    }

    function login($username, $password, $level=null) {
        if ($username == '') {
            $this->_error['login'] = $GLOBALS["langTznUser"]["user_name_empty"];
            return false;
        }
        if (!preg_match(TZN_USER_NAME_REGEXP, $username)) {
        	$this->_error['login'] = $GLOBALS['langTznUser']['user_name_invalid'];
        	return false;
        }
        if ($this->loadByKey(TZN_USER_LOGIN,$username)) {
            if (($level!=null) && (!$this->getLvl($level))) {
                //Insufficient rights
                $this->_error['login'] = 
                	$GLOBALS["langTznUser"]["user_forbidden"];
            }
            if (!$this->enabled) {
                //Account Disabled
                $this->_error['login'] = 	
                	$GLOBALS["langTznUser"]["user_disabled"];
            }
            if (!$this->zCheckPassword($password)) {
                $this->_error['login'] = 	
                	$GLOBALS["langTznUser"]["user_password_invalid"];
            }
			if (count($this->_error)) {
				$this->zBadAccess();
				return false;
			}
        } else {
            $this->_error['login'] = 
            	$GLOBALS["langTznUser"]["user_name_not_found"];
            return false;
        }
        
    	$this->_activateLogin();
        return true;
    }

    function silentLogin($username, $password) {
        if ($username == '') {
            return false;
        }
        if ($this->loadByKey(TZN_USER_LOGIN,$username)) {
            if (!$this->enabled) {
                //Account Disabled
                $this->_error['login'] = 	
                    $GLOBALS["langTznUser"]["user_disabled"];
            }
            if (!$this->zCheckPassword($password)) {
                $this->_error['login'] = 	
                    $GLOBALS["langTznUser"]["user_password_invalid"];
            }
        } else {
            $this->_error['login'] = 
            	$GLOBALS["langTznUser"]["user_name_not_found"];
            return false;
        }
        return (count($this->_error) == 0);
    }


	function checkAutoLogin($forReal=true) {
        $cookieVal = $_COOKIE['autoLogin'];
		if (empty($cookieVal)) {
			return false;
		}
        $arrVal = explode(":",$cookieVal);
		$id = $arrVal[0];
		$salt = $arrVal[1];
        if($this->loadByFilter($this->gTable().'.'.$this->getIdKey()."='".$id
        	."' AND ".$this->gTable().".salt='".$salt."'")) 
        {
			if (!$forReal) {
				return true;
			}
			setCookie('autoLogin',$this->id.":".$this->salt
				,time()+(3600*24*30));
            $this->_activateLogin();
            return true;
        } else {
            return false;
        }
	}

    function setAutoLogin() {
        if (($this->id) && ($this->salt)) {
            setCookie('autoLogin',$this->id.":".$this->salt
            	,time()+(3600*24*30));
            $this->autoLogin = '1';
            $this->update('autoLogin');
            return true;
        }
        return false;
    }

    function resetAutoLogin() {
        if ($this->id) {
            setCookie('autoLogin');
            if ($this->autoLogin) {
	            $this->autoLogin = "0";
    	        $this->update("autoLogin");
    	    }
            return true;
        }
        return false;
    }

    function logout() {
		$_SESSION = array();
		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		// Finally, destroy the session.
		@session_destroy();
		// while you're at it, delete auto login
		$this->resetAutoLogin();
		// set internal variable
        $this->_logingOut = true;
    }

    function isLogged($level=null) {
        $lUserId = $_SESSION['tznUserId'];
        if ($lUserId == 0 || empty($lUserId) || $this->_logingOut) {
            return false;
        } else {
            $this->id = $lUserId;
			$this->levelx = $_SESSION['tznUserLevel'];
            $this->timeZone = $_SESSION['tznUserTimeZone'];
			$this->username = $_SESSION['tznUserName'];
			$this->lastLoginDate = $_SESSION['tznUserLastLogin'];
			$this->lastLoginAddress = $_SESSION['tznUserLastAddress'];
            if ($level) {
                if ($this->getLvl($level)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }

    function forgotPassword($key, $value) {
        // type can be 'username' or 'email'
        // forgotten password? Try to get it back or generate new one
        if ($this->salt == "") {
            if (!$this->loadByKey($key,$value)) {
                // user not found
                $this->_error['forgot'] = $key." not found";
                return false;
            }
        }
        switch (TZN_USER_PASS_MODE) {
        case 1:
            $newpass = $this->getRdm(6,"123456789");
            $this->password = crypt($pass1 , $this->salt);
            $this->updatePassword();
            break;
        case 2:
            $newpass = $this->getRdm(6,"123456789");
            $this->password = "ENCRYPT(\"".$pass1."\",\"".$this->salt."\")";
            $this->updatePassword();
            break;
        case 3:
            $strSql = "SELECT DECODE(password, '".$this->salt
            	."') as pass FROM ".$this->_table
            	." WHERE ".$this->getIdKey()."=".$this->id;
            if ($result = $this->query($strSql)) {
                if ($row = $result->nRow()) {
                    $this->password = $row->pass;
                    return $this->password;
                }
            }
            $this->_error['forgot'] = "can not decode?";
            return false;
            break;
		case 4:
            $newpass = $this->getRdm(6,"123456789");
			$this->password = "MD5('$newpass')";
            $this->updatePassword();
            break;
        default:
            $iv = mcrypt_create_iv (mcrypt_get_iv_size (MCRYPT_3DES,
            	MCRYPT_MODE_ECB), MCRYPT_RAND);
            $this->password = mcrypt_decrypt (MCRYPT_3DES, $this->salt,
            	$passBin, MCRYPT_MODE_ECB, $iv);
            return $this->password;
            break;
        }
        return $newpass;
    }

}

?>