<?php
session_start();
date_default_timezone_set('Asia/kolkata');
if (isset($_POST['Loginsubmit'])) {
	include 'dbh.php';
	$uid = mysqli_real_escape_string($conn, $_POST['Username']);
	$pwd = mysqli_real_escape_string($conn, $_POST['Password']);
	if (empty($uid) || empty($pwd)) {
		header("Location:index.php?login=empty");
		exit();
	}
	else {
		$sql = "SELECT * FROM users WHERE user_uid='$uid' && user_pwd='$pwd'";
		$result = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_assoc($result)) {
			$_SESSION['u_id'] = $row['user_id'];
			$_SESSION['u_uid'] = $row['user_uid'];
			$_SESSION['u_pwd'] = $row['user_pwd'];
			$_SESSION['u_firstname'] = $row['user_firstname'];
			$_SESSION['u_lastname'] = $row['user_lastname'];
			header("Location:index.php?login=success");
			exit();
		} else {
			$message = "Wrong Credentials";
			echo "<script type='text/javascript'>alert('$message');window.location.href='index.php';</script>";
			exit();
	}
	}
} 

if(isset($_POST['Logoutsubmit'])) {
	session_unset();
	session_destroy();
	header("Location:index.php?Loggedoutsuccessfully");
	exit();
}

if (isset($_POST['Booksubmit'])) {
	include_once 'dbh.php';
	$date=mysqli_real_escape_string($conn,$_POST['date']);
	$bname=mysqli_real_escape_string($conn,$_POST['bookname']);
	$bcategory=mysqli_real_escape_string($conn,$_POST['bookcategory']);
	$blink=mysqli_real_escape_string($conn,$_POST['booklink']);
	$bdescription=mysqli_real_escape_string($conn,$_POST['bookdescription']);
	$sql1="INSERT INTO books (book_name,book_category,book_link,book_description,date) VALUES ('$bname','$bcategory','$blink','$bdescription','$date')";
	$result1=mysqli_query($conn,$sql1);
	header("Location:index.php?bookuploaded");
	exit();
}


?>

