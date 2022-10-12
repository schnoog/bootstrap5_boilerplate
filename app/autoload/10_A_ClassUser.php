<?php 


class SHUser{

    public static function AddUser ($username,$email,$password,$groupid){
        $data = [
            'sec_users_name' =>  $username,
            'sec_users_password' => password_hash($password, PASSWORD_DEFAULT),
            'sec_users_email' => $email
        ];
        DB::insert('sec_users',$data);
        $lastid = DB::insertId();
        $data = [
            'sec_users_usergroups_user_id' => $lastid,
            'sec_users_usergroups_usergroup_id' => $groupid
        ];
        DB::insert('sec_users_usergroups',$data);
        return $lastid ;
    }

    public static function DoesUserExist($identifier){
        $res = DB::query("Select * from sec_users WHERE sec_users_name like %s",$identifier);
        if($res) return true;
        return false;
    }

    public static function UserLogin($username,$password,&$message,$setCookie = false){
        global $App;
        if(!SHUser::DoesUserExist($username)){
            $message = gettext("User doesn't exist");
            return false;
        }
        $userline = DB::queryFirstRow("Select * from sec_users WHERE sec_users_name like %s",$username);
        if($userline['sec_users_failcount'] >= $App['security']['max_fail_count']){
            if(time() < $userline['sec_users_lastfail'] + $App['security']['bantime_on_max_fail_count']){
                $message = gettext("Too many login failes, please try again later");
                return false;
            }
        }

        if (password_verify($password, $userline['sec_users_password'])) {
            $data = [
                'sec_users_lastlog' => time(),
                'sec_users_failcount' => 0,
            ];
            DB::update('sec_users', $data, "sec_users_id=%i", $userline['sec_users_id']);
            if($userline['sec_users_active'] == 1){
                if($setCookie){
                    SHUser::CookieSetLogin($userline);
                }
                $_SESSION['loggedin']= true;
                $_SESSION['user'] = $userline;
                $_SESSION['groupmemberhip']= SHUser::UserGroupsGet($userline['sec_users_id']);
                $_SESSION['logged_in_by_cookie'] = false;
                return true;
            }else{
                $message = gettext("User-Account not activated");
                return false;
            }


        }else{
            $data = [
            'sec_users_lastfail' => time(),
            'sec_users_failcount' => $userline['sec_users_failcount'] + 1,
            ];
            DB::update('sec_users', $data, "sec_users_id=%i", $userline['sec_users_id']);
            $message = gettext("Wrong passpord");
            return false;
        }
    }

    public static function CookieSetLogin($userline){
        global $App;
        $cookieval = $userline['sec_users_id'] . "--" . md5($userline['sec_users_id'] . $userline['sec_users_password'] . $App['security']['rand_key'][0]);
        setcookie('login',$cookieval,time()+60*60*24*365 ,"/",$App['Settings']['site']['Domain']);
    }

    public static function CookieDelete(){
        global $App;
        setcookie('login','',time()+1 ,"/",$App['Settings']['site']['Domain']);
    }

    public static function UserGroupsGet($userid){
        $ugs = DB::query('SELECT * from sec_users_usergroups INNER JOIN sec_usergroups ON sec_users_usergroups.sec_users_usergroups_usergroup_id = sec_usergroups.sec_usergroups_id WHERE sec_users_usergroups_user_id = %i',$userid);
        if(!$ugs) return false;
        $ret = array();
        for($x=0;$x < count($ugs);$x++){
            $ug = $ugs[$x];
            $ret[$ug['sec_usergroups_group']] = $ug['sec_usergroups_level' ];

        }
        return $ret;
    }

    public static function GetLoginCookieVal($userid){
        global $App;
        $userline = DB::queryFirstRow("SELECT * from sec_users WHERE sec_users_id = %i",$userid);
        $cookieval = $userline['sec_users_id'] . "--" . md5($userline['sec_users_id'] . $userline['sec_users_password'] . $App['security']['rand_key'][0]);
        return $cookieval;
    }

    public static function IsLoginCookieValid($cookiedata){
        global $App;
        list($userid,$checkdata) = explode("--",$cookiedata);
        $userline = DB::queryFirstRow("SELECT * from sec_users WHERE sec_users_id = %i",$userid);
        $cookieval = $userline['sec_users_id'] . "--" . md5($userline['sec_users_id'] . $userline['sec_users_password'] . $App['security']['rand_key'][0]);
        if($cookiedata === $cookieval){
            return $userline;
        }
        return false;
    }

    public static function CookieResume(){
        if(!isset($_COOKIE['login'])){
            return false;
        }
        $cookiedata = SHUser::IsLoginCookieValid ( $_COOKIE['login']);
        if(!$cookiedata){
            return false;
        }
        $_SESSION['loggedin']= true;
        $_SESSION['user'] = $cookiedata;
        $_SESSION['logged_in_by_cookie'] = true;
        $_SESSION['groupmemberhip']= SHUser::UserGroupsGet($cookiedata['sec_users_id']);
        return true;

    }

    public static function Logout(){
        session_unset();
        session_destroy();
        session_start();
        $_SESSION = array();

    }
/*
  `sec_authtoken_id` int(11) NOT NULL,
  `sec_authtoken_user_id` int(11) DEFAULT NULL,
  `sec_authtoken_token` varchar(256) DEFAULT NULL,
  `sec_authtoken_meaning` varchar(45) DEFAULT NULL,
  `sec_authtoken_used` int(11) DEFAULT 0,
  `sec_authtoken_issued` int(11) DEFAULT NULL
*/ 
    public static function AddUserToken($userid, $token,$meaning){
            DB::query("Delete from sec_authtoken WHERE sec_authtoken_user_id LIKE %s AND sec_authtoken_meaning LIKE %s",$userid,$meaning);
            $data=[
                'sec_authtoken_user_id' => $userid,
                'sec_authtoken_token' => $token,
                'sec_authtoken_meaning' => $meaning,
                'sec_authtoken_issued' => time()
            ];
            DB::insert('sec_authtoken',$data);
    }

    public static function GetUserByID($userid){
        $res = DB::query("Select * from sec_users WHERE sec_users_id = %i LIMIT 1",$userid);
        return $res[0];
    }

    public static function GetUserByName($username){
        $res = DB::query("Select * from sec_users WHERE sec_users_name like %s LIMIT 1",$username);
        return $res[0];
    }

    public static function Register($username,$password_1,$password_2,$email,&$error){
        global $App;
        $error = array();
        if(SHUser::DoesUserExist($username)){
            $error[] = gettext('Username is already registered');
        }

        SHUser::PasswordValidityCheck($password_1,$password_2,$error);


        if(!BF::IsValidEmail($email)){
            $error[] = gettext("The e-mail address you entered doesn't seem to work");
        }

        if(count($error)>0){
            return false;
        }
        $newuserid = SHUser::AddUser($username,$email,$password_1,90);
        if($newuserid){
            $sid = md5(rand(11111111,99999999).$App['security']['rand_key'][1]);
            $cryptkey = $App['security']['rand_key'][2];
            $authtoken = BF::XORCryptAsBase64($sid,$cryptkey);
            SHUser::AddUserToken($newuserid,$authtoken,'activation');
            if(MyMail::SendTokenMail($username,$email,$authtoken,true)){
                return true;
            }else{
                $error[] = gettext("The e-mail with the activation link couldn't be sent.");
                return false;
            }
        }else{
            $error[] = gettext("Something went wrong during the creation of the account. Please try it again. If the error happens again, contact the administrator");
            return false;
        }
    }

    /**
     * Use the auth token
     */
    public static function RequestPWChange($username,$email,&$error){
        global $App;
        $workuser = SHUser::GetUserByName($username);
        if(!$workuser){
            $error[] = gettext("Username not found");
            return false;
        }
        if($workuser['sec_users_email'] != $email){
            $error[] = gettext("The email address doesn't match with the one registered with");
            return false;
        }
        $sid = md5(rand(11111111,99999999).$App['security']['rand_key'][1]);
        $cryptkey = $App['security']['rand_key'][2];
        $authtoken = BF::XORCryptAsBase64($sid,$cryptkey);
        SHUser::AddUserToken($workuser['sec_users_id'],$authtoken,'pwreset');
        if(MyMail::SendTokenMail($workuser['sec_users_name'],$workuser['sec_users_email'],$authtoken,true)){
            return true;
        }else{
            $error[] = gettext("The e-mail with the password reset link couldn't be sent.");
            return false;
        }


    }

    public static function UseAuthToken($userid,$token){
        $tokenentry = DB::queryFirstRow("Select * from sec_authtoken WHERE sec_authtoken_user_id LIKE %s AND sec_authtoken_token LIKE %s AND sec_authtoken_used = 0",$userid,$token);
        if(!$tokenentry) return false;
        if($tokenentry['sec_authtoken_token'] == $token) {
            DB::query('UPDATE sec_authtoken SET sec_authtoken_used = %i WHERE sec_authtoken_id = %i',time(),$tokenentry['sec_authtoken_id']);
            return $tokenentry['sec_authtoken_meaning'];
        }
        return false;
    }

    public static function ResetPW($userid,$token,$password_1,$password_2,&$error){
        SHUser::PasswordValidityCheck($password_1,$password_2,$error);
        if(count($error)> 0) return false;
        $hastoken = SHUser::UseAuthToken($userid,$token);
        if(!$hastoken){
            $error[] = gettext("The token you used isn't known to the system");
            return false;
        }
        if($hastoken != "pwreset"){
            $error[] = gettext("The token you used isn't valid for resetting your password");
            return false;            
        }
        $pwhash = password_hash($password_1, PASSWORD_DEFAULT);
        DB::query("UPDATE sec_users SET sec_users_password = %s WHERE sec_users_id =%i",$pwhash,$userid);
        return DB::affectedRows();

    }

    public static function PasswordValidityCheck($password_1,$password_2,&$error){
        $haserror = false;
        if(strlen($password_1) < 8){
            $error[] = gettext('Your password is too short');
            $haserror = true;
        }

        if($password_1 != $password_2){
            $haserror = true;
            $error[] = gettext("The passwords you entered don't match");
        }

    }

    public static function ChangePassword($userid,$oldpassword,$password_1,$password_2,&$error){
        $userline = SHUser::GetUserByID($userid);
        if (!password_verify($oldpassword, $userline['sec_users_password'])) {
            $error[]= gettext("Wrong passpord");
            return false;
        }
        SHUser::PasswordValidityCheck($password_1,$password_2,$error);
        if(count($error)> 0) return false;

        $pwhash = password_hash($password_1, PASSWORD_DEFAULT);
        DB::query("UPDATE sec_users SET sec_users_password = %s WHERE sec_users_id =%i",$pwhash,$userid);
        return DB::affectedRows();
    }

    public static function AktivateUserByID($userid){
        DB::query('UPDATE sec_users SET sec_users_active = 1 WHERE sec_users_id = %i',$userid);
    }

    public static function SetUserPassword($userid,$password){
        $pwhash = password_hash($password, PASSWORD_DEFAULT);
        DB::query("UPDATE sec_users SET sec_users_password = %s WHERE sec_users_id =%i",$pwhash,$userid);
    }

}