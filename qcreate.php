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

if (isset($_POST['save']))
{
		if (!isset($_SESSION['name']))
	{
		 header("Location: index.php?error=pr");
		 return;
	}
	
	
	$quest_name = $_POST['quest_name'];
	$quest_text = $_POST['quest_text'];
	$quest_password = $_POST['quest_pass'];
	
	
	
	$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                } 		
				/*	if ($result = $mysqli->query('SELECT id FROM tests')) {
               $test_id = $result->num_rows+1;	   
               $result->close();
                } 	*/
				
			
				
				if ($result = $mysqli->query('SELECT id FROM qtests ORDER BY id DESC LIMIT 1')) {	
	                    while($row = $result->fetch_assoc()){
							$quest_id = $row['id']+1;
							
						}
               $result->close();
                }					 	

               $date = date('Y/m/d');
			 
		
	
			  $query = "INSERT INTO qtests VALUES (".$quest_id.",'".$quest_name."','".$quest_password."','".$_SESSION['name']."','".$date."','".$quest_text."')";
              $mysqli->query($query);
			$mysqli->close();
	
	header("Location: system.php?success=3");
	
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
 <center>Добро пожаловать в "Мастер тестов",<span> <?php echo $_SESSION['name']?></span>!</center>
</div>
</div>
<div style="font-size: 12px; margin-top: 5px">
<center> <?php echo 'Дата: '.date('Y/m/d');?></center>
</div>


<form method="post">
<div class="create_up_element">
<center>
<input style="width: 30%; height: 25px; font-size: 25px; text-align:center; padding: 6px 20px 6px 20px; margin-top: 10px" name="quest_name" required type="text" placeholder="Название задания">
<br><div style="height: 10px;"></div>
</center>
</div>

<div class="create_block">
<center> 
<textarea name="quest_text" style="resize:none; width: 660px; height: 80px; padding: 10px;" placeholder="Введите задание здесь."></textarea>
</center>
</div>

<center>
<input type="submit" class="menu_button" name="save" value="Сохранить"> </centeR>
</form>

<div style="height: 30px;"></div>
</body>
</html>