<?php
    require_once("/var/www/html/admin/dbconn.php");
    if(isset($user_id))
    {
        $filename = "tests_".$user_id.".php";
        $cron = "/etc/crontab";
        global $host,$user,$pswd,$database,$port;
        $var="";$status="";
        $dbh=mysqli_connect($host,$user,$pswd,$database,$port);
        if(!$dbh)
        {
            delete_from_cron($cron,$filename);
            create_failed($user_id);
        }
        else
        {
            
            
            $query_select="SELECT user_id from ul_code_status where ul_code_status.user_id = '$user_id'";
            
            for($i=0;$i<100000;$i++)
            {
                try
                {
                    if($i % 10000 == 0)
                    {
                        $select = mysqli_query($dbh,$query_select);
                        //echo(mysqli_num_rows($select));
                        if(mysqli_num_rows($select)>0)
                        {
                            //echo("111");
                            
                            $k=$i/1000;
                            $status=(string)$k."%";
                            $query_update="UPDATE `ul_code_status` 
                           SET status='$status' 
                           WHERE ul_code_status.user_id = '$user_id'";
                            $res=mysqli_query($dbh,$query_update);
                        }
                        else
                        {
                            //echo("222");
                            $k=$i/1000;
                            $status=(string)$k."%";
                            $query_insert="INSERT into ul_code_status(user_id,status) Values ('$user_id','$status')";
                            $res=mysqli_query($dbh,$query_insert);
                        }
                    }
                    $var=$i;
                    $query1="INSERT into table_test(var) Values ('$var')";
                    $res=mysqli_query($dbh,$query1);
                }
                catch(exception $e){
                    $status="failed";
                    $res=mysqli_query($dbh,$query_update);
                }
            }
            $status="success";
            $query_update="UPDATE `ul_code_status` 
                           SET status='$status' 
                           WHERE ul_code_status.user_id = '$user_id'";
            $res=mysqli_query($dbh,$query_update);
            //delete_from_cron($cron,$filename);
        }

    }
    

    function create_failed($user_id)
    {
        $text = gmdate('Y-m-d h:i:s \G\M\T', time())." ".$user_id." failed";
        file_put_contents("/var/www/html/uyrlok.log",$text,FILE_APPEND);
    }
?>