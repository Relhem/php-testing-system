<!DOCTYPE html>
<html>
<head>
	<title>Тестирующая система</title>
	<meta charset="utf-8">
	<meta name="keywords" content="">
	<meta name="deskription" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="shortcut icon" href="/images/favicon.ico" type="image/png">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php 
require("authtest.php");
include("crypt.php");
?>



<div class="back_gray">
 <div style="position: absolute;">
 <a style="text-decoration: none; border: none; color: rgb(68,68,68); font-size: 15px; font-weight: bold; margin: 5px;" href="system.php"><img style="width: 35px; height: 35px;" src="/images/home.png"></a>
 </div>
<div style="margin-left:0px;" id="title">
 <center>Добро пожаловать в систему тестирования,<span> <?php 

 echo $_SESSION['name'].''?></span>!</center>
</div>
</div>
<div style="font-size: 12px; margin-top: 5px">
<center> <?php echo 'Дата: '.date('Y/m/d');?></center>
</div>

<div id = "results_block">
 <center><div style="font-size: 16px; font-weight: bold;">Поздравляем! Тест <?php 
 if (isset($_GET['n']))
 echo '"'.hexToStr($_GET['n']).'"'?> завершён.</div></center>
 
 <center>
 <table style="font-size: 12px; margin-top: 10px;">
   <tr>
   <td>
	  Баллов получено: <?php echo $_GET['got'].'/'.$_GET['out'];?>
   </td>
   </tr>
    <tr>
   <td>
	  Процент выполнения: <?php echo number_format($_GET['got']/$_GET['out']*100).'%';?>
   </td>
   </tr>
   
   	<tr>
	<td>
	  Дата прохождения: <?php echo date('Y/m/d')?>
	</td>
	</tr>
		<tr>
		
		<?php 
		  if ($_GET['passed'] == 1)
		  
			  echo '<td style="color: green;">
	  Минимальный порог пройден.
	</td>';
		   else
		  
			echo ' <td style="color: red;">
	  Минимальный порог не пройден.
	</td>';
	
		  
		
		?>
	</tr>
	
	  	<tr>
	<td>
	  <?php 
	  
	  $mistakes_str = hexToStr($_GET['mistakes']);
	  $mistakes_unser = unserialize($mistakes_str);
	  
	  if (count($mistakes_unser)>0)
	  echo 'Вы допустили ошибки в номерах: ';
	  foreach ($mistakes_unser as $value) {
echo '№'.$value.' ';
}
	  ?>
	</td>
	</tr>
	
	
	
 </table>
 
 <a style="text-decoration: none;" href="system.php"><input style="margin-top: 10px;" type="submit" class="button" name="log_button" value="Вернуться"></a>
</center> 

</div>
	
</body>
</html>