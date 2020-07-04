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
	
   <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
</head>
<?php 
require("authtest.php");
ob_start()
?>
<style>
.tab{
  font-size: 15px;	
}

</style>

<body>

<script type="text/javascript">
$(document).ready(function() {
   $("#tabs").tabs();
});
</script>


<div class="back_gray">
 <div style="position: absolute;">
  <a style="text-decoration: none; border: none; color: rgb(68,68,68); font-size: 15px; font-weight: bold; margin: 5px;" href="system.php"><img style="width: 35px; height: 35px;" src="/images/home.png"></img></a>
 </div>
<div style="margin-left:0px;" id="title">
 <center>Добро пожаловать в управление тестами,<span> <?php echo $_SESSION['name'].''?></span>!</center>
</div>
</div>
<div style="font-size: 12px; margin-top: 5px">
<center> <?php echo 'Дата: '.date('Y/m/d');?></center>
</div>

<?php

if ($_GET['success']==2) echo '
<center>
<div style="color: red; font-size: 13px;">
Вопрос был успешно удалён. 
</div>
</center>';

if ($_GET['success']==1) echo '
<center>
<div style="color: green; font-size: 13px;">
Настройки теста были успешно обновлены.
</div>
</center>';

if ($_GET['success']==3) echo '
<center>
<div style="color: green; font-size: 13px;">
Настройки содержимого были успешно обновлены.
</div>
</center>';

if ($_GET['success']==4) echo '
<center>
<div style="color: green; font-size: 13px;">
Новый вопрос был успешно добавлен.
</div>
</center>';

if ($_GET['success']==5) echo '
<center>
<div style="color: red; font-size: 13px;">
Тест был успешно удалён.
</div>
</center>';

if ($_GET['success']==6) echo '
<center>
<div style="color: red; font-size: 13px;">
Результат был успешно удалён.
</div>
</center>';

if ($_GET['success']==7) echo '
<center>
<div style="color: green; font-size: 13px;">
Файлы были успешно откреплены от вопроса.
</div>
</center>';

if ($_GET['error']==1) echo '
<center>
<div style="color: red; font-size: 13px;">
Тест с таким идентификатором не найден.
</div>
</center>';

if ($_GET['error']==7) echo '
<center>
<div style="color: red; font-size: 13px;">
Вы пытаетесь отредактировать тест чужого пользователя.
</div>
</center>';

?>



<?php 


$mysqli = new mysqli('localhost', '', '', ''); 
	if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                }
				
				$query = "SELECT created_by FROM tests WHERE id ='".$_GET['id']."' ORDER BY id DESC";	
					if ($result = $mysqli->query($query)) {																
                    while($row = $result->fetch_assoc()){
						
						 if ($row['created_by'] != $_SESSION['name'])
						 {
							   header("Location: management.php?error=7");	
													  return;
						 }							 
                      }
					     $result->close();
					}
				
				
				
	

	
	
	
	if (!isset($_GET['id'])){
		echo '<div id="manage_up">';
		
			if ($_GET['v']!=1)
echo '<a href="http://t-syst.techhost.wtf//management.php?v=1"><img style="width: 20px; height: 20px;" src="images/list.png"/></a>';
				if ($_GET['v']==1)
		echo '<a href="http://t-syst.techhost.wtf//management.php"><img style="width: 20px; height: 20px;" src="images/icons.jpg"/></a>';
	
	
				 echo ' <center><div style="font-size:14px; font-weight: bold;">Выберите один из <span style="color: red;">ваших</span> тестов:</div></center>';
	}
	
	
	


				 if (!isset($_GET['id'])){
				
					$query = "SELECT id,name,date_info FROM tests WHERE created_by ='".$_SESSION['name']."' ORDER BY id DESC";	
					if ($result = $mysqli->query($query)) {
						$found = $result -> num_rows;
						
						if ($_GET['v']!=1)
										 echo '<br> <ul>';
                    while($row = $result->fetch_assoc()){
						
							if ($_GET['v']!=1)
							echo '
	<a style="text-decoration: none; color: black;" href="management.php?id='.$row['id'].'">
        <li><b>'.$row['name'].' (#'.$row['id'].')</b> <br><br> <div style="font-size: 13px;">Дата создания: <b>'.$row['date_info'].'</b></div></li>
		</a>
	';			
						
						if ($_GET['v']==1)
                    echo '<a style="text-decoration: none; color: black;" href="management.php?id='.$row['id'].'"><div class="manage_up_element"> 
<table style="font-size: 13px;">
 <tr>
    <td>Название: <b>'.$row['name'].' (#'.$row['id'].')</b></td>
    <td><div style="margin-left: 10px;">Дата создания: <b>'.$row['date_info'].'</b></div></td>
 </tr>
</table>
</div></a>';				                
                      }
					  	if ($_GET['v']!=1)
					  			echo '</ul>';
					  
					  if ($found == 0)
						   echo '<center><div style="margin-top: 15px;">Ничего не найдено.</div></center>' ;
					  
					     $result->close();
				 }
				 
				 echo '</div>';
				 }
					
					
					if (isset($_GET['id']))
					{
						$query = "SELECT id,name,password, open, min_score, attempts, comment  FROM tests WHERE id ='".$_GET['id']."' ORDER BY id DESC";	
					if ($result = $mysqli->query($query)) {
						
												$rows = $result->num_rows;
												
												if ($rows == 0)
												{
													  header("Location: management.php?error=1");	
													  return;
												}
																
                    while($row = $result->fetch_assoc()){
						
						
                          $test_name = $row['name'];		
                          $test_password = $row['password'];		
                          $test_score = $row['min_score'];
                          $test_open = $row['open'];
                          $test_id = $row['id'];	
                          $test_attempts = $row['attempts'];		
                          $comment = $row['comment'];							  
                      }
					     $result->close();
					}	
					}
					
					
					if (isset($_POST['save_but1']))
					{
						  $open = 0;
						  if (isset($_POST['open_check'])) $open = 1;
                         $query = "UPDATE tests SET name = '".$_POST['test_name']."', password='".$_POST['test_password']."', min_score='".$_POST['test_min']."', open='".$open."', attempts='".$_POST['test_attempts']."', comment='".$_POST['test_commentary']."' WHERE ID = ".$test_id."";
						 $mysqli->query($query);
                         header("Location: management.php?success=1");						 
					}


					
		
  
  
  ?> 


<?php 
if (!isset($_GET['id'])){
$mysqli->close();
echo '</body> </html>';
exit;
}
?>
<div id ="manage_block">

<form method="post" enctype="multipart/form-data">
<div style="border-radius: 5px" class="test_question_edit">
<div style="margin-left: 3px; font-weight: bold;">Прикрепить к вопросу</div>
<table>
<tr>
<td>
<input required style="width: 105px;  padding: 4px;" name="attach_number" type="text" placeholder="Номер вопроса">
</td>
<td>
<div style="margin-left: 10px;width: 100px;">
<select style="padding: 4px;" name="select">
    <option value=1>Картинка</option>
    <option value=2>Звук</option>
   </select>
 </div> 
</td>
<td> 


<input type="file" name="uploadfile">
<input type="submit" name="upload_b" value="Загрузить"></form>
</td>
</tr>
</table>

<?php 

if (isset($_POST['upload_b']))
{
	
	
	
	     $question_ids2 = Array();
					$query = "SELECT id,question,answer,score FROM questions WHERE test_id ='".$test_id."' ORDER BY id";	
					if ($result = $mysqli->query($query)) {
						$count=0;
                    while($row = $result->fetch_assoc()){ 
                            array_push($question_ids2, $row['id']);
                      }
					     $result->close();
					}
	$q_id = $_POST['attach_number'];
	
	if ($q_id>count($question_ids2) || $q_id <=0)
	{
		echo("<center>Такой вопрос не найден в тесте.</center>");
		;	
		return;
	}
	
	$attach_id = $_POST['attach_number'];
	if ($q_id == '') $q_id = 1;
	$q_id = $question_ids2[$q_id-1];
	
	  if($_FILES["uploadfile"]["size"] > 1024*2*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   }
   $forb = true;
    $whitelist = array(".jpg",".jpeg",".mp3");
 foreach ($whitelist as $item) {
  if(preg_match("/$item\$/i", $_FILES['uploadfile']['name'])) {
    $forb = false;
   }
   
   if ($forb)
   {
	   echo '<center>Вы не можете загружать такие файлы.</center>';
	   exit;
   }
   
  }
   $file = $_FILES['uploadfile']['name'];
   $fdata = pathinfo($file);
   $ext = $fdata['extension']; 
   $filename = $fdata['filename']; 
   $newname = $q_id. '.' . $ext;
   if ($_POST['select'] ==  1)
   $uploaddir = './res/images/';
   if ($_POST['select'] == 2)
   $uploaddir = './res/sounds/';
   $uploadfile = $uploaddir.basename($newname);
   
   if(copy($_FILES["uploadfile"]["tmp_name"],
     $uploadfile))
   {
     echo("<center>Файл успешно добавлен к вопросу №".$attach_id.".</center>");
	 
	    if ($_POST['select'] ==  1){
       $query = "UPDATE questions SET image='".$newname."' WHERE ID = ".$q_id."";
						 $mysqli->query($query);
		}
			    if ($_POST['select'] ==  2){
       $query = "UPDATE questions SET sounds='".$newname."' WHERE ID = ".$q_id."";
						 $mysqli->query($query);
				}
   } else {
      echo("<center>Ошибка загрузки файла.</center>");
   }	
   
   
   
   
}

?>
</div>


<form method="post">
<div style="font-size: 21px;"><center>Тест "<b><?php echo $test_name.' (#'.$test_id.')'?></b>" </center></div>
<div style="margin-top: 10px; border: none;" id="tabs">
<ul style="font-size: 14px; color: black; text-decoration: none; cursor: pointer;">
<li><a href="#tabs-1">Настройки</a></li>
<li><a href="#tabs-2">Редактировать содержимое</a></li>
<li><a href="#tabs-3">+ Добавить вопрос</a></li>
<li><a href="#tabs-4">Управление</a></li>
<li><a href="#tabs-5">Отслеживание</a></li>
</ul>
<div class ="tab" id="tabs-1">
<p>
<table>
 <tr>
   <td>
    Название теста: 
   </td>
   <td>
   <?php echo '   <input style="width: 150px; padding: 5px;" name="test_name" type="text" value="'.$test_name.'" placeholder="'.$test_name.'">'?>
   </td>
 </tr>
  <tr>
   <td>
    Пароль: 
   </td>
   <td>
   <?php echo '   <input style="width: 150px; padding: 5px;" name="test_password" type="password" value="'.$test_password.'">'?>
   </td>
 </tr>
   <tr>
   <td>
    Минимальный бал: 
   </td>
   <td>
   <?php echo '   <input style="width: 150px; padding: 5px;" name="test_min" type="text" value="'.$test_score.'">'?>
   </td>
 </tr>
 
  
   <tr>
   <td>
    <span class="tooltiptext" data-tooltip="Установить количество попыток для прохождения теста. Введите '-1', чтобы убрать ограничение.">Попытки:</span> 
   </td>
   <td>
      <?php echo '   <input style="width: 150px; padding: 5px;" name="test_attempts" type="text" value="'.$test_attempts.'">'?>
   </td>
 </tr>
 
  <tr>
   <td>
    <span class="tooltiptext" data-tooltip="Отображать пользователям по завершении теста номера вопросов, в которых они ошиблись.">Открытый:</span> 
   </td>
   <td>
<?php
     if ($test_open == 1)
   echo '   <input name="open_check" type="checkbox" checked>';
  else echo '<input name="open_check" type="checkbox">';
?>
   </td>
 </tr>
 
 
    <tr>
   <td>
    <span class="tooltiptext" data-tooltip="Оставить комментарий, который будет отображён выше вопросов теста.">Комментарий:</span> 
   </td>
   <td>
   

      <?php echo '<textarea name="test_commentary" style="resize:none; width: 600px; height: 70px;">'.$comment.'</textarea>'?>
   </td>
 </tr>

 
</table>
</p>
<br><br>
 <center><input type="submit" class="menu_button" name="save_but1" value="Сохранить"></center>
</div>
<div class ="tab" id="tabs-2">
<p>
<?php 
                    $question_ids = Array();
					$questions_with_files = Array();
					$query = "SELECT id,question,answer,score,image,sounds FROM questions WHERE test_id ='".$test_id."' ORDER BY id";	
					if ($result = $mysqli->query($query)) {
						$count=0;
                    while($row = $result->fetch_assoc()){ 
$count++;					
					$quests_special = htmlspecialchars($row['question'], ENT_QUOTES);
					
					$d_files = '';
					if (($row['image'] != '') || ($row['sounds'] != ''))
					{
						$d_files = '<td> <div style="margin-left: 5px;">
<input type="submit" class="button" name="del_files_'.$row['id'].'" value="Открепить файлы"> </div>
</td>';
 array_push($questions_with_files, $row['id']);
					}
					
						  echo '<div style="border-radius: 5px" class="test_question_edit">
<div style="margin-left: 3px; font-weight: bold;">Вопрос №'.$count.'</div>
<textarea name="question_'.$row['id'].'" style="resize:none; width: 695px; height: 80px;">'.$quests_special.'</textarea>

<table style="margin-top: 10px;"><tr>
<td>
<input style="width: 135px;  padding: 4px;" name="answer_'.$row['id'].'" required type="text" value="'.$row['answer'].'" placeholder="'.$row['answer'].'">
</td>
<td> <div style="margin-left: 5px;">
<input type="submit" class="button" name="delete_'.$row['id'].'" value="Удалить вопрос"> </div>
</td>

'.$d_files.'

<td> <div style="margin-left: 5px;">
<input type="text" style="padding: 4px; width: 40px;" name="score_'.$row['id'].'" placeholder="Балл" value="'.$row['score'].'"> </div>
</td>

</tr>
</table>
</div>'	
;

  array_push($question_ids, $row['id']);
                      }
					     $result->close();
					}				
					foreach ($question_ids as $value) {
if (isset($_POST['delete_'.$value]))
						{
							$query = "DELETE FROM questions WHERE id = '".$value."'";
							$mysqli->query($query);
							header("Location: management.php?id=".$test_id."&success=2");		
							$mysqli -> close();
						}
}


foreach ($questions_with_files as $value) {
if (isset($_POST['del_files_'.$value]))
						{
						   $query = "UPDATE questions SET image = '', sounds='' WHERE ID = ".$value."";
						 $mysqli->query($query);
							header("Location: management.php?id=".$test_id."&success=7");		
							$mysqli -> close();
						}
}


if (isset($_POST['save_but2']))					{
foreach ($question_ids as $value) {
                         $query = "UPDATE questions SET question = '".$_POST['question_'.$value]."', answer='".$_POST['answer_'.$value]."', score='".$_POST['score_'.$value]."' WHERE ID = ".$value."";
						 $mysqli->query($query);
                         header("Location: management.php?success=3");		
}						 
					}					
?>
</p>
 <center><input type="submit" class="menu_button" name="save_but2" value="Сохранить"></center>
</div>
<div class ="tab" id="tabs-3">


<p>
<div style="border-radius: 5px" class="test_question_edit">
<div style="margin-left: 3px; font-weight: bold;">Новый вопрос</div>
<textarea name="new_question_text" style="resize:none; width: 670px; height: 80px;"></textarea>
<table style="margin-top: 10px;"><tr>
<td>
<input style="width: 135px;  padding: 4px;" name="new_question_answer" type="text" placeholder="Ответ">
</td>
<td>
</tr>
</table>
</div>
<?php 
if (isset($_POST['add_question'])){
if ($result = $mysqli->query('SELECT id FROM questions ORDER BY id DESC LIMIT 1')) {	
	                    while($row = $result->fetch_assoc()){
							 $question_id = $row['id']+1;
						}
               $result->close();
                }
	  $query = "INSERT INTO questions VALUES (".$question_id.",1,'".$_POST['new_question_text']."','".$_POST['new_question_answer']."','".$_COOKIE['name']."','".$test_id."',1,'','')";
      $mysqli->query($query);	
			         header("Location: management.php?id=".$test_id."&success=4");	
}		
?>
 <center><input type="submit" class="menu_button" name="add_question" value="Добавить вопрос"></center>
</p>


</div>
<div class ="tab" id="tabs-4">
<p>
<?php 
if (isset($_POST['delete_test']))
{
	                    {
							$query = "DELETE FROM tests WHERE id = '".$test_id."'";
							$mysqli->query($query);
							$query = "DELETE FROM results WHERE test_id = '".$test_id."'";
							$mysqli->query($query);
							$query = "DELETE FROM questions WHERE test_id = '".$value."'";
							$mysqli->query($query);
							header("Location: management.php?success=5");		
							$mysqli -> close();
						}
}

?>
<center><input type="submit" class="menu_button" name="delete_test" value="Удалить тест"></center>
</p>
</div>
<div class ="tab" id="tabs-5">
<p>
<?php 
$results_ids = Array();
	$query = "SELECT id,user_name, score, date, passed  FROM results WHERE test_id ='".$test_id."' ORDER BY id DESC";	
					if ($result = $mysqli->query($query)) {
						
						if ($result->num_rows == 0) echo '<center>Ничего не найдено.</center>';
						
                    while($row = $result->fetch_assoc()){                 
  				                      array_push($results_ids, $row['id']);
					    if ($row['passed'] == 1)
					  echo '<div class="manage_up_element_res"> 
<table style="font-size: 13px;">
 <tr>
    <td>✔ Пользователь: <b>'.$row['user_name'].'</b></td>
    <td><div style="margin-left: 10px;">Баллы: <b>'.$row['score'].'</b></div></td>
	<td><div style="margin-left: 10px;">Дата: <b>'.$row['date'].'</b></div></td>
	<td><div style="margin-left: 10px;"><input type="submit" class="button" name="delete_result_'.$row['id'].'" value="Удалить результат"> </div></td>
 </tr>
</table>
</div>';
 else echo '<div class="manage_up_element_res"> 
<table style="font-size: 13px;">
 <tr>
    <td>✖ Пользователь: <b>'.$row['user_name'].'</b></td>
    <td><div style="margin-left: 10px;">Баллы: <b>'.$row['score'].'</b></div></td>
	  <td><div style="margin-left: 10px;">Дата: <b>'.$row['date'].'</b></div></td>
	   <td><div style="margin-left: 10px;"><input type="submit" class="button" name="delete_result_'.$row['id'].'" value="Удалить результат"> </div></td>
 </tr>
</table>
</div>' ;
					  
					  
					  
					  }
					     $result->close();
					}

foreach ($results_ids as $value) {
if (isset($_POST['delete_result_'.$value]))
						{
							$query = "DELETE FROM results WHERE id = '".$value."'";
							$mysqli->query($query);
							header("Location: management.php?id=".$test_id."&success=6");		
							$mysqli -> close();
						}
}

					
?>
</p>
</div>
 </div>
 </form>
</div>


	
	
	
</body>

<?php 
	$mysqli->close();
?>

</html>