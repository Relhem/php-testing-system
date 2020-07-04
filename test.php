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
				
				
					
					$query = "SELECT id,name, attempts, created_by,password,quests_id, min_score, comment FROM tests WHERE id=".$_GET['id'];	
					if ($result = $mysqli->query($query)) {
                    while($row = $result->fetch_assoc()){			     
						 //$array = unserialize($row['quests_id']);
						 $tpwd = $row['password'];
						 $test_name = $row['name'];
						 $min_score = $row['min_score'];
						 $test_attempts = $row['attempts'];
						 $comment = $row['comment'];
						 
						// $out = count(unserialize($row['quests_id']));
						if ($result2 = $mysqli->query('SELECT score FROM questions WHERE test_id='.$_GET['id'])) {
							$out = 0;
							  while($row = $result2->fetch_assoc()){
                                   						      $out = $out+$row['score'];				
                      }		
               $result2->close();
                }
                      }
					     $result->close();
					}
					
					
						$query = "SELECT score FROM results WHERE test_id=".$_GET['id']." AND user_name='".$_SESSION['name']."'";	
					if ($result = $mysqli->query($query)) {					
						$attempts_finished = $result -> num_rows;
						$attempts_final = $test_attempts-$attempts_finished;				
							if ($attempts_final <=-1 && $test_attempts != -1)
							{
								$attempts_final = 0;
							}	
					     $result->close();
					}
					if ($attempts_final == 0)
			{
		header("Location: http://t-syst.esy.es/goto.php?id=".$_GET['id']."&error=1"); 
        return;	
			}
					
					

	if ($_GET['pwd'] != hash('ripemd320', $tpwd))
			{
		header("Location: http://t-syst.esy.es/goto.php?id=".$_GET['id']."&error=2"); 
        return;	
			}					
	


if (isset($_POST['finish_test_b']))
{
	if (!isset($_SESSION['name']))
	{
		 header("Location: index.php?error=pr");
		 return;
	}
	
	$mistakes = Array();
	

	
	$mysqli2 = new mysqli('localhost', '', '', ''); 
	
	
	 $query = "SELECT open FROM tests WHERE id=".$_GET['id'];       	 
					if ($result = $mysqli2->query($query)) {
						$open = 0;		
                    while($row = $result->fetch_assoc()){
                                    if ($row['open'] == 1) $open = 1;										
                      }
					     $result->close();
					}
	
	
	 $query = "SELECT id,question, answer,score FROM questions WHERE test_id=".$_GET['id'];       	 
					if ($result = $mysqli2->query($query)) {
						$score = 0;		
						$id_q = 0;
                    while($row = $result->fetch_assoc()){
						      $id_q++;
                                    if ($row['answer'] == $_POST['answer_'.$row['id']]) 
									{	
									$score = $score+$row['score'];
									}		else
									{
										if ($open)
										array_push($mistakes, $id_q);
									}										
                      }
					     $result->close();
					}

           $mistakes_str = serialize($mistakes);	
           $mistakes_str_hexed = strToHex($mistakes_str);
					
	if ($result = $mysqli2->query('SELECT id FROM results')) {
               $results_id = $result->num_rows+1;	
               $result->close();
                }						
					  if ($score>=$min_score) $passed = 1;
			   else $passed = 0;
					
					$date = date('Y/m/d');
	  $query = "INSERT INTO results VALUES (".$results_id.",'".$_SESSION['name']."',". $_GET['id'].", ".$score.", '".$date."', ".$passed.")";
              $mysqli->query($query);	
			  
       	header("Location: results.php?got=".$score."&out=".$out."&passed=".$passed."&mistakes=".$mistakes_str_hexed."&n=".strToHex($test_name));  
	$mysqli2->close();				
}
	
					
									
?>

<div id="up_test_block">
<center><div style="font-size: 23px; font-weight: bold;"><?php echo 'Тест: "'.$test_name.'"'?></div></center>
<center><div style="font-size: 13px;"><?php echo 'Минимальный балл: '.$min_score.''?></div></center>
</div>



<?php 
if ($comment != '')
echo'
<div id="up_test_block">
<table>
<tr>
<td>
<img style="width: 35px; height: 44px;" src="/images/voskl.png">
</td>
<td>
<div style="font-size: 17px; font-weight: bold; margin-left: 11px;">Комментарий создателя:</div>
<div style="font-size: 13px; margin-left: 15px; width: 700px;">'. htmlspecialchars($comment).'</div>
</td>
</tr>
</table>
<br>
</div>'

?>

<form method="post">
<?php  	 
                      $query = "SELECT id,type,question,score,image,sounds FROM questions WHERE test_id=".$_GET['id'];	
					if ($result = $mysqli->query($query)) {
						$count = 1;
						
                    while($row = $result->fetch_assoc()){

					   $image='';
					   $sounds='';
					   if ($row['image'] != '') $image = '<img style="max-height: 400px; max-width: 400px;" src="res/images/'.$row['image'].'">';
					   if ($row['sounds'] != '') $sounds = '  <audio controls>
     <source src="/res/sounds/'.$row['sounds'].'" type="audio/mp3" >
  </audio>';
					
					$quests_special = htmlspecialchars($row['question'], ENT_QUOTES);
						  echo '<div style="border-radius: 0px" class="test_question">
<div style="margin-left: 3px; font-weight: bold;">Вопрос №'.$count.' ('.$row['score'].')</div>
<div style="margin-top: 5px; padding: 10px; background: #f7f7f7 linear-gradient(#f7f7f7, #f1f1f1);"><pre>'.$quests_special.'</pre></div>

<div style="margin: 5px;">'.$image.'</div>
<div style="margin: 5px;">'.$sounds.'</div>

<input style="width: 135px; margin-top: 10px; padding: 3px;" name="answer_'.$row['id'].'" required type="text" placeholder="Ответ">
</div>';
						 $count++;				 
                      }
					     $result->close();
					}			
			$mysqli->close();		
?>


<center><input type="submit" class="menu_button" name="finish_test_b" value="Завершить тестирование"></center>
<div style="margin-top: 30px;"></div>
</form>
	
</body>
</html>