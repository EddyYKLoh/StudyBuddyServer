<?php 
 
 define('HOST','localhost');
 define('USER','root');
 define('PASS','lohyoongkeat');
 define('DB','studybuddy');
 
 $con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to connect to the database');
 
 ?>