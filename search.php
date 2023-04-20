<?php

	
	include("classes/autoload.php");

	$login = new Login();
	$user_data = $login->check_login($_SESSION['bublechat_userid']);

	if(isset($_GET['find']))
	{
		$find = addslashes($_GET['find']);
		$sql = "select * from users where first_name like '%$find%' || last_name like '%$find%' limit 30";
		$DB = new Database();
		$results = $DB->read($sql);
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>People who like| BubleChat</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<link rel="stylesheet" type="text/css" href="project.css">
<style type="text/css"></style>
<body style="font-family:tahoma; background-color: #ffc8c8;">
	<br>

	<!--top bar-->
	<?php include("header.php");?>

	<!--cover area-->
	<div style="width: 800px;margin:auto;">

	
	</div> 
 	<!--below cover area-->
	<div style="display: flex">
		
		<!--posts area-->
		<div style=";min-height: 400px;flex:2.5; padding: 20px; padding-right: 0px;">
			<div style="border: solid thin #aaa; padding: 10px; background-color: white">
				
				<?php
				$User = new User();
				$image_class = new Image();
				if(is_array($results))
				{
					foreach($results as $row)
					{
						$FRIEND_ROW = $User->get_user($row['userid']);
						include("user.php");
					}
				}
				else
				{
					echo "No results were found!";
				}

				?>
				<br style="clear:both;">
			</div>
		</div>
	</div>
</body>
</html>