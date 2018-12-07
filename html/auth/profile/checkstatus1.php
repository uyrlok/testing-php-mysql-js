<?php
if(isset($_POST['id']))
{
    $id = $_POST['id'];
    if(isset($_POST['status']))
    {
        if($_POST['status']=="start")
        {
            include($_SERVER["DOCUMENT_ROOT"]."/admin/dbconn.php");
            $row = "";
            global $host,$user,$pswd,$database,$port;
            $dbh = mysqli_connect($host,$user,$pswd,$database,$port);
            $query = "SELECT status from `ul_code_status` where ul_code_status.user_id = '$id'";
            $res = mysqli_query($dbh,$query);
            if($res)
            {
                $row = mysqli_fetch_row($res);
                if($row=="success")
                {
                    unlink($_SERVER["DOCUMENT_ROOT"]."tests_".$id.".php");
                }
                exit(json_encode(array('status'=>$row)));
            }
        }
    }
}
        ?>