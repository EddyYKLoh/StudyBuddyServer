<?php
	
	if($_SERVER['REQUEST_METHOD']=='GET'){
		
		$postRequestString = null;
		$first = true;
		require_once "dbConnect.php";
		$sql = "SELECT * FROM publicpost
			JOIN user ON publicpost.userID = user.userID
			ORDER BY publicpost.createdAt DESC;";
			
		$result = mysqli_query($con,$sql);
		
		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()){
				if($first){
					echo "".$row["name"]."";
					echo "<SEPARATE>";
					echo "".$row["publicPostTitle"]."";
					echo "<SEPARATE>";
					echo "".$row["profPicPath"]."";
					$first = false;
				}else{
					echo "\n";
					echo "".$row["name"]."";
					echo "<SEPARATE>";
					echo "".$row["publicPostTitle"]."";
					echo "<SEPARATE>";
					echo "".$row["profPicPath"]."";
				
				}
				
			}
		
		}
	
	mysqli_close($con);
	}
 
 ?>