<?php
$ds = DIRECTORY_SEPARATOR;
$code= $_GET["code"]; 
$storeFolder = 'files'; // Указываем папку для загрузки
 
if (!empty($_FILES)) { // Проверяем пришли ли файлы от клиента
    
    $tempFile = $_FILES['file']['tmp_name']; //Получаем загруженные файлы из временного хранилища
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds . $code . $ds;
    mkdir($targetPath);
    $targetFile =  $targetPath. $_FILES['file']['name'];
 
    move_uploaded_file($tempFile,$targetFile); // Перемещаем загруженные файлы из временного хранилища в нашу папку uploads
}
?>