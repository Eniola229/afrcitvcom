<?php
	
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$profile_id = $_SESSION['profile_id'];
	$user_id = $_SESSION['user_id'];
	$user_about = htmlspecialchars($_POST['user_about']);

	include "../classes/dbh.classes.php";
	include "../classes/profileinfo.classes.php";
	include "../classes/profileinfo-contr.classes.php";

	$profileInfo = new ProfileInfoContr($profile_id, $user_id);

	$profileInfo->updateProfileInfo($user_about);
	header("location: ../profile.php?status=none");
}