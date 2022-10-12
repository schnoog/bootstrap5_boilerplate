<?php 

Class BF {
	/**
	*   Take a variable, if it's not an array, wrap it in one. Remove empty elements
	*/
    public static function WrapAndRemoveEmpties($ArrayOrValueGiven){
        if(!is_array($ArrayOrValueGiven)) $ArrayOrValueGiven = [$ArrayOrValueGiven];
            return array_filter($ArrayOrValueGiven);
    }

	/**
	*	XOR crypt, takes input (if is base64 decode it first), do the XOR and return XORed value as base64
	*/
	public static function XORCryptAsBase64($StringGiven, $cryptkey){
		if(BF::is_base64($StringGiven)) $StringGiven = base64_decode($StringGiven);
		for($i = 0; $i < strlen($StringGiven); $i++) 
			$StringGiven[$i] = ($StringGiven[$i] ^ $cryptkey[$i % strlen($cryptkey)]);
		return base64_encode($StringGiven);	
	}

	/**
	*	Check whether the value is base64 encoded or not
	*/
	public static function is_base64($s)
	{
		  return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
	}

	/**
	*	Check whether the given string is a valid email address or not
	*/
	public static function IsValidEmail($mail) {
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			return false;
		}
		return true;
	}
	
	/**
	* 	Created a session based CSRF Token and saves it in $_SESSION['CSRF-Token'] 
	*/
	public static function CreateSessionToken(){
		global $App;
		$sid = session_id();
		$cryptkey = $App['security']['rand_key'][1];
		$token = BF::XORCryptAsBase64($sid,$cryptkey);	
		$_SESSION['CSRF-Token'] = $token;
		return $token;
	}

	/**
	*	Checks the given CSRF-Token against the current session id
	*/
	public static function CheckPostToken($tokenname = 'csrf-token'){
		global $App;
		if(!isset($_POST[$tokenname])) return false;
		$token = $_POST[$tokenname];
		$crypted = $_SESSION['CSRF-Token'];
		return $crypted === $token;
	}

	/**
	*	Checks the given CSRF-Token against the current session id
	*/
	public static function CheckSessionToken($token){
		global $App;
		$sid = session_id();
		$cryptkey = $App['security']['rand_key'][1];
		$crypted = BF::XORCryptAsBase64($sid,$cryptkey);
		return $crypted === $token;
	}
	/**
	*   Returns a random column (array) of numbers 
	*/
	public static function GetNewRands($count = 4){
		$output = array();
		for($x = 0; $x < $count; $x++){
			$output[] = rand(0,9);
		}
		return $output;
	}
	/**
	*   Returns the "CAPTCHA" as table of chars
	*/
	public static function PaintCaptcha($NumberArray,$charsize = 14){
		$output = '<table border="1"><tr>';
		foreach($NumberArray as $Number){
			$output .= '<td style="text-align: center; vertical-align: middle;">';
			$output .= BF::PaintNumber($Number,$charsize);
			$output .= '</td>';
		}	
		$output .= '</tr></table>';
		return $output;
	}
	/**
	*	Return the "image" representing a single number
	*/
	public static function PaintNumber($num,$charsize=14){
		$output = '<p style="font-size: '.$charsize.'px">';
		$cnt = 0;
		$todo = $num;
		for($x = 0; $x < 3; $x++){		
			for($y=0;$y < 3 ; $y++){
				if($todo > 0){
					$output .= "<small>&#10003;</small>";
					$todo--;
				}else{
					$output .=  "&#157;";
				}
				$cnt++;
			}
		$output .=  "<br>";	
		}
		$output .= "&#8415;" . "&#8415;" . "&#8415;";
		$output .= '</p>';
		return $output;
	}

	/**
	*
	*/

	public static function CreateNewToken(){
		global $App;
		$sid = md5(rand(11111111,99999999).$App['security']['rand_key'][1]);
		$cryptkey = $App['security']['rand_key'][1];
		$token = BF::XORCryptAsBase64($sid,$cryptkey);	
		$_SESSION['CSRF-Token'] = $token;
		return $token;
	}



}