<?php
require($_SERVER['DOCUMENT_ROOT']."/admin/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/admin/cloud.php");
$navi = $_SERVER['SERVER_NAME'];
if ($m['status']==true)
{
	$filename = '';
	$type = '';
	$size = '';
	$code = $m['id'];
	$files = get_array_files($m['id']);

	
}
else
{
	header('Location: /?access_denied=true');
}
?>
<head>

<title>Облако</title>
<script src="/admin/js/dropzone.js"></script>
<link href="/admin/css/dropzone.css" type="text/css" rel="stylesheet" />
</head>
<body>
	<div class='body'>
	<?php
	
		echo('<div class="navi"><a href="http://'.$navi.'"><i class="fa fa-home"></i>Главная</a> > <a href="http://'.$navi.'/cloud">Облако</a></div>');
	?>
		<p>
			<div class="headcommands">
				<div><a href="#addfiles">Добавить</a></div>
				<br/>
			</div>
			<div id=addfiles class="modalbackground">
				<div class="modalwindow">
					<?php
					echo('<form action="upload.php?code='.$code.'" class="dropzone"></form>');
					?>
					<a href=" ">Закрыть</a></div>
				</div>
			</div>
			<div class="cloud">
				<table class="table">
					<tr class="headtable">
						<td><div class="secondhead">file</div></td>
						<td><div class="thirdhead">type</div></td>
						<td><div class="fourthhead">size</div></td>
					</tr>
					<?php
						foreach ($files as $file)
						{

							/*
							echo('<td><div class="file">'+$filename+'</div></td>');
							echo('<td><div class="file">'+$type+'</div></td>');
							echo('<td><div class="file">'+$size+'</div></td>');
							
							if(!empty($code))
							{
								echo('<td><div class="file"><a href="download.php?code="'+
									$code+'><i class="fa fa-download"></i></a></div></td>');
							}
							*/
						}
					?>
				</table>
			</div>
	</div>
</body>