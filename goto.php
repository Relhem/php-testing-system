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

<?PHP 
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




<?php 



$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                }
					$query = "SELECT name, attempts FROM tests WHERE id = ".$_GET['id'];	
					if ($result = $mysqli->query($query)) {
                    while($row = $result->fetch_assoc()){		
					      $test_name = $row['name'];
						  $test_attempts = $row['attempts'];
                      }
					     $result->close();
					}  	 
					
						$query = "SELECT password FROM tests WHERE id = ".$_GET['id'];	
					if ($result = $mysqli->query($query)) {
                    while($row = $result->fetch_assoc()){		
					      $test_pass = $row['password'];
                      }
					     $result->close();
					}
					

	$query = "SELECT score FROM results WHERE test_id=".$_GET['id']." AND user_name='".$_SESSION['name']."'";	
					$best_score=0;
					if ($result = $mysqli->query($query)) {					
						$attempts_finished = $result -> num_rows;
						$attempts_final = $test_attempts-$attempts_finished;
						if ($test_attempts == -1) $attempts_final_t = "Неогр.";
					    else $attempts_final_t = $attempts_final;					
							if ($attempts_final <=-1 && $test_attempts != -1)
							{
								$attempts_final = 0;
								$attempts_final_t = 0;
							}	
					   $passed_times = $result->num_rows;
                    while($row = $result->fetch_assoc()){			     
						  $score = $row['score'];
						  if ($score>$best_score) $best_score = $score;  
                      }
					     $result->close();
					} 		
			$mysqli->close();	
			if (isset($_POST['go_b']))
{
			if ($attempts_final == 0)
			{
		header("Location: http://t-syst.techhost.wtf/goto.php?id=".$_GET['id']."&error=1"); 
        return;	
			}
			
			if ($_POST['tpwd'] != $test_pass)
			{
		header("Location: http://t-syst.techhost.wtf/goto.php?id=".$_GET['id']."&error=2"); 
        return;	
			}
			
	 header("Location: test.php?id=".$_GET['id']."&pwd=".hash('ripemd320', $_POST['tpwd'])); 
}

?>

<div id = "goto_block">
  <center><div style="font-size: 16px; margin-top: 10px;font-weight: bold;">Переход к тесту "<?php echo $test_name.' (#'.$_GET['id'].')'?>"</div></center>
  
  <center>
  <table style="font-size: 12px;"> 
     <tr>
	   <td>
	   Тест выполнен: 
	   </td>
	   <td>
	   <div style="margin-left: 10px;"> <?php echo $passed_times?> раз(а). </div>
	   </td>
	 </tr>
	     <tr>
	   <td>
	   Лучший результат: 
	   </td>
	   <td>
	  <div style="margin-left: 10px;"> <?php echo $best_score?> балл(ов).</div>
	   </td>
	 </tr>
	  <tr>
	   <td>
	   Доступно попыток: 
	   </td>
	   <td>
	  <div style="margin-left: 10px;"> <?php echo $attempts_final_t?></div>
	   </td>
	 </tr>
  </table>

  	<form method="post">
  <table style="margin-top: 3px;">
  <tr>
    <td style="padding: 2px;">Пароль: </td>
	  <td><input style="width: 135px; padding: 2px;" name="tpwd" type="password" placeholder="Пароль"></td>
  </tr>
   </table>
    <input type="submit" style="margin-top: 5px;"class="button" name="go_b" value="Перейти">  
	
	<?php 
	if ($_GET['error'] == 1)
	{
		echo '<div style="font-size: 13px; color:red;">Вы исчерпали лимит попыток.</div>';
	}
		if ($_GET['error'] == 2)
	{
		echo '<div style="font-size: 13px; color:red;">Неверно введён пароль.</div>';
	}
	?>
	</form>
	
	</center>
  <div style="height: 10px;"></div>

  
</div>


	
</body>
</html>