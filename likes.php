<?php

	
	include("classes/autoload.php");

	$login = new Login();
	$user_data = $login->check_login($_SESSION['bublechat_userid']);
	$USER = $user_data;

	if(isset($_GET['id']) && is_numeric($_GET['id']))
	{
		$profile = new Profile();
		$profile_data = $profile->get_profile($_GET['id']);
		if(is_array($profile_data))
		{
			$user_data = $profile_data[0];
		}
	}

	$Post = new Post();
	$likes = false;
	$ERROR = "";
	if(isset($_GET['id']) && isset($_GET['type']))
	{
		$likes = $Post->get_likes($_GET['id'], $_GET['type']);
	}	
	else
	{
		$ERROR = "No information was found";
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
	<div style="width: 800px;margin:auto;min-height: 400px;">
 
	 	<!--below cover area-->
		<div style="display: flex">
			
			<!--posts area-->
			<div style=";min-height: 400px;flex:2.5; padding: 20px; padding-right: 0px;">
				<div style="border: solid thin #aaa; padding: 10px; background-color: white">
					
					<?php
					$User = new User();
					$image_class = new Image();
					if(is_array($likes))
					{
						foreach($likes as $row)
						{
							$FRIEND_ROW = $User->get_user($row['userid']);
							include("user.php");
						}
					}


					?>
					<br style="clear:both;">
				</div>
			</div>
		</div>
	</div>
</body>
</html>
