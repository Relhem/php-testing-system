<?php
  unset($_SESSION[md5("id")]);
  session_name(md5("id"));
  session_start();
  
  if (isset($_SESSION['name']))
		{
			if (isset($_SESSION['password']))
			{
				$log = $_SESSION['name'];
				$pass = $_SESSION['password'];	
				$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                } 		
					if ($result = $mysqli->query("SELECT login,password FROM auth WHERE login='".$log."'")) {
                    while($row = $result->fetch_assoc() ){		
					if ($log == $row['login'])
					{		
						 if (!password_verify($pass, $row['password'])) {     		
						//	if (md5($pass) != $row['password'])){
						session_destroy();
			            header("Location: index.php?error=pr");
						$result->close();
                        $mysqli->close();
						return;						
                      }				  
					}
                }		
               $result->close();
         }
                		 
				$mysqli->close();
				return;
				
			} else
				
				{
					session_destroy();
			        header("Location: index.php?error=pr");
					exit;
					
				}	
		} else
		{
			session_destroy();
			header("Location: index.php?error=pr");
			exit;
		}
?>