<?php
if(isset($_POST['id']))
{
        
        $id = $_POST['id'];
        if(isset($_POST['status']))
        {
            if($_POST['status']=="start")
            {
            $filename = $_POST['filename'];
            //$test=kurlyk;
            $str="<?php \n".'$user_id="'.$id.'";'."\n?>";
            $file = fopen($_SERVER["DOCUMENT_ROOT"].$filename,'r');
            while(!feof($file))
            {
                $str .= fgets($file);
            }
            fclose($file);
            file_put_contents("tests_".$id.".php",$str);

            include("tests_".$id.".php");

            ////реализовать создание и обработку на кроне
            //$text = "*/1 * * * * root php -f /var/www/html/auth/profile/tests_".$id.".php";
            //file_put_contents("/etc/crontab",$text,FILE_APPEND);
            exit(json_encode());
            //require($_SERVER["DOCUMENT_ROOT"]."/auth/profile/"."tests_".$id.".php");
            //include($_SERVER["DOCUMENT_ROOT"]."/test/changetests.php");
            }
            
        }
}
?>