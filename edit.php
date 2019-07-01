<?php
session_start();
date_default_timezone_set("Asia/kolkata");
include 'dbh.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="google" content="notranslate">
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Booksite</title>
</head>
<body>
	<header id="header">
		<a id="mainhead" href="index.php">Home</a>
		<a id="about" href="about.php">About</a>
		<?php
		if (!isset($_SESSION['u_id'])) {echo '<a id="loginbutton" onclick="loginform()">Login</a>';}
		if (isset($_SESSION['u_id'])) {echo '<form style="display:inline-flex;" method="POST" action="login.php"> <button id="signoutbutton" type="submit" name="Logoutsubmit">Log Out</button> </form>';} 
		?>		
	</header>
	<div id="loginform" style="display: none;">
		<form method="POST" action="login.php">
			<label>Username: </label> <input type="Username" name="Username" placeholder="Your UserID" required> <br>
			<label>Password: </label> <input type="Password" name="Password" placeholder="Passcode" required> <br>
			<input type="submit" name="Loginsubmit" value="Login">	
		</form>
	</div>
<?php
	if (isset($_POST['editsubmit'])) {
		$ebookid=$_POST['bookid'];
		$ebookname=$_POST['editbookname'];
		$ebookcategory=$_POST['editbookcategory'];
		$ebooklink=$_POST['editbooklink'];
		$ebookdescription=$_POST['editbookdescription'];

		echo "<form method='POST' action='edit.php' style='text-align:center;'> <input type='hidden' name='editedbookid' value=".$ebookid."> <label>Name of the Book: </label><br> <textarea  name='editedbookname' >".$ebookname."</textarea> <br> <label>Book Category: </label> <br> <textarea name='editedbookcategory' >".$ebookcategory."</textarea> <br> <label>Book Drive Link:</label> <br> <textarea name='editedbooklink'>".$ebooklink."</textarea> <br> <label>Book Description: </label> <br> <textarea rows='5' cols='50' name='editedbookdescription'>".$ebookdescription."</textarea> <br> <input type='submit' name='finaledit' value='Edit..'> <input type='submit' name='deletesubmit' value='Delete..' > </form>";
	}
	if (isset($_POST['finaledit'])) {
		$febookid=$_POST['editedbookid'];
		$febookname=$_POST['editedbookname'];
		$febookcategory=$_POST['editedbookcategory'];
		$febooklink=$_POST['editedbooklink'];
		$febookdescription=$_POST['editedbookdescription'];

		$sql="UPDATE books SET book_name='$febookname', book_category='$febookcategory', book_link='$febooklink', book_description='$febookdescription' WHERE book_id='$febookid'";
		$result=mysqli_query($conn,$sql);
		header("Location:index.php");
	}
	if (isset($_POST['deletesubmit'])) {
		$dbookid=$_POST['editedbookid'];

		$sql="DELETE FROM books WHERE book_id='$dbookid'";
		$result=mysqli_query($conn,$sql);
		header("Location:index.php?bookdeleted");
	}
?>