<?php
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$userID = $_POST['userID'];
		$postRequestString = null;
		$first = true;
		
		require_once "dbConnect.php";
		$sql = "SELECT * FROM matchresult 
			JOIN publicpost ON matchresult.postID = publicpost.publicPostID
			JOIN user ON publicpost.userID = user.userID
			WHERE matchresult.userID = '$userID'";
			
		$result = mysqli_query($con,$sql);
		
		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()){
				if($first){
					echo "".$row["name"]."";
					echo ".";
					echo "".$row["publicPostTitle"]."";
					$first = false;
				}else{
					echo "\n";
					echo "".$row["name"]."";
					echo ".";
					echo "".$row["publicPostTitle"]."";
				
				}
				
			}
		
		}
	
	mysqli_close($con);
	}
 
 ?>