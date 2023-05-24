<div id="post">
	<div>
		<?php
			include("classes/autoload.php");
			$user = new User();
			$Post = new Post();
			$ROW = $Post->get_one_post($_GET['id']);
			$ROW_USER = $user->get_user($ROW['userid']);
			if($ROW_USER['gender'] == "Female")
			{
				$image = "images/no_profile_female.jpg";
			}
			if(file_exists($ROW_USER['profile_image']))
			{
				$image = $image_class->get_thumb_cover($ROW_USER['profile_image']);
			}

		?>
		<img src="<?php echo $image?>"style="width: 75px;margin-right: 4px; border-radius: 50%;">
	</div>
	<div style="width: 100%;">
		<div style="font-weight:bold;color:lightgreen; width:100%">
			<?php 
			echo"<a href='profile.php?id=$COMMENT[userid]'>";
			echo htmlspecialchars($COMMENT_USER['first_name']). " " .htmlspecialchars($COMMENT_USER['last_name']);
			echo"</a>";
			if($COMMENT['is_profile_image'])
			{
				$pronoun = "his";
				if($COMMENT_USER['gender'] == "Female")
				{
					$pronoun = "her";
				}
				echo "<span style='font-weight:normal; color:#aaa;'> updated $pronoun profile image</span>";
			}
			if($COMMENT['is_cover_image'])
			{
				$pronoun = "his";
				if($COMMENT_USER['gender'] == "Female")
				{
					$pronoun = "her";
				}
				echo "<span style='font-weight:normal; color:#aaa;'> updated $pronoun cover image</span>";
			}
			?>
		</div>
		<?php echo htmlspecialchars($COMMENT['post'])?> 
		<br><br>
		<?php
		if(file_exists($COMMENT['image'])) 
		{
			$post_image = $image_class->get_thunb_cover($COMMENT['image']);//$COMMENT['post']
			echo "<img scr='$post_image' style ='width100%;'/>";
		}
		?> 
		</br></br>
		<?php
			$likes = "";
			$likes = ($COMMENT['likes'] > 0) ? "(" .$COMMENT['likes']. ")" : "";
		?>
		<a href="like.php?type=post&id=<?php echo $likes?>">Like<?php echo $COMMENT['likes']?></a> . 
		<a href="single_post.php?id=<?php echo $COMMENT['postid']?>">Comment</a> . <span style="color:#999;">
			<?php echo $COMMENT['date']?>
		</span>
		<?php
			if($COMMENT['has_image'])
			{
				echo "<a href='image_view.php?id=$COMMENT[postid]'>";
				echo ". View Full Image .";
				echo "</a>";
			}
		?>
		<span style="color:#999; float: right;">
		 	<?php
			 	$post = new Post();
			 	if($post->i_own_post($COMMENT['postid'], $_SESSION['bublechat_userid']))
			 	{
				 	echo "
				 	<a href='edit.php'>
				 		Edit
				 	</a>
				 	<a href='delete.php?id=$COMMENT[postid]?>''>
				 		Delete
				 	</a>";
			 	}
		 	?>
		</span>
		<?php 

			$i_liked = false;
			if(isset($_SESSION['mybook_userid']))
			{
				$DB = new Database();
				$sql = "select likes from likes where type='post' && contentid = '$COMMENT[postid]' limit 1";
				$result = $DB->read($sql);
				if(is_array($result))
				{
					$likes = json_decode($result[0]['likes'],true);
					$user_ids = array_column($likes, "userid"); 
					if(in_array($_SESSION['mybook_userid'], $user_ids)){
						$i_liked = true;
					}
				}
			}

			if($COMMENT['likes'] > 0)
			{
				echo "<br/>";
				echo "<a href='likes.php?type=post&id=$COMMENT[postid]'>";
			 	if($COMMENT['likes'] == 1)
			 	{
			 		if($i_liked)
			 		{
			 			echo "<div style='text-align:left;'>You liked this comment </div>";
			 		}
			 		else
			 		{
			 			echo "<div style='text-align:left;'> 1 person liked this comment </div>";
			 		}
			 	}
			 	else
			 	{
			 		if($i_liked)
			 		{
			 			$text = "others";
			 			if($COMMENT['likes'] - 1 == 1)
			 			{
			 				$text = "other";
			 			}
			 			echo "<div style='text-align:left;'> You and " . ($COMMENT['likes'] - 1) . " $text liked this comment </div>";
			 			}
			 			else
			 			{
			 				echo "<div style='text-align:left;'>" . $COMMENT['likes'] . " other liked this comment </div>";
			 			}
			 		}

			 		echo "</a>";

			 	}
			?>
	</div>
</div>
