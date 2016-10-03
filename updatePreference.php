<?php

	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$emailAddress = $_POST['emailAddress'];
		$meetingType = $_POST['meetingType'];
		$preferredLvlOfStudy = $_POST['preferredLvlOfStudy'];
			 
		require_once "dbConnect.php";
		$sql = "UPDATE user SET meetingType='$meetingType', prefLvlOfStudy='$preferredLvlOfStudy' 
			WHERE emailAddress='$emailAddress'";
		if(mysqli_query($con,$sql)){
				echo 'Saved.';
			}else{
				echo 'Please try again.';
			}
		mysqli_close($con);
	}
 
 ?>