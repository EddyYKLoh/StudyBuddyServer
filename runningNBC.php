<?php
	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		
		$userPreferredMeetingType = $_POST['userPreferredMeetingType'];
		$levelOfStudyPreference = $_POST['levelOfStudyPreference'];
		$postID = $_POST['postID'];
		$subjects = $_POST['subjects'];
		$subjectsArray = explode("\n", $subjects);
		echo sizeof($subjectsArray);
				
		$checkUserMeetPref = null;
		$checkUserLevel = null;
		$checkRating = null;
		$checkNoOfHelp = null;
		
		$meetingTypeInput = null;
		$levelOfStudyPreferenceInput = null;
		$ratingInput = null;
		$seldomHelpInput = null;
		
	
	require_once "dbConnect.php";
	
	for ($x = 0; $x < sizeof($subjectsArray); $x++) {
	echo $x;
	$sql = "SELECT * FROM subjectassignment 
			JOIN subject ON subject.subjectID = subjectassignment.subjectID
			JOIN user ON user.userID = subjectassignment.userID
			WHERE subjectTitle = '$subjectsArray[$x]'";
			
	echo $subjectsArray[$x];
				
	$result = mysqli_query($con,$sql);
		
	
		if($result->num_rows > 0) {
				
			while ($row = $result -> fetch_assoc()){
				 
				$checkUserMeetPref = $row["meetingType"];
				$checkUserLevel = $row["lvlOfStudy"];
				$checkRating = $row["rating"];
				$checkNoOfHelp = $row["noOfHelp"];
				$userID = $row["userID"];
				
				echo $userID;
				
				if($checkUserMeetPref == $userPreferredMeetingType){
					$meetingTypeInput = "match";
				} else {
					$meetingTypeInput = "xmatch";
				}
				
				if($checkUserLevel == $levelOfStudyPreference){
					$levelOfStudyPreferenceInput = "match";
				} else {
					$levelOfStudyPreferenceInput = "xmatch";
				}
				
				if($checkRating < 3.0){
					$ratingInput = "low";
				} else {
					$ratingInput = "high";
				}
				
				if($checkNoOfHelp < 3){
					$seldomHelpInput = "seldom";
				} else {
					$seldomHelpInput = "alot";
				}
								
				exec ( "java.exe -jar StudyBuddyNBC.jar '$meetingTypeInput' '$levelOfStudyPreferenceInput' '$ratingInput' '$seldomHelpInput'", $javaResult );
				
				if($javaResult[2] == "Suitable"){
					$sql2 = "INSERT INTO matchresult (postID, userID) 
						VALUES('$postID','$userID') 
						ON DUPLICATE KEY UPDATE postID ='$postID', userID = '$userID'";
					if(mysqli_query($con,$sql2)){
						echo "Succesful.";
					}else{
						echo "Insert failed.";
					}
				}else if($javaResult[2] == "Not suitable"){ 
					echo "Not suitable";
				} else {
					echo "Java file error";
				}
				
				
			echo "\n";
			}
		
		} else{
			echo "No result.";
		}

			
	}
	
		mysqli_close($con);
	}
?>