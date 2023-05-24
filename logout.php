<?php

session_start();
if(isset($_SESSION['bublechat_userid']))
{
	$_SESSION['bublechat_userid'] = NULL;
	unset($_SESSION['bublechat_userid']);
}

header("Location: login.php");
