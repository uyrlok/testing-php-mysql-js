<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/admin/authphp/auth.php");
    
    if (isset($_SESSION['autorize']))
    {
        if(isset($_COOKIE['autorize']))
        {
            deletelastlogin($_COOKIE['autorize'],$_SESSION['autorize'],$_COOKIE["id"]);
        }
        else
        {
            deletelastlogin(null,$_SESSION['autorize'],$_COOKIE["id"]);
        }
    }
    else
    {
        
        if(isset($_COOKIE['autorize']))
        {
            
            deletelastlogin($_COOKIE['autorize'],$_COOKIE['autorize'],$_COOKIE["id"]);
        }
    }
    
    setcookie('autorize',"",time()-3600);
    setcookie('id',"",time()-3600);
    header('Location: /');
?>