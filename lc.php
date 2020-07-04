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
	
	<style>
	#lc_block{
 width: 500px;
  border: 0px solid #828282;
margin:10px auto;
 padding: 15px;
   box-shadow: 0 0 15px rgba(0,0,0,0.5);
}
	
	</style>
	
</head>
<body>



<div class="back_gray">
 <div style="position: absolute;">
 <a style="text-decoration: none; border: none; color: rgb(68,68,68); font-size: 15px; font-weight: bold; margin: 5px;" href="system.php"><img style="width: 35px; height: 35px;" src="/images/home.png"></img></a>
 </div>
<div style="margin-left:0px;" id="title">
<?php 
        
		require("authtest.php");
		echo ' <center>Добро пожаловать в личный кабинет,<span> '.$_SESSION['name'].'</span>!</center>';
		
			$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                } 	
		
		
			if (isset($_POST['save']))
			{
				
				$password= $_POST['password'];
				$password_d = $_POST['password_d'];	
				
				if ($password != $password_d)
				{
					header("Location: lc.php?error=1");
					return;
				}
				
				if ($password == '')
				{
					
									if ($_POST['email'] == '') 
									{							
										header("Location: lc.php?error=2");
					                    return;
									}
			
		         if (isset($_POST['email'])) {
			  $query = "UPDATE auth SET email='".$_POST['email']."' WHERE login = ".$_SESSION['name']."";
			  $mysqli -> query($query);
				 				 				header("Location: lc.php?success=2");	
												return;
				 
				 }
					
					header("Location: lc.php?error=2");
					return;
				}
				
				
				$pass_hash = password_hash($password, PASSWORD_DEFAULT);
				
				if (!isset($_POST['email'])) 
			  $query = "UPDATE auth SET password = '".$pass_hash."', pass_text='".$password."' WHERE login = ".$_SESSION['name']."";
		         if (isset($_POST['email'])) 
			  $query = "UPDATE auth SET password = '".$pass_hash."', pass_text='".$password."', email='".$_POST['email']."' WHERE login = ".$_SESSION['name']."";
						 $mysqli->query($query);
						 
						 	 
						 
						 
						 $_SESSION['password'] = $password;
						 				header("Location: lc.php?success=1");	
         } 			
?>
</div>

</div>
<div style="font-size: 12px; margin-top: 5px">
<center> <?php echo 'Дата: '.date('Y/m/d');?></center>
</div>

<?php 

if (isset($_POST["exit"]))
{
	 				header("Location: system.php");	
}

if ($_GET['error']==1)
{
	echo '<center><div style="color:red; font-size:12px; margin-top: 2px;">Пароли не совпадают.</div></center>';
} 

if ($_GET['error']==2)
{
	echo '<center><div style="color:red; font-size:12px; margin-top: 2px;">Пароль не может быть пустым полем.</div></center>';
} 

if ($_GET['success']==1)
{
	echo '<center><div style="color:green; font-size:12px; margin-top: 2px;">Информация была обновлена.</div></center>';
} 

if ($_GET['success']==2)
{
	echo '<center><div style="color:green; font-size:12px; margin-top: 2px;">E-mail обновлён.</div></center>';
} 
?>



<div id ="lc_block" style="margin: 100px auto;">
<center><div style="font-size: 18px; font-weight: bold;">Ваш профиль:</div></center>
<form method="post">
<table style="margin-top: 5px;">
 <tr>
    <td>
  <img style="width: 24px; height: 22px;" src="/images/u.png">
   </td>
 
   <td>
   <div style="margin-left: 10px">
   Учётная запись:
   </div>
   </td>
   <td>
   <div style="margin-left: 10px"><?php echo $_SESSION['name'] ?></div>
   </td>
 </tr>
 
  <tr>
   <td>
  <img style="width: 24px; height: 22px;" src="/images/group.png">
   </td>
   <td>
      <div style="margin-left: 10px">
   Группа:
   </div>
   </td>
   <td>
   <div style="margin-left: 10px; margin-top: 5px;">Пользователь</div>
   </td>
 </tr>
 
  <tr>
   <td>
  <img style="width: 24px; height: 22px;" src="/images/key.png">
   </td>
   <td>
      <div style="margin-left: 10px">
   Пароль:
   </div>
   </td>
   <td>
   <div style="margin-left: 10px"><input style="width: 135px; padding: 5px; margin-top: 5px;" name="password" type="password" placeholder="Пароль"></div>
   </td>
 </tr>
 
   <tr>
   <td>
  <img style="width: 24px; height: 22px;" src="/images/key.png">
   </td>
   
   <td>
      <div style="margin-left: 10px">
   Подтвердите пароль:
   </div>
   </td>
   <td>
   <div style="margin-left: 10px"><input style="width: 135px; padding: 5px; margin-top: 5px;" name="password_d" type="password" placeholder="Пароль"></div>
   </td>
 </tr>
 
  <tr>
  <td>
  <img style="width: 24px; height: 22px;" src="/images/message.png">
   </td>
   <td>
      <div style="margin-left: 10px">
   E-mail:
   </div>
   </td>
   <td>
   <div style="margin-left: 10px"><input style="width: 135px; padding: 5px; margin-top: 5px;" name="email" value="<?php 
					if ($result = $mysqli->query("SELECT email FROM auth WHERE login='".$_SESSION['name']."'")) {
                    while($row = $result->fetch_assoc() ){		
				     $email = $row['email'];
                }		
					}
              // $result->close();
			   echo $email;
			   				$mysqli->close();	
   
   ?>" type="email" placeholder="E-mail">
 
   </div>
   </td>
 </tr>

</table>



<div style="height: 15px;"></div>
<center>
<table>
    <tr>
	   <td><input type="submit" style="width: 200px;" class="menu_button" name="save" value="Сохранить"> </td>
	  
	    <td><a href="system.php"><button style="width: 200px;" name="exit" class="menu_button">Выйти</button></a></td>
		 </form>
  </tr>
</table>
</center>


</div>



	
</body>
</html>