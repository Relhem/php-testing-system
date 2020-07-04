<!DOCTYPE html>
<html>
<head>
	<title>Авторизация на сайте</title>
	<meta charset="utf-8">
	<meta name="keywords" content="">
	<meta name="deskription" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="shortcut icon" href="/images/favicon.ico" type="image/png">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>



<body>

<div style="border-radius: 8px;" id="c_block">

<center> 
<table>
<tr>
<td>
<b>Авторизация</b> 
</td>
<td>
  <div style="margin-left: 5px;font-size: 13px; background: black; width: 15px; height: 15px; color: white; text-align: center;"><span class="tooltiptext_1" data-tooltip="Это форма упрощённой авторизации/регистрации. Подтверждать пароль и вводить E-mail не требуется.">?</span></div>
</td>
</tr>
</table>
</center>

<form method="post">
<center>
<table style="margin-top: 10px; margin-left:-2px;" >
  <tr>
    <td>Логин: </td>
	  <td><input style="width: 135px;" name="login" pattern="^[a-zA-Z0-9]+$" required type="text" placeholder="Логин"></td>
  </tr>
  <tr>
    <td>Пароль: </td>
	  <td><input style="width: 135px;" name="password" pattern="^[a-zA-Z0-9]+$" required type="password" placeholder="Пароль"></td>
  </tr>
</table></center>

<div style="margin-top: 7px; margin-left: 7px">

<table style="margin-top: 10px; margin-left:-2px;" >
  <tr>
    <td><input type="submit" class="button" name="log_button" value="Войти"></td>
	<td><input type="submit" class="button" name="reg_button" value="Зарегистрироваться"></td> 
  </tr>
</table>
</div>
</form>


<?php
					session_name(md5("id"));
					session_start();
					if (isset($_SESSION['name']))
					{
								header("Location: system.php");
								return;
					}


  if (isset($_POST['log_button']))
    {	
  if (isset($_POST['login']))
		{
			if (isset($_POST['password']))
			{

				
				$log = $_POST['login'];
				$pass = $_POST['password'];	
			$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                } 		
	
					if ($result = $mysqli->query("SELECT login, password FROM auth WHERE login='".$log."'")) {
                    while($row = $result->fetch_assoc() ){		
					if ($log == $row['login'])
					{
						 if (password_verify($pass, $row['password'])) {
							//if (md5($pass)==$row['password'])){
                        {	
						$_SESSION['password'] = $pass;	
						$_SESSION['name'] = $row['login'];
						header("Location: system.php");
						$result->close();
                        $mysqli->close();
						return;
						}
						}		
					}
                }		
               $result->close();
         } 	
				$mysqli->close();
				header("Location: index.php?error=2");	
				
			}
		}
};
	
	if (isset($_POST['reg_button']))
	{
		if (isset($_POST['login']))
		{
			if (isset($_POST['password']))
			{
				$log = $_POST['login'];
				$pass = $_POST['password'];	
				
				$pass_hash = password_hash($pass, PASSWORD_DEFAULT);
				
				//$pass_hash = md5($pass);
				
				$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                } 		
					if ($result = $mysqli->query('SELECT login,password FROM auth')) {
                    while( $row = $result->fetch_assoc() ){		
					if ($log == $row['login'])
					{
						$result->close();
						$mysqli->close();
						header("Location: index.php?error=1");
						return;
					}
                }	
			//   $query = "INSERT INTO auth VALUES ('".$_POST['login']."', '".$pass_hash."','".$_POST['password']."')";
			$query = "INSERT INTO auth VALUES ('".$_POST['login']."', '".$pass_hash."')";
               $mysqli->query($query);	
               $result->close();
         } 	
				$mysqli->close();
					$_SESSION['password'] = $pass;	
					$_SESSION['name'] = $log;
				header("Location: system.php?success=1");	
			}
		}	
	}	
	
?>


<?php 
if ($_GET['error']==1)
{
	echo '<center><div style="color:red; font-size:12px; margin-top: 2px;">Такой логин уже занят.</div></center>';
} 
if ($_GET['error']==2)
{
	echo '<center><div style="color:red; font-size:12px; margin-top:2px;">Неправильно введён логин или пароль.</div></center>';
}
if ($_GET['error']=='pr')
{
	echo '<center><div style="color:red; font-size:12px; margin-top:2px;">Срок действия сессии истёк.</div></center>';
}

?>


</div>


	
</body>
</html>