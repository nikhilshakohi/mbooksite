<?php
session_start();
date_default_timezone_set("Asia/kolkata");
include 'dbh.php';
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$subject = $_POST['subject'];
	$mailFrom = $_POST['mail'];
	$message = $_POST['message'];

	$mailTo = "nshakohi4@gmail.com";
	$headers = "From: ".$mailFrom;
	$txt ="Hello! from ".$name.".\n\n" . $message;

	mail($mailTo, $subject, $txt, $headers);
	echo "<script>alert('Mail sent.. We'll get back to you soon.. Thank You'); window.location.href='index.php?mail=success';</script>";
}
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
			<label>Username: </label>
			<input type="Username" name="Username" placeholder="Your UserID" required> <br>
			<label>Password: </label>
			<input type="Password" name="Password" placeholder="Passcode" required> <br>
			<input type="submit" name="Loginsubmit" value="Login">	
		</form>
	</div> 
	<div style="text-align: center;">
		<h1>About this Website:</h1>
		<p>This website shares various textbooks</p>
	</div>
	<br><br>
	<?php 
		echo "<div id='aboutcontactform'>";
		echo "<h1>Contact Form</h1>";
		echo "<p>Any queries regarding the functioning of this website or any content related queries can be mailed via this form..</p>";
	?>
		<form class="contact-form" action="about.php" method="POST">
		<input type="text" name="name" placeholder="Full Name" required><br><br>
		<input type="mail" name="mail" placeholder="Your E-mail" required><br><br>
		<input type="subject" name="subject" placeholder="Subject" required><br><br>
		<textarea name="message" placeholder="Your Message" required></textarea><br>
		<button type="submit" name="submit">Send Mail</button><br><br>
	</form>
	<?php	
		echo "</div>";
	?>
</body>
<script>
	document.getElementById('about').style.backgroundColor='lightgreen';
	function loginform() {
		if (document.getElementById('loginform').style.display=="none") {document.getElementById('loginform').style.display="block";} 
		else if (document.getElementById('loginform').style.display=="block") {document.getElementById('loginform').style.display="none";}
	}
</script>
</html>