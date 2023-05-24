<div id="post">
	<div>
		<?php

			include("classes/autoload.php");
			$user = new User();
			$ROW_USER = $user->get_user($ROW['userid']);
			$image = "images/no_profile_male.jpg";
			if($ROW_USER['gender'] == "Female")
			{
				$image = "images/no_profile_female.jpg";
			}
			if(file_exists($ROW_USER['profile_image']))
			{
				$image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
			}

		?>
		<img src="<?php echo $image?>"style="width: 75px;margin-right: 4px; border-radius: 50%;">
	</div>
	<div style="width: 100%;">
		<div style="font-weight:bold;color:lightgreen; width:100%">
			<?php 
			echo"<a href='profile.php?id=$ROW[userid]'>";
			echo htmlspecialchars($ROW_USER['first_name']). " " .htmlspecialchars($ROW_USER['last_name']);
			echo"</a>";
			if($ROW['is_profile_image'])
			{
				$pronoun = "his";
				if($ROW_USER['gender'] == "Female")
				{
					$pronoun = "her";
				}
				echo "<span style='font-weight:normal; color:#aaa'> updated $pronoun profile image</span>";
			}
			if($ROW['is_cover_image'])
			{
				$pronoun = "his";
				if($ROW_USER['gender'] == "Female")
				{
					$pronoun = "her";
				}
				echo "<span style='font-weight:normal; color:#aaa'> updated $pronoun cover image</span>";
			}
			?>
		</div>
		<?php echo htmlspecialchars($ROW['post'])?> 
		<br><br>
		<?php
		if(file_exists( $ROW['image'])) 
		{
			$post_image = $image_class->get_thunb_post($ROW['image']);
			echo "<img scr='$post_image' style ='width100%;'/>";
		}
		?> 
		</br></br>
		<?php
			$likes = "";
			$likes = ($ROW['likes'] > 0) ? "(" .$ROW['likes']. ")" : "";
		?>
	<a href="like.php?type=post&id=<?php echo $likes?>">Like<?php echo $ROW['likes']?></a> . 
	<?php
		$comments = "";
		if($ROW['comments'] > 0)
		{
			$comments = "(" . $ROW['comments'] . ")";
		}



	?>
	<a href="single_post.php?id=<?php echo $ROW['postid']?>">Comment<?php echo $comments?></a> . 
	<span style="color:#999;">
		<?php echo Time::get_time($ROW['date'])?>
	</span>
	<?php
		if($ROW['has_image'])
		{
			echo "<a href='image_view.php?id=$ROW[postid]'>";
			echo ". View Full Image .";
			echo "</a>";
		}

	?>
	 <span style="color:#999; float: right;">
	 	<?php
		 	$post = new Post();
		 	if($post->i_own_post($ROW['postid'], $_SESSION['bublechat_userid']))
		 	{
			 	echo "
			 	<a href='edit.php?id=$ROW[postid]'>
			 		Edit
			 	</a>
			 	<a href='delete.php?id=$ROW[postid]?>'>
			 		Delete
			 	</a>";
		 	}
	 	?>
		</span>
		<?php
		$i_liked = false;
		if(isset($_SESSION['bublechat_userid']))
		{
			$DB = new Database();
			$sql = "selekt likes from likes where type='post' && contentid = '$ROW[postid]' limit 1";
			$result = $DB->read($sql);
			if(is_array($result))
			{
				$likes = json_decode($result[0]['likes'], true);//to make it an array
				$user_ids = array_column($likes,"userid");
				if(!in_array($_SESSION['bublechat_userid'], $user_ids))
				{
					$i_liked = true;
				}
			}
		}
			if($ROW['likes'] > 0)
		 	{
		 		echo "<br/>";
		 		echo"<a href='likes.php?type=posy&id=$ROW[likes]'>";
		 		if($ROW['likes'] == 1)
		 		{
		 			if($i_liked)
		 			{
				 		echo"<div style='text-align:left;'>You liked this post</div>";
				 	}
				 	else
				 	{
				 		echo"<div style='text-align:left;'> 1 person liked this post</div>";
				 	}
				}
				else
				{
					if($i_liked)
					{
						$text = "others";
						if($ROW['likes'] - 1 == 1)
						{
							$otext = "other";
						}
				 		echo"<div style='text-align:left;'>You and" .($ROW['likes'] - 1). " $text liked this post</div>";
				 	}
				 	else
				 	{
				 		echo"<div style='text-align:left;'>" . $ROW['likes'] . "other liked this post</div>";
				 	}
				}
				echo "</a>";
			}
		 ?>
	</div>
</div>
