<!DOCTYPE html>
<html>
<head>
	<title>Тестирующая система</title>
	<meta charset="utf-8">
	<meta name="keywords" content="">
	<meta name="deskription" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>



<div class="back_gray">
<div style="margin-left:0px;" id="title">
 <center>Добро пожаловать в "Мастер тестов",<span> <?php echo $_COOKIE['name']?></span>!</center>
</div>
</div>
<div style="font-size: 12px; margin-top: 5px">
<center> Понедельник 10.10.2016 - 16:03  </center>
</div>


<form method="post">
<div id="basics_block"> 
  <center><span>Основные настройки:</span></center>
  <div style="height: 10px"></div>
<table>
<tr>
<td>Количество вопросов: </td>
	  <td><input name="q" type="text" placeholder="Количество"></td>
</tr>
<tr>
<td>Минимальный бал: </td>
	  <td><input name="m" type="text" placeholder="Минимальный бал"></td>
</tr>
</table>
<center><input style="padding-left: 20px; padding-right: 20px; margin-top:10px"type="submit" class="button" name="next" value="Далее"></center>
</div>


<?php 
if (isset($_POST['next']))
{
  header("Location: master.php?q=".$_POST['q']."?m=".$_POST['m']);
}
?>



	
</body>
</html>