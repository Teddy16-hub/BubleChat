<div id="friends" style="display: inline-block;">
	<?php

			include("classes/autoload.php");
			$user = new User();
			$FRIEND_ROW = $user->get_user($friend['userid']);
			$image = "images/no_profile_male.jpg";
			if($FRIEND_ROW['gender'] == "Female")
			{
				$image = "images/no_profile_female.jpg";
			}

			if(file_exists($FRIEND_ROW['profile_image']))
			{
				$image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
			}

		?>
	<a href="profile.php?id=<?php echo $FRIEND_ROW['userid']; ?>">
		<img id="friends_img"src="<?php echo $image ?>">
		<br>

		<?php echo $FRIEND_ROW['first_name'] . " " . $FRIEND_ROW['last_name'] ?>
	</a>
</div>
