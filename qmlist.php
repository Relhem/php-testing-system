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

<div class="qmlist_block">


 <center><div style="font-size:14px; font-weight: bold;">Выберите одно из <span style="color: red;">ваших</span> заданий:</div></center>


<?php 



				
					$query = "SELECT id,name,date_info FROM qtests WHERE created_by ='".$_SESSION['name']."' ORDER BY id DESC";	
					if ($result = $mysqli->query($query)) {
						$found = $result -> num_rows;
						

                    while($row = $result->fetch_assoc()){
								
					
                    echo '<a style="text-decoration: none; color: black;" href="qmanage.php?id='.$row['id'].'"><div class="manage_up_element"> 
<table style="font-size: 13px;">
 <tr>
    <td>Название: <b>'.$row['name'].' (#'.$row['id'].')</b></td>
    <td><div style="margin-left: 10px;">Дата создания: <b>'.$row['date_info'].'</b></div></td>
 </tr>
</table>
</div></a>';				                
                      }
					  
					  if ($found == 0)
						   echo '<center><div style="margin-top: 15px;">Ничего не найдено.</div></center>' ;
					  
					     $result->close();
				 }
				 
				 echo '</div>';
				 


?>




</div>

</form>

<div style="height: 30px;"></div>
</body>
</html>