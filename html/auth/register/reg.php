<?php
require_once($_SERVER['DOCUMENT_ROOT']."/admin/authphp/auth.php");


if($_POST["submit"]==true)
{
    
    if(!empty($_POST["username"]))
    {
        if(!empty($_POST["password"]))
        {
            if(!empty($_POST["repeatpass"]))
            {
                if(!empty($_POST["mail"]))
                {
                    $result=false;
                    $login=$_POST["username"];
                    $passswd=$_POST["password"];
                    $confpswd=$_POST["repeatpass"];
                    $mail=$_POST["mail"];
                    $ip=$_SERVER["REMOTE_ADDR"];
                    if(strlen($login)>1)
                    {
                        echo($login);
                        $result = checklogin($login);
                        if($result==false){
                            $result = checkmail($mail);
                            if($result==false)
                            {
                                if ($passswd==$confpswd)
                                {
                                    
                                    $hash = crypt($passswd,substr($pswd,0,4));

                                    $cookiehash = md5($passswd+$login);
                                    
                                    setcookie('autorize',$cookiehash,time()+60*60*24*30,'/');

                                    $result = createnewlogin($login,$hash,$mail);

                                    if($result==true)
                                    {
                                        $result = createlastlogin($login,$hash,$ip,$cookiehash);
                                        if($result==true)
                                        {
                                            session_start();
                                            $_SESSION['autorize'] = $cookiehash;
                                        }
                                        header('Location: /');
                                    }
                                }
                                else{
                                    header('Location: /auth/register/index.php?message=notconfirm');
                                }
                            }
                            else
                            {
                                header('Location: /auth/register/index.php?message=alreadymail');
                            }
                        }
                        else{
                            header('Location: /auth/register/index.php?message=alreadylogin');
                        }
                    }
                    else{
                        header('Location: /auth/register/index.php?message=smalllogin');
                    }
                }
                else{
                    header('Location: /auth/register/index.php?message=notmail');
                }
            }
            else{
                header('Location: /auth/register/index.php?message=notrepeatpass');
            }
        }
        else{
            header('Location: /auth/register/index.php?message=notpass');
        }
    }
    else{
        header('Location: /auth/register/index.php?message=notlogin');
    }
}
?>