<!DOCTYPE html>
<html>
<?php
ob_start();
?>
<head>

	<title>Тестирующая система</title>
	<meta charset="utf-8">
	<meta name="keywords" content="">
	<meta name="deskription" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="shortcut icon" href="/images/favicon.ico" type="image/png">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	
<?php 
require("authtest.php");

	$mysqli = new mysqli('localhost', '', '', '');  
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                }
				
				
				
			$query = "SELECT id, name, quest, created_by FROM qtests WHERE id ='".$_GET['id']."' ORDER BY id DESC";	
					if ($result = $mysqli->query($query)) {																
                    while($row = $result->fetch_assoc()){
						    $q_id = $row['id'];
							$q_name = $row['name'];
							$q_text = $row['quest'];
							$q_created_by = $row['created_by'];									 
                      }
					     $result->close();
					}		



/*
$array = array( 1, 2, 3 );
	$string = serialize( $array );
	echo $string;
	$array = unserialize($string);
	print_r ($array);
*/



if ($_POST['save'])
{
						  if (isset($_POST['inp_name'])){
                         $query = "UPDATE qtests SET name = '".$_POST['inp_name']."' WHERE ID = ".$q_id."";
						 $mysqli->query($query);	
						  }		

	  if (isset($_POST['inp_text'])){
                         $query = "UPDATE qtests SET quest = '".$_POST['inp_text']."' WHERE ID = ".$q_id."";
						 $mysqli->query($query);	
						  }		

   header("Location: qmanage.php?id=".$q_id);							  
}






?>
	
</head>



<body>




<div class="back_gray">
 <div style="position: absolute;">
 <a style="text-decoration: none; border: none; color: rgb(68,68,68); font-size: 15px; font-weight: bold; margin: 5px;" href="system.php"><img style="width: 35px; height: 35px;" src="/images/home.png"></a>
 </div>
<div style="margin-left: 1px;"id="title">
 <center>Добро пожаловать в управление заданиями,<span> <?php echo $_SESSION['name']?></span>!</center>
</div>
</div>
<div style="font-size: 12px; margin-top: 5px">
<center> <?php echo 'Дата: '.date('Y/m/d');?></center>
</div>


<form method="post">



<div class="create_block">
<center> 
<div style="font-size: 17px; font-weight: bold">Управление заданием</div>
<div style="font-size: 13px;"><?php echo ''.$q_name.'(#'.$q_id.')'?></div>
</center>
</div>


<div class="create_block">
<center> 
<div style="font-size: 15px; font-weight: bold">Настройки:</div>
</center>


<table>
  <tr>
  
     <td>
	 Название:
	 </td>
	 
	 <td>
	 <div style="margin-top: 10px; margin-left: 5px;">
	<?php echo' <input style="width: 150px; padding: 5px;" name="inp_name" type="text" value="'.$q_name.'">'?>
	 </div>
	 </td>
  
  </tr>
  
  
  <tr>
     <td>
	<div style="margin-top: -33px;"> Текст задания:</div>
	 </td>
	 
	 <td>
	 <div style="margin-top: 10px; margin-left: 5px;">
	<?php echo'  <textarea name="inp_text" style="resize:none; width: 600px; height: 70px; padding: 5px;">'.$q_text.'</textarea>'?>
	 </div>
	 </td>
  
  </tr>


</table>

<center>
<input style="margin-top: 10px; "type="submit" class="menu_button" name="save" value="Сохранить"> </centeR>

</div>


<div class="create_block">
<center> 
<div style="font-size: 17px; font-weight: bold">Проверка заданий</div>
</center>

<!-- <div class="manage_up_element_res" style="padding: 10px;"> 
Выполнено: <b>*имя*</b><br>
<div style="color: gray;">Статус: Не проверено.</div>
<br>
<b>Текст:</b> Текст текст текст. Текст текст текст. Текст текст текст. Текст текст текст.Текст текст текст.Текст текст текст.Текст текст текст.
<br><br>
<textarea name="verd_" style="resize:none; width: 600px; height: 70px; padding: 5px;" placeholder="Напишите ваш вердикт здесь."></textarea>
<center><input type="submit" class="button" name="check_" value="Отметить как проверенное" style="margin-top: 10px;"></center>
</div> -->


<?php 
			
			$query = "SELECT id,answer, checked, commentary, written_by FROM quests_data WHERE quest_id =".$_GET['id']." ORDER BY checked DESC";	
					if ($result = $mysqli->query($query)) {																
                    while($row = $result->fetch_assoc()){
						$c = $c+1;
						    						
						 echo '
							 
							 <div class="manage_up_element_res" style="padding: 10px;"> 
Выполнено: <b>'.$row['written_by'].'</b><br>';

if ($row['checked'] == 0) echo
'<div style="color: gray;">Статус: Не проверено.</div>';
if ($row['checked'] == 1) echo
'<div style="color: green;">Статус: Проверено.</div>';

echo '<br>
<b>Ответ:</b> '.$row['answer'].'
<br><br>
<textarea name="verd_'.$row['id'].'" style="resize:none; width: 600px; height: 70px; padding: 5px;" placeholder="Напишите ваш вердикт здесь.">'.$row['commentary'].'</textarea>

<center>
<table>
<tr>
<td>
<input type="submit" class="button" name="check_'.$row['id'].'" value="Обновить/проверить" style="margin-top: 10px;">
<td>

<td>
<input type="submit" class="button" name="cancel_check_'.$row['id'].'" value="Отменить проверку" style="margin-top: 10px;">
</td>
</tr>
</table>
</center>

</div>
							 
							 
							 ';


if (isset($_POST['check_'.$row['id']]))
{
		  if (isset($_POST['verd_'.$row['id']])){
                         $query = "UPDATE quests_data SET commentary = '".$_POST['verd_'.$row['id']]."' WHERE ID = ".$row['id']."";
						 $mysqli->query($query);	
						  }		
			      
				  $query = "UPDATE quests_data SET checked = 1, checked_by ='".$_SESSION['name']."' WHERE ID = ".$row['id']."";
						 $mysqli->query($query);	
						
   header("Location: qmanage.php?id=".$q_id);	
	
}		

if (isset($_POST['cancel_check_'.$row['id']]))
{
			      
				  $query = "UPDATE quests_data SET checked = 0, checked_by ='***', commentary = '***' WHERE ID = ".$row['id']."";
						 $mysqli->query($query);	
						
   header("Location: qmanage.php?id=".$q_id);	
	
}	


                      }
					     $result->close();
				}	

if ($c == 0)
{
	echo '<center><div style="margin-top: 10px;">Доступные для проверки задания не найдены.</div></center>';
	
}
				
?>




</div>




</form>

<div style="height: 30px;"></div>
</body>
</html>