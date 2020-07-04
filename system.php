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
	<meta name="viewport" content="width=900">
	
	<style>
	  .sendsubmit {
width:  25px;  // длина кнопки
height: 25px; // высота кнопки
margin: 0;
padding:0;
border: 0;
background: url('images/exit.png') no-repeat center top;
background-size: 20px;
text-indent: -1000em;
cursor: pointer;
}
	</style>
	
</head>
<body>



<div class="back_gray">
 <div style="position: absolute;">
 <form method="post">
 <input type="submit" style="height: 30px;" class="sendsubmit" name="exit_b"/>
 </form>
 </div>
<div style="margin-left:0px; padding-top: 10px;" id="title">
<?php 
        
		require("authtest.php");
		echo ' <center>Добро пожаловать в систему тестирования,<span> '.$_SESSION['name'].'</span>!</center>';
?>
</div>

</div>
<div style="font-size: 12px; margin-top: 5px">
<center> <?php echo 'Дата: '.date('Y/m/d');?></center>
<center> <?php 
$pr = rand(1,5);

if ($pr == 1) echo '<div style="color: rgb(214,86,43);">Совет: Заметив ошибку в тесте, вы можете отредактировать его в разделе "Управление тестами".</div>';
if ($pr == 2) echo '<div style="color: rgb(214,86,43);">Совет: Тест, созданный без пароля, доступен всем.</div>';
if ($pr == 3) echo '<div style="color: rgb(214,86,43);">Совет: В разделе "Мои результаты" отображаются только последние 15 тестов.</div>';
if ($pr == 4) echo '<div style="color: rgb(214,86,43);">Совет: "Мастер тестов" поможет вам создать основу для теста.</div>';
if ($pr == 5) echo '<div style="color: rgb(214,86,43);">Совет: Выполнив открытый тест, вы увидите список номеров вопросов, в которых ошиблись.</div>';
?></center>
</div>

 <?php 
  if (isset($_POST['exit_b']))
  {
	  session_destroy();
	  header("Location: index.php");
  }
 ?>


<?php

if ($_GET['success']==1) echo '
<center>
<div style="color: green; font-size: 13px;">
Вы успешно зарегистрировались на сайте. Пожалуйста, запомните свой пароль. 
</div>
</center>';

if ($_GET['success']==2) echo '
<center>
<div style="color: green; font-size: 13px;">
Вы только что создали новый тест. Перейдите в раздел "Управление тестами", чтобы отредактировать его. 
</div>
</center>';

if ($_GET['success']==3) echo '
<center>
<div style="color: green; font-size: 13px;">
Вы только что создали новое задание. Перейдите в раздел "Управление заданиями", чтобы отредактировать его. 
</div>
</center>';

if ($_GET['success']==4) echo '
<center>
<div style="color: green; font-size: 13px;">
Вы отправили задание на проверку. Вы сможете узнать об итогах проверки в разделе "Мои результаты". 
</div>
</center>';


?>




<div id="menu">
<table >
    <tr>
	  <td> <a href="list.php"><button class="menu_button">Пройти тест</button> </a></td>
  </tr>
     <tr>
	  <td> <a href="qlist.php"><button class="menu_button">Пройти задание</button> </a></td>
  </tr>
  
  
  <tr>
	  <td> <div style="margin-top: 10px;">
	  
	  <a href="myresults.php"><button class="menu_button">Мои результаты</button></a> <div></td>
	  </tr>
	  <tr>
	  <td> <a href="lc.php"><button class="menu_button">Личный кабинет</button></a></td>
  </tr>
	  
	  
	   <tr>
	  <td>
	  <div style="margin-top: 10px;">
	  <a href="master.php"> <button class="menu_button">Мастер тестов</button> </a>
	  </div>
	  </td>
  </tr>
  
  
   <tr>
	  <td>
	  <a href="qcreate.php"> <button class="menu_button">Создать задание</button> </a>
	  </div>
	  </td>
  </tr>
  

     <tr>
	  <td> <a href="management.php"><button class="menu_button" style="margin-top: 10px;">Управление тестами</button></a> </td>
  </tr>
  
    <tr>
	  <td> <a href="qmlist.php"><button class="menu_button">Управление заданиями</button></a> </td>
  </tr>
  
</table>
</div>

	

	
</body>

</html>