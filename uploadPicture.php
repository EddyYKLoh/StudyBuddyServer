<?php

	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$emailAddress = $_POST['emailAddress'];
		$image = $_POST['image'];
		
		require_once "dbConnect.php";
		
		$path = "profilePictures/$emailAddress.jpg";
		$actualpath = "http://192.168.43.103/StudyBuddy/$path";
	 	$sql = "UPDATE user SET profPicPath = '$actualpath' WHERE emailAddress = '$emailAddress'";
				
		if(mysqli_query($con,$sql)){
			if(file_put_contents($path, base64_decode($image))){		
				echo 'Successfully uploaded.';
			} else {
				echo 'Upload failed.';
			}
		}else{	 
			echo 'Request failed.';
		}
		
		mysqli_close($con);
	}
	 
?>