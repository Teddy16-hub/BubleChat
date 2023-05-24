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
	//posting starts here
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(isset($_POST['first_name']))
		{
			$settings_class = new Settings();
			$settings_class->save_settings($_POST,$_SESSION['bublechat_userid']);
		}
		else
		{
			$post = new Post();
			$id = $_SESSION['bublechat_userid'];
			$result = $post ->create_post($id, $_POST, $_FILES);

			if($result = "")
			{
				header("Location: profile.php");
				die;
			}
			else
			{
				echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey';>";
				echo "<br>The following errors occured!<br><br>";
				echo $result;
				echo "</div>";
			}
		}
	}

	//collect posts
	$post = new Post();
	$id = $user_data['userid'];
	$posts = $post ->get_posts($id);

	//coolect friends
	$user = new User();
	$friends = $user ->get_following($user_data['userid'], "user");

	$image_class = new Image();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile | Buble chat</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<link rel="stylesheet" type="text/css" href="project.css">
<style type="text/css"></style>
<body style="font-family:tahoma; background-color: #ffc8c8;">
	<br>
	<?php include("header.php");?>

	<!--cover area-->
	<div style="width: 800px;margin:auto;min-height: 570px;">
		<div style="background-color: white; text-align: center;color:black">
				<?php
				$mylikes = "";
					$image = "images/cover_image";
					if(file_exists($user_data['cover_image']))
					{
						$image = $image = $image_class->get_thumb_cover($user_data['cover_image']);
					}

				?>
			<img src="<?php echo $image ?>" style="width: 100%">
			<a href="like.php?type=user&id=<?php echo $user_data['userid'] ?>"></a>
			<span style="font-size:12px;">
				<?php
					$image = "images/no_profile_male.jpg";
					if($user_data['gender'] == "Female")
					{
						$image = "images/no_profile_female.jpg";
					}
					if(file_exists($user_data['profile_image']))
					{
						$image = $image_class->get_thumb_profile($user_data['profile_image']);
					}

				?>
				<img id="profile_pic" src=<?php echo $image ?>></br>
				<?php
					$mylikes = "";
					if($user_data['likes'] > 0)
					{
						$mylikes = "(" . $user_data['likes'] . " Followers)";
					}

				?>
				<br>
				<div style="font-size: 20px; color: black;">
				<a href="profile.php?id=<?php echo $user_data['userid']?>" style="font-size: 25px;"><?php?> </div><?php echo $user_data['first_name']. " ". $user_data['last_name']?></a>
				<?php
					$mylikes = $user_data['likes'];

				?>
				<br>
				<a href="like.php?type=user&id=<?php echo $user_data['userid'] ?>"></a>
				<a style="text-decoration: none; font-size: 15px; color:darkgreen;"href="change_profile_image.php?change=profile">Change profile image</a> |
				<a style="text-decoration: none; font-size: 15px; color:darkgreen;"href="change_profile_image.php?change=cover">Change cover image</a>
			</span>
			<br>
				<!--<div style="font-size: 20px; color: black;">
				<a href="profile.php?id=<?//php echo $user_data['userid']?>"><?php?> </div><?//php echo $user_data['first_name']. " ". $user_data['last_name']?></a>
				<?/*php
					$mylikes = $user_data['likes'];*/

				?>-->
				<brs>
				<a href="like.php?type=user&id=<?php echo $user_data['userid'] ?>"></a>
				
				<br>
				<input type="post_button" type="button" value="Followers<?php echo $mylikes?>" style="margin-right:10px; background-color: #9b407a; width: auto;">
				<input type="post_button" type="button" value="Following<?php echo $mylikes?>" style="background-color: #9b407a; width: auto;">
				<br>
			<a href="index.php"><div id="menu_buttons">Timeline</div></a>
			<a href="profile.php?section=abou&id=<?php echo $user_data['userid']?>t"><div id="menu_buttons">About</div></a>
			<a href="profile.php?section=followers&id=<?php echo $user_data['userid']?>"><div id="menu_buttons">Followers</div></a>
			<a href="profile.php?section=following&id=<?php echo $user_data['userid']?>"><div id="menu_buttons">Following</div></a>
			<a href="profile.php?section=photos&id=<?php echo $user_data['userid']?>"><div id="menu_buttons">Photos</div></a>
			<?php
				if($user_data['userid'] == $_SESSION['bublechat_userid'])
				{
					echo '<a href="profile.php?section=settings&id='. $user_data['userid'].'"><div id="menu_buttons">Settings</div></a>';
				}
			?>
		</div> 
 	<!--below cover area-->
 	<?php
 	$section = "default";
	if(isset($_GET['section']))
	{
	 	$section = $_GET['section'];
	}
	if($section == "default")
	{
	 	include("profile_content_default.php");
	 			 
	}
	elseif($section == "following")
	{			
	 	include("profile_content_following.php");

	}
	elseif($section == "followers")
	{
	 	include("profile_content_followers.php");

	}
	elseif($section == "about")
	{
		include("profile_content_about.php");

	} 
	elseif($section == "settings")
	{
	 	include("profile_content_settings.php");

	}
	elseif($section == "photos")
	{
	 	include("profile_content_photos.php");
	}

 	?>
 	</div>
</body>
</html>