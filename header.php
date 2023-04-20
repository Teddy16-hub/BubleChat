<!--top bar-->
<?php

	$corner_image = "images/no_profile_male.jpg";
	if(isset($USER)){ 
		if (file_exists($USER['profile_image']))
		{
			$image_class = new Image();
			$corner_image = $image_class->get_thumb_profile($USER['profile_image']);
		}
		else
		{
			if($USER['gender'] == "Female")
			{
				$corner_image = "images/no_profile_female.jpg";
			}
		}
	}
?>
	<div id="color_bar">
		<form method="get" action="search.php">
			<div style="width: 800px; margin: auto;font-size: 30px;">
				<a href="index.php" style="color:black; text-decoration: none;">Buble Chat </a>
				
				&nbsp &nbsp<input type="text" id="search_box" name="find" placeholder="Search for people"/> 
				<a href="profile.php">
				<img src="<?php echo $corner_image?>"style="width: 50px;float: right;">
				</a>
				<a href="Logout.php">
				<span style="font-size:11px; float:right; margin: 10px; color:darkblue;">Logout</span>
				</a>
			</div>	
		</form>	
	</div>