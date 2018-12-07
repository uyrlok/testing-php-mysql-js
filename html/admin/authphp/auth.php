<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/dbconn.php");

function getlastlogin_cookie($key,$idcookie)
{
    
    global $host,$user,$pswd,$database,$port;
    $m = array("status"=>false,"login"=>"","id"=>"");
    $dbh = mysqli_connect($host,$user,$pswd,$database,$port);
    $query="SELECT login, ul_access.id, mail FROM `ul_user` 
    inner join `ul_user_access` on ul_user.id = ul_user_access.id_user
    inner join `ul_access` on ul_user_access.id_access = ul_access.id
    right join `ul_cookie` on ul_user.id = ul_cookie.login_id
    where ul_cookie.hash_cookie = '$key'
    and ul_cookie.id_cookie = '$idcookie'";
    $res=mysqli_query($dbh,$query);
    
    if($res)
    {
        
        $row=mysqli_fetch_row($res);
        if(strlen($row[0])>0)
        {
        $m['login'] = $row[0];
        $m['id']=$row[1];
        $m['status']=true;
        $m['mail']=$row[2];
        }
        $dbh->close();
        return $m;
    }
    else
    {
        $dbh->close();
        return $m;
    }
    
    
}

function getlastlogin_session($key,$idsession)
{
    global $host,$user,$pswd,$database,$port;
    $m = array("status"=>false,"login"=>"","type"=>"");
    $dbh = mysqli_connect($host,$user,$pswd,$database,$port);
    $query="SELECT * FROM `ul_user` 
    inner join `ul_user_access` on ul_user.id = ul_user_access.id_user
    inner join `ul_access` on ul_user_access.id_access = ul_access.id
    right join `ul_session` on ul_user.id = ul_session.login_id
    where ul_session.hash_session = '$key'
    and ul_session.id_session = '$idsession'";
    $res=mysqli_query($dbh,$query);
    if($res)
    {
        while($row=mysqli_fetch_array($res))
        {
            $m['status']=true;
            $m['login']=$row['login'];
            $m['type']=$row['type'];
            $m['mail']=$row['mail'];
        }
        $dbh->close();
        return $m;
    }
    else
    {
        $dbh->close();
        return $m;
    }
    
}


function createlastlogin ($login,$passwd,$ip,$key,$idhash)
{
    global $host,$user,$pswd,$database,$port;
    $login_id = 0;
    $datetime = date('Y-m-d H:i:s');
    $dbh = mysqli_connect($host,$user,$pswd,$database,$port);
    $idcookie = $idhash;
    $idsession = $idhash;
    $query="SELECT id FROM `ul_user` WHERE ul_user.login = '$login' and ul_user.passwd='$passwd'";
    $res=mysqli_query($dbh,$query);
    mysqli_error($dbh);
    if($res)
    {   
        $row=mysqli_fetch_row($res); 
        $login_id = $row[0];
        $query="INSERT INTO ul_session(login_id,ip,lastlogin,hash_session,id_session) VALUES ('$login_id','$ip','$datetime','$key','$idsession')";
        $res=mysqli_query($dbh,$query);
    
            $query="INSERT INTO `ul_cookie`(login_id,ip,lastlogin,hash_cookie,id_cookie) VALUES ('$login_id','$ip','$datetime','$key','$idcookie')";
            $res=mysqli_query($dbh,$query);
            if($res==true)
            {
                
                return true;
            }
            else
            {
                return false;
            }
        
        
        
    }
    else{
        return false;
    }

    
    
}


function deletelastlogin($key_cookie,$key_session,$idhash){
    global $host,$user,$pswd,$database,$port;
    
    $dbh = mysqli_connect($host,$user,$pswd,$database,$port);
    if(isset($key_cookie)){
        $query = "DELETE FROM `ul_cookie` WHERE ul_cookie.hash_cookie='$key_cookie' and ul_cookie.id_cookie = '$idhash'";
        $res=mysqli_query($dbh,$query);
    }
    if(isset($key_session)){
        $query = "DELETE FROM `ul_session` WHERE ul_session.hash_session='$key_session' and ul_session.hash_session='$idhash'";
        $res=mysqli_query($dbh,$query);
    }
}

function createnewlogin($login,$hash,$mail){
    global $host,$user,$pswd,$database,$port;
    $dbh = mysqli_connect($host,$user,$pswd,$database,$port);
    $query="INSERT INTO `ul_user`(login,passwd,mail) VALUES ('$login','$hash','$mail')";
    $res = mysqli_query($dbh,$query);
    
    if($res==true)
    {
        $query="SELECT id FROM `ul_user` WHERE ul_user.login = '$login'";
        $res=mysqli_query($dbh,$query);
        if($res)
        {
            $row=mysqli_fetch_row($res);
            $login_id=$row[0];
            echo($login_id);
            $query="INSERT INTO `ul_user_access`(id_user,id_access) VALUES('$login_id','2')";
            $res=mysqli_query($dbh,$query);
            if($res){
                return true;
            }
            else{

            }
        }
    }
    else
    {
        return false;
    }    
}

function checklogin($login)
{
    $count = 0;
    global $host,$user,$pswd,$database,$port;
    
    $dbh = mysqli_connect($host,$user,$pswd,$database,$port);
    $query="SELECT * FROM `ul_user` where ul_user.login = '$login'";
    $res=mysqli_query($dbh,$query);
    if($res)
    {
        $count = mysqli_num_rows($res);
        if($count>0)
        {
            return true;
            $dbh->close();
        }
        else
        {
            $dbh->close();
            return false;
        }
    }
    else{
        $dbh->close();
        return false;
    }
}

function checkmail($mail)
{
    
    $count = 0;
    global $host,$user,$pswd,$database,$port;
    $dbh = mysqli_connect($host,$user,$pswd,$database,$port);
    $query="SELECT * FROM `ul_user` where ul_user.mail = '$mail'";
    $res=mysqli_query($dbh,$query);
    if($res)
    {
    $count = mysqli_num_rows($res);
    if($count>0)
    {
        
        return true;
        $dbh->close();
        
    }
    else
    {
        
        
        return false;
    }
    }
    else{
        $dbh->close();
        return false;
    }
}


function checkautorize_count($hash)
{
    global $host,$user,$pswd,$database,$port;
    $dbh = mysqli_connect($host,$user,$pswd,$database,$port);
    $query="SELECT * from `ul_cookie`
            where ul_cookie.hash_cookie = '$hash'";
    $result=mysqli_query($dbh,$query);
    return mysqli_num_rows($result);
}
?>