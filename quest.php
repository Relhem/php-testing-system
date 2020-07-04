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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	
<?php 
require("authtest.php");


		$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                }
				
				
						if ($result = $mysqli->query('SELECT id FROM quests_data ORDER BY id DESC LIMIT 1')) {	
	                    while($row = $result->fetch_assoc()){
							 $Q_ID = $row['id']+1;
						}
               $result->close();
                }	
				
				
					$query = "SELECT id,name, created_by, quest FROM qtests WHERE id=".$_GET['id'];	
					if ($result = $mysqli->query($query)) {
                    while($row = $result->fetch_assoc()){			     
						 //$array = unserialize($row['quests_id']);
						 $quest_name = $row['name'];
						 $created_by = $row['created_by'];
						 $quest_text = $row['quest'];
						 
                      }
					     $result->close();
					}

if (isset($_POST['save']))
{
	if (!isset($_SESSION['name']))
	{
		 header("Location: index.php?error=pr");
		 return;
	}
	
	
	
		  $query = "INSERT INTO quests_data VALUES (".$Q_ID.",".$_GET['id'].",'".$_POST['answer_text']."',0,'***','".$_SESSION['name']."','***')";
              $mysqli->query($query);
			$mysqli->close();

				header("Location: system.php?success=4");  
			
			}
					
					
/*
$array = array( 1, 2, 3 );
	$string = serialize( $array );
	echo $string;
	$array = unserialize($string);
	print_r ($array);
*/
?>
	
</head>



<body>




<div class="back_gray">
 <div style="position: absolute;">
 <a style="text-decoration: none; border: none; color: rgb(68,68,68); font-size: 15px; font-weight: bold; margin: 5px;" href="system.php"><img style="width: 35px; height: 35px;" src="/images/home.png"></a>
 </div>
<div style="margin-left: 1px;"id="title">
 <center>Добро пожаловать в систему тестирования,<span> <?php echo $_SESSION['name']?></span>!</center>
</div>
</div>
<div style="font-size: 12px; margin-top: 5px">
<center> <?php echo 'Дата: '.date('Y/m/d');?></center>
</div>


<form method="post">

<div id="up_quest_block">
<center><div style="font-size: 23px; font-weight: bold;"><?php echo 'Задание: "'.$quest_name.'"'?></div></center>
<center><div style="font-size: 13px;"><?php echo 'Создатель: '.$created_by.''?></div>

<div style="margin-top: 10px; width: 800px;"><pre> <?php echo''.$quest_text ?> </pre></div>

<br>

<textarea name="answer_text" style="resize:none; width: 660px; height: 80px; padding: 10px; margin-top: 5px;" placeholder="Введите ваш ответ здесь."></textarea>

</center>


<div style="height: 15px;"></div>


</div>

<center>
<input type="submit" class="menu_button" name="save" value="Готово"> </centeR>


</form>

<div style="height: 30px;"></div>
</body>
</html>