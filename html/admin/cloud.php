<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/dbconn.php");
    
    function get_array_files($id)
    {
        global $host,$user,$pswd,$database;
        $m = array("status"=>false,"arr"=>array("name"=>"","path"=>"","size"=>""));
        $dbh = mysqli_connect($host,$user,$pswd,$database);
        $query="SELECT name path size id FROM ul_file
        where ul_file.id_access = '$id'";
        $res=mysqli_query($dbh,$query);
        if($res)
        {
            while ($row=mysqli_fetch_row($res))
            {
                $code="";
                $code=crypt($row["id"], $id);
                $query="SELECT code from ul_download_table
                        where ul_download_table.code='"+$code+"'";
                $result = mysqli_query($dbh,$query);
                $rowdt=mysqli_fetch_row($result);

                if(!empty($rowdt["code"]))
                {
                    $m["status"]=true;
                    $m["arr"][]=array("name"=>$row["name"],"path"=>$row["path"],"size"=>$row["size"],"code"=>$rowdt["code"]);
                }
                else
                {
                    $query="INSERT INTO ul_download_table (id_file,code) Values ('"+$row["id"]+"', '"+$code+"')";
                    $result = mysqli_query($dbh,$query);
                    
                    $m["status"]=true;
                    $m["arr"][]=array("name"=>$row["name"],"path"=>$row["path"],"size"=>$row["size"],"code"=>$code);
                }
            }  
        }
        return $m;
    }
?>