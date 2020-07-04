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
?>



<div class="back_gray">
 <div style="position: absolute;">
 <a style="text-decoration: none; border: none; color: rgb(68,68,68); font-size: 15px; font-weight: bold; margin: 5px;" href="system.php"><img style="width: 35px; height: 35px;" src="/images/home.png"></img></a>
 </div>
<div style="margin-left:0px;" id="title">
 <center>Добро пожаловать в систему тестирования,<span> <?php echo $_SESSION['name'].''?></span>!</center>
</div>
</div>
<div style="font-size: 12px; margin-top: 5px">
<center> <?php echo 'Дата: '.date('Y/m/d');?></center>
</div>


<div id="myresults_up_block">
<center> <div style="font-weight: bold; font-size: 16px;">Мои результаты</div></center>
<center> <div style="font-weight: bold; font-size: 12px;">(15 последних пройденных тестов)</div></center>
</div>

<div id="myresults_block">


<?php 

	$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                }

				
					$query = "SELECT quest_id,checked,commentary,checked_by FROM quests_data WHERE written_by='".$_SESSION['name']."' ORDER BY checked DESC LIMIT 15";	
									
					$found_bool = false;
					if ($result = $mysqli->query($query)) {
						$found = $result -> num_rows;
						if ($found>0) $found_bool = true;
                    while($row = $result->fetch_assoc()){			     

	echo '<div class="result_element">';
					if ($row['checked'] == 1) {echo'
<div style="margin-left: 10px; font-weight: bold; color: green;">✔ Задание: #'.$row['quest_id'].' (Проверено)</div>';
					}

                    if ($row['checked'] == 0) echo '<div style="margin-left: 10px; font-weight: bold; color: gray;">? Задание: #'.$row['quest_id'].' (Не проверено)</div>';
					
					echo '
<div style="margin-left: 25px; font-size: 13px;">Вердикт: '.$row['commentary'].' </div>';
	echo '
<div style="margin-left: 25px; font-size: 13px;">Тест проверил: '.$row['checked_by'].' </div>';
					
echo '


</div>

'; 
                      }
               	     $result->close();
					} 
				
				
				
								
					$query = "SELECT score,date,test_id,passed FROM results WHERE user_name='".$_SESSION['name']."' ORDER BY id DESC LIMIT 15";	
					if ($result = $mysqli->query($query)) {
						$found = $result -> num_rows;
						if ($found>0) $found_bool = true;
                    while($row = $result->fetch_assoc()){			     
						 $score = $row['score'];
						 $date = $row['date'];
						 $test_id = $row['test_id'];
						 $passed = $row['passed'];
						 
						 	$query = "SELECT name, min_score FROM tests WHERE id = ".$test_id;	
					        if ($result2 = $mysqli->query($query)) {
                            while($row = $result2->fetch_assoc()){		
					        $test_name = $row['name'];
							$min_score = $row['min_score'];
                      }
					     $result2->close();
					} 
					
					echo '<div class="result_element">';
					if (!isset($test_name)) $test_name = "*Тест удалён*";
					
					if ($passed == 1) echo'
<div style="margin-left: 10px; font-weight: bold; color: green;">✔ Тест: "'.$test_name.'" (Пройден)</div>';
                    if ($passed == 0) echo '<div style="margin-left: 10px; font-weight: bold; color: red;">✖ Тест: "'.$test_name.'" (Не пройден)</div>';
					echo '
<div style="margin-left: 25px; font-size: 13px;">Получено баллов: '.$score.' </div>
<div style="margin-left: 25px; font-size: 13px;">Дата прохождения: '.$date.' </div> 




</div>

'; 
                      }
               	     $result->close();
					} 
					
					if (!$found_bool)
						echo '<center><div style="margin-top: 15px;">Ничего не найдено.</div></center>';
					
				
					
				
				
					
					$mysqli -> close();


?>




<center><a style="text-decoration: none;" href="system.php"><input type="submit" style="margin-top: 15px;" class="menu_button" name="back" value="Вернуться"></a></center>
</div>




	
</body>
</html>