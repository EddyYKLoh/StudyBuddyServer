<?php
if($_SERVER['REQUEST_METHOD']=='GET'){


	require_once "dbConnect.php";
		$sql = "SELECT * FROM subject";
		
		$result = mysqli_query($con,$sql);
		
		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()){
			
				echo "".$row["subjectTitle"]."";
				echo "\n";
			}
		
				
		}else{
			echo "Request failed.";
		}
		mysqli_close($con);


		
}
 ?>