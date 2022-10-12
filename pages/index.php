<?php 



$msg="";


$runtime['css_to_include'][] = "login.css";

if(in_array('logout',$App['info']['requestslist'])){
    SHUser::Logout();
    SHUser::CookieDelete();
    $msg = "Logout";
    $runtime['forward_to'] = $runtime['BaseUrl'];
}

if(in_array('login',$App['info']['requestslist'])){
    $template = 'sections/login';
    $runtime['css_to_include'][] = "login.css";
    if(isset($_POST['username']) && isset($_POST['password'])){
            if(BF::CheckPostToken()){
                $setcookie = isset($_POST['setcookie']);
                $msg = "";
                if(! SHUser::UserLogin($_POST['username'],$_POST['password'],$msg,$setcookie)){
                    $runtime['error'] = $msg;
                }else{          
                    $runtime['success'] = "Login OK";
                    $runtime['loggedin'] = true;
                    $runtime['forward_to'] = $runtime['BaseUrl'];
                }
            }else{
                $runtime['error'][] = gettext('The security token is invalid. Please go to the main site to update yours');
            }

    }

}

if(in_array('register',$App['info']['requestslist'])){
    $template = 'sections/register';
    $runtime['css_to_include'][] = "login.css";
    if(isset($_POST['username1']) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['email'])){
        if(BF::CheckPostToken()){

            $tmp = SHUser::Register($_POST['username1'],$_POST['password1'],$_POST['password2'],$_POST['email'],$runtime['error']);
            if($tmp) $template ="success";
            $runtime['success'][] = gettext("Your user account was created. Please check your emails for the activation link");

/*            if(! SHUser::UserLogin($_POST['username'],$_POST['password'],$msg,$setcookie)){
                $runtime['error'] = $msg;
            }else{          
                $runtime['success'] = "Login OK";
                $runtime['loggedin'] = true;
                $runtime['forward_to'] = $runtime['BaseUrl'];
            }
*/            
        }else{
            $runtime['error'][] = gettext('The security token is invalid. Please go to the main site to update yours');
            $template ="warning";
        }
    }

}

if(in_array('pwreset',$App['info']['requestslist'])){
    $template = 'sections/pwreset';
    
    if(isset($_POST['username2']) && isset($_POST['email2']) ){
        if(BF::CheckPostToken()){

            $tmp = SHUser::RequestPWChange($_POST['username2'],$_POST['email2'],$runtime['error']);
            if($tmp) $template ="success";
            $runtime['success'][] = gettext("Your password reset request was processed. Please check your emails for the password reset link");
/*            if(! SHUser::UserLogin($_POST['username'],$_POST['password'],$msg,$setcookie)){
                $runtime['error'] = $msg;
            }else{          
                $runtime['success'] = "Login OK";
                $runtime['loggedin'] = true;
                $runtime['forward_to'] = $runtime['BaseUrl'];
            }
*/            
        }else{
            $runtime['error'][] = gettext('The security token is invalid. Please go to the main site to update yours');
            $template ="warning";
        }
    }

}

if (in_array('usetoken', $App['info']['requestslist'])) {
    if (in_array('password', $App['info']['requestslist'])) {
        $template = 'sections/auth_pwreset';
    }
    if (in_array('account', $App['info']['requestslist'])) {
        $template = 'sections/auth_activate';
    }

    if(isset($_REQUEST['username']) && isset($_REQUEST['authkey'])){
        if(isset($_REQUEST['action'])){
            if($_REQUEST['action'] == 'pwreset'){
                $user = SHUser::GetUserByName($_REQUEST['username']);
                if (SHUser::UseAuthToken($user['sec_users_id'], $_REQUEST['authkey']) == 'pwreset') {
    
                $pwok = SHUser::PasswordValidityCheck($_POST['password1'], $_POST['password2'], $runtime['error']);
                if ($pwok) {
                    if (!$user) {
                        $runtime['error'][] = gettext("Username not found");
                    } else {
                        SHUser::SetUserPassword($user['sec_users_id'], $_POST['password1']);
                        $runtime['success'][] = gettext('Your password has been changed');
                    }
                }
        }else{
            $runtime['error'][] = "The authentification key you entered was invalid";
        }
            }
            if($_REQUEST['action'] == 'activation'){
                $user = SHUser::GetUserByName($_REQUEST['username']);
                if(!$user) {
                    $runtime['error'][] = gettext("Username not found");
                }else{
                    if( SHUser::UseAuthToken($user['sec_users_id'],$_REQUEST['authkey']) == 'activation'){
                        SHUser::AktivateUserByID($user['sec_users_id']);
                        $runtime['sucess'][] = gettext('Your account is now activated');
                       }else{
                        $runtime['error'][] = gettext("Token isn't valid for your account activation");
                    }
                }
            }

        }
        
        
    }


}


//$res['session'] = $_SESSION;
//$runtime['message']= $msg;
