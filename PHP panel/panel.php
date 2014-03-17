<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css" />       
<title>Panda development project</title>
</head>
  
<body>


<?php

//world variables:
$action = "";

?>


<div id="upper_menu"> 
	<ul>
		<a href="panel.php?action=orders"><li <?php if(isset($_GET['action'])) { if($_GET['action'] == "orders") { echo("class='selected'"); $action="orders"; }} else { echo("class='selected'"); $action="orders"; }?>>My orders</li></a>
		<a href="panel.php?action=statistic"><li <?php if(isset($_GET['action'])) { if($_GET['action'] == "statistic") { echo("class='selected'"); $action="statistic"; }} ?>>Statistic</li></a>
		<a href="panel.php?action=products"><li <?php if(isset($_GET['action'])) { if($_GET['action'] == "products") { echo("class='selected'"); $action="products"; }} ?>>Products</li></a>
		<a href="panel.php?action=exit"><li><img src="img/exit.png" style="
			margin-top:-4px;
			margin-right:5px;
			vertical-align:middle;
		"/>Exit</li></a>
	</ul>
	
</div>	






<?php

	session_start();
	
	if(isset($_GET['action']))
	{
		if($_GET['action'] == "exit")
		{
				session_destroy();
			 header("Location: index.html");
		}
	}
	
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
			if($action == "orders")
			{
				echo("<div id='alert_box'>");
				echo("You entered as <b>".$email."</b>, and your IP = <b>".$_SERVER["REMOTE_ADDR"]."</b><br/><br/>");
				echo("Your last login was <b>".$myrow["last_login"]."</b> from IP = <b>".$myrow["last_ip"]."</b><br/><br/>");
				echo("</div>");
			}
		
		
			if($action == "products")
			{
				$result = mysql_query("SELECT * FROM products",$dbcon);
				
				echo("
				<table class='features-table'>
				<thead>
					<tr>
						<td style='width:5%;'>ID</td>
						<td class='grey' style='width:10%;'>Name</td>
						<td class='grey' style='width:10%;'>Category</td>
						<td class='grey' style='width:10%;'>Price</td>
						<td class='grey' style='width:35%;'>Describing</td>
						<td class='grey' style='width:10%;'>Sold amount</td>
						<td class='grey' style='width:10%;'>Store</td>
						<td class='green' style='width:10%;'>Edit</td>
					</tr>
				</thead>
				 
				<tbody>
				");
				
				
				while($products = mysql_fetch_array($result))
				{
					echo("
						<tr>
							<td>".$products['id']."</td>
							<td class='grey'>".$products['name']."</td>
							<td class='grey'>".$products['category']."</td>
							<td class='grey'>".$products['price']."</td>
							<td class='grey'>".$products['describing']."</td>
							<td class='grey'>".$products['sold_amount']."</td>
							<td class='grey'>".$products['store']."</td>
							<td class='green'>Edit buttons</td>
						</tr>
					");
				}
				
				echo("
				
				</tbody>
				</table>
				
				");
		
		
			}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		}
		else
		{
			echo("<script>var body=document.getElementsByTagName('body')[0]; while(body.firstChild) body.removeChild(body.firstChild);</script>");
			echo("Sorry, login or password is wrong");
		}
	}
	else
	{
		echo("<script>var body=document.getElementsByTagName('body')[0]; while(body.firstChild) body.removeChild(body.firstChild);</script>");
		echo("Sorry, you need to re-login");
	}
	
?>

</body>


</html> 