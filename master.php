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
	
	
	$q = $_GET['q'];
	$test_name = $_POST['test_name'];
	if (isset($_POST['open_check']))
	$open = 1; else 
	{
		$open = 0;
	}
	$test_password = $_POST['test_pass'];
	$min = $_GET['m'];
	// БАЗА ДАННЫХ
	
				$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                } 		
				/*	if ($result = $mysqli->query('SELECT id FROM tests')) {
               $test_id = $result->num_rows+1;	   
               $result->close();
                } 	*/
				
				if ($result = $mysqli->query('SELECT id FROM tests ORDER BY id DESC LIMIT 1')) {	
	                    while($row = $result->fetch_assoc()){
							 $test_id = $row['id']+1;
						}
               $result->close();
                }
				
				
				
				if ($result = $mysqli->query('SELECT id FROM questions ORDER BY id DESC LIMIT 1')) {	
	                    while($row = $result->fetch_assoc()){
							 $question_id = $row['id']+1;
						}
               $result->close();
                }	
				
				$i = 1;
				
			 $question_ids = Array();
			  for ($i=1; $i<=$q; $i++) {				  
			  $query = "INSERT INTO questions VALUES (".$question_id.",1,'".$_POST['question_'.$i]."','".$_POST['answer_'.$i]."','".$_SESSION['name']."',".$test_id.",1,'','')";
              $mysqli->query($query);	
			  array_push($question_ids, $question_id);
			  $question_id = $question_id+1;
	         }		 	

               $date = date('Y/m/d');
			 
			  $string_questions_ids = serialize($question_ids);
			  $query = "INSERT INTO tests VALUES (".$test_id.",'".$test_name."',".$open.",'".$test_password."','".$string_questions_ids."','".$_SESSION['name']."',".$min.",'".$date."',-1,'')";
              $mysqli->query($query);
			$mysqli->close();
	
	header("Location: system.php?success=2");
	
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

<?php 
if (isset($_POST['next']))
{
  header("Location: master.php?q=".$_POST['q']."&m=".$_POST['m']);
}
?>

<div id ="up_main_block_master">
<form method="post">
<center><div style="font-weight: bold;">Основные настройки</div>

<div style="margin-top: 5px;">
<table>
 <tr>
     <td> Количество вопросов: </td>
     <td><input style="width: 130px;" name="q" required type="text" placeholder="<?php echo $_GET['q']?>"></td>
 </tr>
  <tr>
     <td> Минимальный балл: </td>
     <td><input style="width: 130px;" name="m" required type="text" placeholder="<?php echo $_GET['m']?>"></td>
 </tr>
</table> 
</div>
<input style="margin-top: 10px;" type="submit" class="menu_button" name="next" value="Далее"> </center>
</form>
</div>


<form method="post">
 
<?php 
if ($_GET['q'] != '' & $_GET['m'] != '') echo'
<div  id="main_block_master">
<center>
<input style="width: 30%; height: 25px; font-size: 25px; text-align:center; padding: 6px 20px 6px 20px; margin-top: 10px" name="test_name" required type="text" placeholder="Название теста"></center>
<center>
<table>
  <tr>
  <td><div nstyle="font-size: 13px; margin-right: 5px;">Открытый</div></td>
    <td><div style="margin-right: 5px;"><input name="open_check" type="checkbox"></div></center><td>
	<td><input style="font-size: 13px" name="test_pass" type="text" placeholder=" Пароль для теста"></td>
  </tr>
</table>
</center>'
?>

<?php 
$q = $_GET["q"];
for ($i=1; $i<=$q; $i++) {
echo '<div class="main_block_question" id="b_q_'.'i'.'">
<table>
  <tr>
  <td><div style="font-size: 13px; margin-right: 5px; width: 70px;">Вопрос '.$i.': </div></td>
	<td><textarea name="question_'.$i.'" required style="resize:none; width: 660px; height: 80px;"></textarea></td>
  </tr>
   <tr>
  <td><div style="font-size: 13px; margin-right: 5px; width: 60px;">Ответ: </div></td>
    <td><input name="answer_'.$i.'" style="font-size: 13px" required type="text" placeholder="Ответ"></td>
   </tr>
</table>
</div>';
}
?>

<?php 
if ($_GET['q'] != '' & $_GET['m'] != '') 
	echo'
<div style="height: 30px;"></div>
<center>
<table>
    <tr>
	   <td><input type="submit" class="menu_button" name="save" value="Сохранить"> </td>
	   </form>
	    <td><a href="system.php"><button class="menu_button">Выйти</button></a></td>
		
  </tr>
</table>
</center>
<div style="height: 30px;"></div>
</div>'?>



<div style="height: 30px;"></div>
</body>
</html>