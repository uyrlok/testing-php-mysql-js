<?php
	include($_SERVER["DOCUMENT_ROOT"]."/admin/authphp/auth.php");
	
	global $host,$user,$pswd,$database;
	@$dbh = mysqli_connect($host,$user,$pswd,$database);
	if (!$dbh) {
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
		echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
		return 0;
	}
	else{
		if(isset($_SESSION["autorize"]))
		{
			if(isset($_SESSION["id"]))
			$m = getlastlogin_session($_SESSION["autorize"],$_SESSION["id"]);
		}
		else
		{
				if(isset($_COOKIE["autorize"]))
				{
					if(isset($_COOKIE["id"]))
					$m = getlastlogin_cookie($_COOKIE["autorize"],$_COOKIE["id"]);
				}
			
		}
	}
		?>
		<html>
		<head>
		<meta charset="UTF-8">
		<script type="text/javascript" src="/admin/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="/admin/js/script.js"></script>
		<link rel="stylesheet" href="/admin/css/style.css">
		<link rel="stylesheet" href="/admin/css/font-awesome.css" type="text/css">
		</head>
		<header>
				<?php
					if (isset($m)){
						
						if ($m['status']==true){
							$login = $m['login'];
							echo('<div class="auth">
								<a href="/auth/profile">'.$login.'</a>
								<a href="/auth/logout.php">Выход</a>
								</div>');
						}
						else{
							echo('<div class="auth">
								<a href="/auth/register">Регистрация</a>
								<a href="/auth"><i class="fa fa-"></i>Вход</a>
								</div>');
						}
					}
					else{
						echo('<div class="auth">
							<a href="/auth/register">Регистрация</a>
							<a href="/auth"><i class="fa fa-"></i>Вход</a>
							</div>');
					}
					
					?>
			<nav class="menu">
				<div>
				<ul>
					<li class="menu-item"><a href="/"><i class="fa fa-home"></i>Главная</a></li>
					<li class="menu-item"><a href="/books"><i class="fa fa-archive"></i>Справочные материалы</a>
					</li>
					<li class="menu-item"><a href="/disciplines.php"><i class="fa fa-book"></i>Предметы</a>
					<ul class="submenu">
							<li><a href="/CDTS">Системы кодирования и передачи данных</a></li>
							<li><a href="/DSPS">Системы цифровой обработки сигналов</a></li>
						</ul></li>			
					<li class="menu-item"><a href="/cloud"><i class="fa fa-cloud"></i>Облако</a></li>
				</ul>
				</div>
			</nav>
		</header>
