<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/dbconn.php");

if($_GET["code"])
{
    //Получить путь реальный путь до файла
    $dbh = mysqli_connect($host,$user,$pswd,$database);
    $query="SELECT path FROM `ul_file`
        inner join `ul_download_table` on ul_download_table.id_file = ul_file.id
        where ul_download_table.code = '$code'";
    
    $res=mysqli_query($dbh,$query);
    if($res)
    {
        $row=mysqli_fetch_row($res);
        $path=$row["path"];
        readfile($path);
    }
}
else
{
    location('Location: ..?file_denied=true');
}
?>