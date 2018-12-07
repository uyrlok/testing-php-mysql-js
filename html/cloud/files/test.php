
<?php
	$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
	chdir($path_parts['dirname']);
	require_once 'auto_config.php';
	
	require_once 'auto_update.php';
	
	$file_logs = '/var/log/automatic-update-vikon.txt';
	$time = date(DATE_ATOM,time());
			
            $error = '';
            $currentVersion = file_get_contents('cur_version.php');
            $data = get_remote_data($apiDomen.'update/version?key='.$authKey.'&d='.$domenName);
            $connected = false;
            if ($data->success) 
			{
				
                $serverVersion = $data->info->version;
                $connected = true;
				
				if ($currentVersion == $serverVersion) //если серверная версия = клиентская
				{	
					
					$message = $time . "Нет новых версий. Текущая версия: " . $currentVersion . "\n";
					file_put_contents($file_logs,$message,FILE_APPEND);
				}
				else
				{					
					if (empty($serverVersion) == true) //если серверная версия не получена
					{
						$message = $time . "Нет новых версий. Текущая версия: " . $currentVersion . "\n";
						file_put_contents($file_logs,$message,FILE_APPEND);
					}
					else //выполняем процесс обновления
					{	
						
						$res = update($apiDomen,$authKey,$domenName);
						
						$message = $time . $res['message']. "\n";
						
						echo $res['success'];
						//file_put_contents($file_logs,$message,FILE_APPEND);
					}
				}
			}
			else
			{
				$message = "\n". $time . "Не удалось подключиться к серверу." . "\n";
				echo "Не удалось подключиться к серверу.\n"; 
				file_put_contents($file_logs,$message,FILE_APPEND);
			}
?>