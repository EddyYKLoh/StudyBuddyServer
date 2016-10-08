<?php

	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$name = $_POST['name'];
		$emailAddress = $_POST['emailAddress'];
		$password = $_POST['password'];
		$gender = $_POST['gender'];
		$levelOfStudy = $_POST['levelOfStudy'];
	 
		require_once "dbConnect.php";
		$sql = "SELECT * FROM user WHERE emailAddress='$emailAddress'";
		$check = mysqli_fetch_array(mysqli_query($con,$sql));
		if(isset($check)){
			echo 'E-mail already exist.';
		}else{ 
			$sql = "INSERT INTO user (name, emailAddress, password, gender, lvlOfStudy) 
				VALUES('$name','$emailAddress','$password','$gender','$levelOfStudy')";
				
			if(mysqli_query($con,$sql)){
				echo 'Successfully registered.';
				$sql2 = "SELECT * FROM user WHERE emailAddress='$emailAddress'";
				$insertedUser = mysqli_fetch_array(mysqli_query($con,$sql2));
				echo "\n";
				echo $insertedUser['userID'];
			}else{
				echo 'Please try again.';
			}
		}
		
		
		
		
		mysqli_close($con);
	}
 
 ?>