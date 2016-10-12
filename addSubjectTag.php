<?php
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$publicPostID = $_POST['publicPostID'];
		$subjects = $_POST['subjects'];
		$subjectsArray = explode("\n", $subjects);
		$allsubjectexistindb = true;
		$currentSubjectID = null;
		
	
		
		require_once "dbConnect.php";
		$sql = "SELECT * FROM publicpost WHERE publicPostID='$publicPostID'";
		$check = mysqli_fetch_array(mysqli_query($con,$sql));
		if(isset($check)){
			
			for ($x = 0; $x < count($subjectsArray); $x++) {
				$sql2 = "SELECT * FROM subject WHERE subjectTitle='$subjectsArray[$x]'";
				$check2 = mysqli_fetch_array(mysqli_query($con,$sql));
				if(!isset($check2)){
					$allsubjectexistindb = false;
					break;
				}
		
			}
		
			
			if($allsubjectexistindb){
				
				for ($x = 0; $x < count($subjectsArray); $x++) {
					
					$sql3 = "SELECT * FROM subject WHERE subjectTitle='$subjectsArray[$x]'";
					$result = mysqli_fetch_array(mysqli_query($con,$sql3));
					
					$currentSubjectID = $result['subjectID'];
				
					$sql4 = "INSERT INTO subjecttag (postID, subjectID ) 
						VALUES('$publicPostID','$currentSubjectID')";
						if(mysqli_query($con,$sql4)){
							if($x == count($subjectsArray)-1){
								echo 'Successfully posted.';
							}
						}else{
							echo 'Database query error.';
							break;
						}
				}
			}else{
					echo 'Error searching for subject in the database.';
			}
			
			
		}else{ 
			echo 'Post do not exist. Please post again.';
		}
		
		
		mysqli_close($con);
	}
 
 ?>