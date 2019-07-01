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
	<div id="content">
		<h1>Welcome <?php if(isset($_SESSION['u_uid'])) {echo $_SESSION['u_firstname']." ".$_SESSION['u_lastname'].",";} ?> to Booksite!</h1>
		<form method="POST" action="search.php"><input style="width: 80%" type="text" name="searchbook" placeholder="Search Book.." required> <input type="submit" name="submitsearch" value="&#128269;"> </form>
		<?php 
		if (isset($_SESSION['u_uid'])) {echo "You are logged in and can make any changes!<br>"."<h3>Add a new book</h3>"; 
			echo '<form id="addbookform" method="POST" action="login.php">
				<input type="hidden" name="date" value= "'.date('y-m-d h:i:s').'";>
				<label>Name of the Book:</label> <input type="name" name="bookname" placeholder="Title of the Book" required><br>
				<label>Book Category:</label> <input type="message" name="bookcategory" placeholder="Class/Stream of the book" required><br>
				<label>Book Drive Link:</label> <input type="message" name="booklink" placeholder="Google drive/Cloud link of document" required><br>
				<label>Book Description:</label> <input style="width:60%;height:50px;" type="message" name="bookdescription" placeholder="About the book" ><br>
				<input type="submit" name="Booksubmit" value="Submit">
			</form>';}
		?>
		<div style='text-align: center;'>
		<?php
			$sql="SELECT * FROM books ORDER BY book_category";
			$result=mysqli_query($conn,$sql);
			$bookcategoryname='randomname';
			echo "The categories available here are:"."<br>";
			$sql1="SELECT * FROM books ORDER BY book_category";
			$result1=mysqli_query($conn,$sql1);
			while ($row1=mysqli_fetch_assoc($result1)) {
				if ($row1['book_category']!=$bookcategoryname) {
					if (($row1['book_category']==ucfirst($bookcategoryname)) || ($row1['book_category']==lcfirst($bookcategoryname)) || ($row1['book_category']==strtolower($bookcategoryname)) || ($row1['book_category']==strtoupper($bookcategoryname)) ) {
					} else {
						echo $row1['book_category']."<br>";
						$bookcategoryname=$row1['book_category'];
					}
				}
			}?> <br> <?php
			while ($row=mysqli_fetch_assoc($result)) {
				echo "<div style='background-color: rgb(235,235,235); margin:10px 0'>";
				if ($row['book_category']!=$bookcategoryname) {
					if (($row['book_category']==ucfirst($bookcategoryname)) || ($row['book_category']==lcfirst($bookcategoryname)) || ($row['book_category']==strtolower($bookcategoryname)) || ($row['book_category']==strtoupper($bookcategoryname)) ) {
						echo "<br>";
					} else {
						echo "<div style='background-color:rgb(200,200,200);padding:10px;width:auto; margin:auto;'>".$row['book_category']."</div>"."<br>";
						$bookcategoryname=$row['book_category'];
					} 
				} else {echo "<br>";}
				?><strong><?php echo $row['book_name']."<br>"; ?></strong> <?php 
				echo "Link: "."<a href='".$row['book_link']."' target='_blank'>".$row['book_link']."</a>"."<br>";
				echo $row['book_description']."<br>";
				echo "<sub>"."(date uploaded: ".$row['date'].")"."</sub>"."<br>"."<br>"; 
				if (isset($_SESSION['u_uid'])) {
					echo "<form method='POST' action='edit.php'> <input type='hidden' name='bookid' value='".$row['book_id']."'> <input type='hidden' name='editbookname' value='".$row['book_name']."'> <input type='hidden' name='editbookcategory' value='".$row['book_category']."'> <input type='hidden' name='editbooklink' value='".$row['book_link']."'> <input type='hidden' name='editbookdescription' value='".$row['book_description']."'> <input type='submit' name='editsubmit' value='Edit/Delete' > </form>";
					}
				echo "<br>"."</div>";
			}	
		?>
		</div>
	</div>
</body>
<footer style="bottom: 0;"></footer>
<script>
	document.getElementById('mainhead').style.backgroundColor='lightgreen';
	function loginform() {
		if (document.getElementById('loginform').style.display=="none") {document.getElementById('loginform').style.display="block"; } 
		else if (document.getElementById('loginform').style.display=="block") {document.getElementById('loginform').style.display="none";}
	}
</script>
</html>