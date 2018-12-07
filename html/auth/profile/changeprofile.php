<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/dbconn.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/authphp/auth.php");
    $login = $_POST["login"];
    $email = $_POST["e-mail"];
    $passwd = $_POST["passwd"];
    $confirmpasswd = $_POST["confirmpasswd"];
    $statuslogin = "";
    $statusemail = "";
    $statuspasswd = "";
    if(!empty($login))
    {
        $loginfrombase = check_login($login);
        if(!$loginfrombase)
        {
            if(change_login($login))
            {
                $statuslogin='msgl=loginsuccess';
            }
        }
    }
    if(!empty($email))
    {
        $emailfrombase = check_email($email);
        if(!$emailfrombase)
        {
            if(change_email($email))
            {
                $statusemail='msge=emailsuccess';
            }
        }
    }
    if(!empty($passwd))
    {
        if(!empty($confirmpasswd))
        {
            if($confirmpasswd==$passwd)
            {
                $hash=crypt($passwd,substr($passwd, 0, 4));
                $passwdfrombase = check_passwd($hash,$login);
                if(!$passwdfrombase)
                {
                    if(changepasswd($passwd))
                    {
                        if (isset($_SESSION['autorize']))
                        {
                            if(isset($_COOKIE['autorize']))
                            {
                                deletelastlogin($_COOKIE['autorize'],$_SESSION['autorize']);
                            }
                            else
                            {
                                deletelastlogin(null,$_SESSION['autorize']);
                            }
                        }
                        else
                        {
                            
                            if(isset($_COOKIE['autorize']))
                            {
                                
                                deletelastlogin($_COOKIE['autorize'],null);
                            }
                        }
                        
                        setcookie('autorize',"",time()-3600);

                        $ip = $_SERVER["REMOTE_ADDR"];
                        
                        $cookiehash = crypt($passwd,$login);
                        setcookie('autorize',$cookiehash,time()+60*60*24*30,'/');
                        $result = createlastlogin($login,$hash,$ip,$cookiehash);
                        if($result==true)
                        {                   
                            $statuspasswd='msgp=changesuccess';
                        }
                    }
                }
                else
                {
                    $statuspasswd='msgp=alreadyexists';
                }
            }
            else
            {
                $statuspasswd='msgp=wrongpswd';
            }
        }
        else
        {
            $statuspasswd='msgp=notenterconfirmpswd';
        }
    }
    
    if(!empty($statuslogin))
    {
        if(!empty($statuspasswd) && !empty($statusemail))
        {
            header("Location: /auth/profile/?".$statuslogin."&".$statusemail."&".$statuspasswd);
            return 0;
        }
        elseif(!empty($statusemail))
        {
            header("Location: /auth/profile/?".$statuslogin."&".$statusemail);
            return 0;
        }
        elseif(!empty($statuspasswd))
        {
            header("Location: /auth/profile/?".$statuslogin."&".$statuspasswd);
            return 0;
        }
        else
        {
            header("Location: /auth/profile/?".$statuslogin);
            return 0;
        }
    }
    if(!empty($statusemail))
    {
        if(!empty($statuspasswd))
        {
            header("Location: /auth/profile/?".$statusemail."&".$statuspasswd);
            return 0;
        }
        else
        {
           header("Location: /auth/profile/?".$statusemail);
           return 0;
        }
    }
    if(!empty($statuspasswd))
    {
        header("Location: /auth/profile/?".$statuspasswd);
        return 0;
    }
    if(empty($statuslogin) && empty($statusemail) && empty($statuspasswd))
    {
        header("Location: /auth/profile");
        return 0;
    }
    

    function check_login($login){
        global $host,$user,$pswd,$database;
        $dbh = mysqli_connect($host,$user,$pswd,$database);
        $query="SELECT login FROM `ul_user`
                        WHERE ul_user.login = '$login'";
        $res=mysqli_query($dbh,$query);
        if($res)
        {
            $row=mysqli_fetch_row($res);
            $dbh->close();
            return $row[0];
        }
        $dbh->close();
        return false;
    }

    function check_email($email){
        global $host,$user,$pswd,$database;
        $dbh = mysqli_connect($host,$user,$pswd,$database);
        $query="SELECT mail FROM `ul_user`
                        WHERE ul_user.mail = '$email'";
        $res=mysqli_query($dbh,$query);
        if($res)
        {
            $row=mysqli_fetch_row($res);
            $dbh->close();
            return $row[0];
        }
        $dbh->close();
        return false;
    }


    function check_passwd($passwd,$login)
    {
        global $host,$user,$pswd,$database;
        $dbh = mysqli_connect($host,$user,$pswd,$database);
        $query="SELECT * FROM `ul_user`
                        WHERE ul_user.login = '$login' 
                        and ul_user.passwd = '$passwd'";
        $res=mysqli_query($dbh,$query);
        if($res)
        {
            $row=mysqli_fetch_row($res);
            $dbh->close();
            return $row[0];
            
        }
        $dbh->close();
        return false;
    }

    function change_login($login)
    {
        global $host,$user,$pswd,$database;
        if(isset($_SESSION["autorize"]))
	    {
            $session = $_SESSION["autorize"];
            $dbh = mysqli_connect($host,$user,$pswd,$database);
            $query_session="UPDATE `ul_user` 
                    inner join `ul_session` on ul_user.id = ul_session.login_id
                    set login='$login' 
                    where ul_session.hash_session = '$session'";
            $res=mysqli_query($dbh,$query_session);
            if($res)
            {
                return true;
            }
        }
        if(isset($_COOKIE["autorize"]))
	    { 
            $cookie = $_COOKIE["autorize"];
            $dbh = mysqli_connect($host,$user,$pswd,$database);
            $query_cookie="UPDATE `ul_user` 
            inner join `ul_cookie` on ul_user.id = ul_cookie.login_id
            set login='$login' 
            where ul_cookie.hash_cookie = '$cookie'";
            $res=mysqli_query($dbh,$query_cookie);
            if($res)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        return false;
    }

    function change_email($email)
    {
        global $host,$user,$pswd,$database;
        if(isset($_SESSION["autorize"]))
	    {
            $session = $_SESSION["autorize"];
            $dbh = mysqli_connect($host,$user,$pswd,$database);
            $query_session="UPDATE `ul_user` 
                    inner join `ul_session` on ul_user.id = ul_session.login_id
                    set mail='$email' 
                    where ul_session.hash_session = '$session'";
            $res=mysqli_query($dbh,$query_session);
            if($res)
            {
                return true;
            }
        }
        if(isset($_COOKIE["autorize"]))
	    { 
            $cookie = $_COOKIE["autorize"];
            $dbh = mysqli_connect($host,$user,$pswd,$database);
            $query_cookie="UPDATE `ul_user` 
            inner join `ul_cookie` on ul_user.id = ul_cookie.login_id
            set mail='$email' 
            where ul_cookie.hash_cookie = '$cookie'";
            $res=mysqli_query($dbh,$query_cookie);
            if($res)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        return false;
    }

    function changepasswd($passwd)
    {
        global $host,$user,$pswd,$database;

        $hash = crypt($passwd,substr($passwd, 0, 4));
        
        if(isset($_SESSION["autorize"]))
	    {
            $session = $_SESSION["autorize"];
            $dbh = mysqli_connect($host,$user,$pswd,$database);
            $query_session="UPDATE `ul_user` 
                    inner join `ul_session` on ul_user.id = ul_session.login_id
                    set passwd='$hash' 
                    where ul_session.hash_session = '$session'";
            $res=mysqli_query($dbh,$query_session);
            if($res)
            {
                return true;
            }
        }
        if(isset($_COOKIE["autorize"]))
	    { 
            $cookie = $_COOKIE["autorize"];
            $dbh = mysqli_connect($host,$user,$pswd,$database);
            $query_cookie="UPDATE `ul_user` 
            inner join `ul_cookie` on ul_user.id = ul_cookie.login_id
            set passwd='$hash' 
            where ul_cookie.hash_cookie = '$cookie'";
            $res=mysqli_query($dbh,$query_cookie);
            if($res)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        return false;
    }
?>