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
if (isset($_POST['submitsearch'])) {
	$search=mysqli_real_escape_string($conn,$_POST['searchbook']);
	$sql="SELECT * FROM books WHERE book_name LIKE '%$search%' OR book_link LIKE '%$search%' OR book_description LIKE '%$search%' OR date LIKE '%$search%' OR book_category LIKE '%$search%'";
	$result=mysqli_query($conn,$sql);
	$queryresult=mysqli_num_rows($result);
	echo "There is/are ".$queryresult." book/s found.."."<br>"."<br>";
	echo "<div style='text-align:center;'>";
	if ($queryresult>0) {
		while ($row=mysqli_fetch_assoc($result)) {
				echo $row['book_category']."<br>";
				?><strong><?php echo $row['book_name']."<br>"; ?></strong> <?php 
				echo "Link: "."<a href='".$row['book_link']."' target='_blank'>".$row['book_link']."</a>"."<br>";
				echo $row['book_description']."<br>";
				echo "<sub>"."date uploaded: ".$row['date']."</sub>"."<br>"."<br>"; }
	} else {echo "There are no matching books or its links found...";}
	echo "</div>";
}

?>