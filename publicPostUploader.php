<?php

	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$userID = $_POST['userID'];
		$publicPostTitle = $_POST['publicPostTitle'];
		$publicPostDetails = $_POST['publicPostDetails'];
	
		require_once "dbConnect.php";
				
		$sql = "INSERT INTO publicpost (publicPostTitle, publicPostDetails, userID) 
			VALUES('$publicPostTitle','$publicPostDetails','$userID')";
	
		if(mysqli_query($con,$sql)){
			echo 'Please select subject tags.';
			echo "\n";
			echo mysqli_insert_id($con);
			
		}else{
			echo 'Please try again.';
		}
				
		mysqli_close($con);
	}
 
 ?>