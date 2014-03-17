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
$id = -1;

?>


<div id="upper_menu"> 
	<ul>
		<a href="panel.php?action=orders"><li <?php if(isset($_GET['action'])) { if($_GET['action'] == "orders") { echo("class='selected'"); $action="orders"; }} else { echo("class='selected'"); $action="orders"; }?>>My orders</li></a>
		<a href="panel.php?action=statistic"><li <?php if(isset($_GET['action'])) { if($_GET['action'] == "statistic") { echo("class='selected'"); $action="statistic"; }} ?>>Statistic</li></a>
		<a href="panel.php?action=products"><li <?php if(isset($_GET['action'])) { if(($_GET['action'] == "products") || ($_GET['action'] == "edit") || ($_GET['action'] == "delete")) { echo("class='selected'"); $action="products"; }} ?>>Products</li></a>
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
		
		$action = $_GET['action'];
	}
	
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
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
			echo "<h2>Error in connecting to MySQL</h2>".mysql_error(); exit();
		} else {
			if (!mysql_select_db($db_name, $dbcon))
			{
				echo("<h2>Selected DB is not existing</h2>");
			}
		}
					
		mysql_query("SET NAMES 'utf8'");
		
		$result = mysql_query("SELECT * FROM ultra_secured_table_of_users WHERE email='$email'",$dbcon);
		$myrow = mysql_fetch_array($result);
		
		if($myrow["hash"] == $hash)
		{
			
			/* ACTION = ORDERS */
			
			if($action == "orders")
			{
				echo("<div id='alert_box'>");
				echo("You entered as <b>".$email."</b>, and your IP = <b>".$_SERVER["REMOTE_ADDR"]."</b><br/><br/>");
				echo("Your last login was <b>".$myrow["last_login"]."</b> from IP = <b>".$myrow["last_ip"]."</b><br/><br/>");
				echo("</div>");
			}
			
			/* ACTION = ORDERS */
			
			
			
			/* updating last login and IP */
			date_default_timezone_set("Europe/Helsinki"); 
			$date = date('l jS \of F Y G:i:s');
			$ip = $_SERVER["REMOTE_ADDR"];
			$sql = mysql_query("UPDATE ultra_secured_table_of_users SET last_login = '".$date."', last_ip = '".$ip."' where email = '".$email."'", $dbcon);
				
		
		
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
							<td class='green'>
							<a href='panel.php?action=edit&id=".$products['id']."'  style='margin-right:25px;'><img src='img/edit.png'/></a>
							<a href='panel.php?action=delete&id=".$products['id']."&name=".$products['name']."'><img src='img/delete.jpg'/></a>
							</td>
						</tr>
					");
				}
				
				echo("
				
				</tbody>
				</table>
				
				");
			}
			/* ACTION = ORDERS */
		
		
		
		
		
		
		
		
			/* ACTION = EDIT */

			if($action == "edit")
			{
				/* stupid way to check, did we recieve a request to update the BD from editing */ 
				
				if(isset($_GET['name']))
				{
					try
					{
						$id = $_GET['id'];
						$name = $_GET['name'];
						$category = $_GET['category'];
						$price = $_GET['price'];
						$describing = $_GET['describing'];
						$sold = $_GET['sold_amount'];
						$store = $_GET['store'];
						
						$sql = mysql_query("UPDATE products SET name = '".$name."', category = '".$category."',
						price = '".$price."', describing = '".$describing."', sold_amount = '".$sold."', store = '".$store."'
						where id = '".$id."'", $dbcon);
						
						if($sql)
							echo "<h2>Product was updated</h2>";
					}
					catch (Exception $e) {
						echo '<h2>Wrong input, try again</h2>';
					}
					
				
				}
				else
				{				
					echo("<h1>Editing mode</h1>");
					echo("<div id='form_container'>");
				
					$result = mysql_query("SELECT * FROM products WHERE id = ".$id." LIMIT 1",$dbcon);
					while($products = mysql_fetch_array($result))
					{
						echo("<form><input type='hidden' name='action' value='edit'/><table><tr>");
						echo("<td width='150px'>ID:</td><td width='600px'><input type='text' name='id' readonly value='".$products['id']."'/></td></tr>");
						echo("<tr><td>Name:</td><td><textarea name='name'>".$products['name']."</textarea></td></tr>");
						echo("<tr><td>Category:</td><td><textarea name='category'>".$products['category']."</textarea></td></tr>");
						echo("<tr><td>Price:</td><td><textarea name='price'>".$products['price']."</textarea></td></tr>");
						echo("<tr><td>Describing:</td><td><textarea name='describing' rows='10' cols='70'>".$products['describing']."</textarea></td></tr>");
						echo("<tr><td>Sold amount:</td><td><textarea name='sold_amount'>".$products['sold_amount']."</textarea></td></tr>");
						echo("<tr><td>Store:</td><td><textarea name='store'>".$products['store']."</textarea></td></tr>");
						echo("</table>");
						echo("<input type='submit' method='post' action='panel.php' value='Submit changes'/></form>");	
					}
					
					echo("</div>");
				}
				
			}

			/* ACTION = EDIT */
		
		
		
		
			/* ACTION = DELETE */
			
			if($action == "delete")
			{
				if((isset($_GET['confirm'])) && (isset($_GET['id'])))
				{
					$id = $_GET['id'];
					if($_GET['confirm'] == "DELETE")
					{				
						$sql = mysql_query("DELETE from products where id = ".$id." LIMIT 1", $dbcon);
						if($sql)
							echo '<h2>The product was removed</h2>';
						else
							echo '<h2>MySQL problem</h2>';
					}
					else
						echo '<h2>Wrong input, try again</h2>';
				
				}
				else
				{
					if((isset($_GET['id'])) && (isset($_GET['name'])))
						{
							$id = $_GET['id'];
							$name = $_GET['name'];
							
							echo("<h1>Deletion mode</h1>");
							echo("<div id='form_container'>");
							echo "<h2>Do you want to delete all information about this product?</h2><br/>";
							echo "<h3 align='center'>$name</h3><br/>";
							echo "<p align='center'>To proceed, type <span style='color:#ff0000;'><b>DELETE</b></span> into the form below:</p><br/>";
							echo "<form>
							<input type='hidden' name='action' value='delete'/><input type='hidden' name='id' value='".$id."'/>
							<input type='text' name='confirm' autofocus style='display:block; margin:0 auto;'/>
							<input type='submit' method='post' action='panel.php' value='Submit changes' style='display:block; margin:15px auto;'/>
							</form>";	
							
							echo("</div>");
						}
						else
							echo '<h2>Wrong input, try again</h2>';
						
				}
		
			}
		
			/* ACTION = DELETE */
		
		
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