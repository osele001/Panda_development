<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css" />       
<title>Panda development project</title>
</head>
  
<body>

<div id="upper_menu"> 
	<ul>
		<a href="panel.php"><li class="selected">My orders</li></a>
		<a href="panel.php"><li>Statistics</li></a>
		<a href="panel.php"><li>Products</li></a>
	</ul>
</div>


<?php
	
	session_start();
	
	if((isset($_SESSION["email"])))
	{
		$email = $_SESSION["email"];
		$hash = $_SESSION["hash"];
		
		include "conf.php";
		
		//Подключаемся к базе данных.
		
		$dbcon = mysql_connect($base_name, $base_user, $base_pass); 
		mysql_select_db($db_name, $dbcon);
		if (!$dbcon)
		{
			echo "<p>Error in connecting to MySQL!</p>".mysql_error(); exit();
		} else {
			if (!mysql_select_db($db_name, $dbcon))
			{
				echo("<p>Selected DB is not existing!</p>");
			}
		}
					
		mysql_query("SET NAMES 'utf8'");
		
		$result = mysql_query("SELECT * FROM ultra_secured_table_of_users WHERE email='$email'",$dbcon);
		$myrow = mysql_fetch_array($result);
		
		if($myrow["hash"] == $hash)
		{
		
		
		
			// только теперь работаем
		
			echo("<div id='alert_box'>");
			echo("You entered as <b>".$email."</b>, and your IP = <b>".$_SERVER["REMOTE_ADDR"]."</b><br/><br/>");
			echo("Your last login was <b>".$myrow["last_login"]."</b> from IP = <b>".$myrow["last_ip"]."</b><br/><br/>");
			echo("</div>");
		
		
		
		
		
		
		
		}
		else
		echo("Sorry, login or password is wrong");
	}
	else
		echo("Sorry, you need to re-login");
	
?>

</body>


</html> 