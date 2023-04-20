<div style="min-height: 400px; width: 100%; background-color: white;">
	<div style="padding: 20px;">
	<?php

	$DB = new Database();
	$login = new Login();
	$user_data = $login->check_login($_SESSION['bublechat_userid']);
	$sql = "select image, postid from posts where has_image = 1 && userid = $user_data[userid] order by id desc limit 30";
	$images = $DB->read($sql);
	$image_class = new Image();
	if(is_array($images))
	{
		foreach($images as $image_row)
		{
			echo "<a href='single_post.php?id='$image_row[postid]' >";
			echo "<img scr='".$image_class->get_thumb_post($images_row['image'])."' style='width:100%; margin:10px;'/>";
			echo "</a>";
		}
	}	
	else
	{
		echo "No images were found!";
	}

	?>
</div>