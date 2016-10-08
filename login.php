<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
	$email = $_POST['emailAddress'];
	$password = $_POST['password'];

	require_once "dbConnect.php";
	$sql = "SELECT * FROM user where emailAddress='$email' and password='$password'";
	
	$check = mysqli_fetch_array(mysqli_query($con,$sql));
	
	if(isset($check)){
		echo $check['userID'];
		echo "\n";
		echo $check['name'];
		echo "\n";
		echo $check['emailAddress'];
		echo "\n";
		echo $check['password'];
		echo "\n";
		echo $check['gender'];
		echo "\n";
		echo $check['lvlOfStudy'];
		echo "\n";
		echo $check['meetingType'];
		echo "\n";
		echo $check['prefLvlOfStudy'];
		echo "\n";
		echo $check['profPicPath'];
		echo "\n";
		
	}else{
		echo "Invalid email or password.";
	}
	mysqli_close($con);
}
 ?>