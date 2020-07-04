

<?php


				
		
	$mysqli = new mysqli('localhost', '', '', ''); 
				if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
                } 		
				
                $qr = "CREATE TABLE IF NOT EXISTS auth_t(
login VARCHAR(32) PRIMARY KEY,
password VARCHAR(255))";
                 $mysqli -> query($qr);
				 
				         $qr = "CREATE TABLE IF NOT EXISTS q_t(
ld INT(32) PRIMARY KEY,
type VARCHAR(32),
question TEXT,
answer TEXT,
created_by TEXT,
test_id INT(11),
score DOUBLE DEFAULT 1.0)";
                 $mysqli -> query($qr);
         	
			   $mysqli->close();		
echo 'Таблицы созданы.';			   
?>
