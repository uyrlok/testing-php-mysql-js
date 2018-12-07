<?php
require_once($_SERVER['DOCUMENT_ROOT']."/admin/authphp/auth.php");

if($_POST["submit"]==true){
    
    $login = $_POST["username"];
    $passwd = $_POST["password"];
    $ip = $_SERVER["REMOTE_ADDR"];
    $hash=crypt($passwd,substr($passwd, 0, 4));
    $cookiehash = crypt($passwd,$login);
    $idhash = sha1($login+rand());
    if(checkautorize_count($cookiehash)<=5)
    {
    
        setcookie('autorize',$cookiehash,time()+60*60*24*30,'/');
        setcookie('id',$idhash,time()+60*60*24*30,'/');

        $result = createlastlogin($login,$hash,$ip,$cookiehash,$idhash);
        if($result==true)
        {
            session_start();
            $_SESSION['autorize'] = $cookiehash;
            header('Location: /');
        }
        else{
            header('Location: /auth/?message=no');
        }
    }
    else
    {
        header('Location: /auth/?message=Данная учетная запись уже авторизована на 5 предыдущих устройствах');
    }
}


?>