<?php
	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		
		$userPreferredMeetingType = $_POST['userPreferredMeetingType'];
		$levelOfStudyPreference = $_POST['levelOfStudyPreference'];
		$postID = $_POST['postID'];
		$subjects = $_POST['subjects'];
		$userID = $_POST['userID'];
		$subjectsArray = explode("\n", $subjects);
		
		$checkUserID=null;
		$checkUserMeetPref = null;
		$checkUserLevel = null;
		$checkRating = null;
		$checkNoOfHelp = null;
		
		$meetingTypeInput = null;
		$levelOfStudyPreferenceInput = null;
		$ratingInput = null;
		$seldomHelpInput = null;
				
		$file = 'NBCLog.txt';
		
	
	require_once "dbConnect.php";
	
	for ($x = 0; $x < sizeof($subjectsArray); $x++) {

	$sql = "SELECT * FROM subjectassignment 
			JOIN subject ON subject.subjectID = subjectassignment.subjectID
			JOIN user ON user.userID = subjectassignment.userID
			WHERE subjectTitle = '$subjectsArray[$x]'";
			
	$current = file_get_contents($file);
	$current .= "\r\n".$subjectsArray[$x]."\r\n";
	file_put_contents($file, $current);
					
	$result = mysqli_query($con,$sql);
		
	
	if($result->num_rows > 0) {
				
			while ($row = $result -> fetch_assoc()){
				 
				$checkUserMeetPref = $row["meetingType"];
				$checkUserLevel = $row["lvlOfStudy"];
				$checkRating = $row["rating"];
				$checkNoOfHelp = $row["noOfHelp"];
				$checkUserID = $row["userID"];
				
				$current = file_get_contents($file);
				$current .= $checkUserID."-";
				file_put_contents($file, $current);
		
				
			if($userID != $checkUserID ){
				if($checkUserMeetPref == $userPreferredMeetingType){
					$meetingTypeInput = "match";
				} else {
					$meetingTypeInput = "xmatch";
				}
				
				$current = file_get_contents($file);
				$current .= $meetingTypeInput." ";
				file_put_contents($file, $current);
				
				
				if($checkUserLevel == $levelOfStudyPreference){
					$levelOfStudyPreferenceInput = "match";
				} else {
					$levelOfStudyPreferenceInput = "xmatch";
				}
				
				$current = file_get_contents($file);
				$current .= $levelOfStudyPreferenceInput." ";
				file_put_contents($file, $current);
								
				if($checkRating < 3.0){
					$ratingInput = "low";
				} else {
					$ratingInput = "high";
				}
				
				$current = file_get_contents($file);
				$current .= $ratingInput." ";
				file_put_contents($file, $current);
				
				
				if($checkNoOfHelp < 3){
					$seldomHelpInput = "seldom";
				} else {
					$seldomHelpInput = "alot";
				}
				
				$current = file_get_contents($file);
				$current .= $seldomHelpInput."\r\n";
				file_put_contents($file, $current);
				
						
				exec ( "java.exe -jar StudyBuddyNBC.jar $meetingTypeInput $levelOfStudyPreferenceInput $ratingInput $seldomHelpInput", $javaResult );
				
				
				if($javaResult[2] == "Suitable"){
					$sql2 = "INSERT INTO matchresult (postID, userID) 
						VALUES('$postID','$checkUserID') 
						ON DUPLICATE KEY UPDATE postID ='$postID', userID = '$checkUserID'";
					if(mysqli_query($con,$sql2)){
						$current = file_get_contents($file);
						$current .= "Succesful."."\r\n";
						file_put_contents($file, $current);
						
						$javaResult = null;
					}else{
						$current = file_get_contents($file);
						$current .= "Insert failed."."\r\n";
						file_put_contents($file, $current);
						
					}
				}else if($javaResult[2] == "Not suitable"){ 
					$current = file_get_contents($file);
					$current .= "Not suitable."."\r\n";
					file_put_contents($file, $current);
				
					$javaResult = null;
				} else {
					$current = file_get_contents($file);
					$current .= "Java file error."."\r\n";
					file_put_contents($file, $current);
				}
				
				
			} else {
				$current = file_get_contents($file);
				$current .= "Current user."."\r\n";
				file_put_contents($file, $current);
			}
		

				
			}		
				
			
			
		
	} else{
			$current = file_get_contents($file);
			$current .= "No result."."\r\n";
			file_put_contents($file, $current);
		}

			
	}
	
		echo "END";
		mysqli_close($con);
	}
?>