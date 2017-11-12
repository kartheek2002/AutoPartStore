<?php
	include 'dbconfig.php';
	// echo "$dbuser";
	$mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
   
   $partno = $_GET['partno'];
   
   if(empty("$partno") === TRUE)
   {
	   echo "{\"records\":[{\"Status\":\"FAIL: No PartNo.\"}]}";
	   mysqli_close($mysqli);
	   exit();
   }
   else
   {
	   $result = mysqli_query($mysqli, "DELETE FROM CarInfo WHERE PartNo='$partno'");
	   
	   if($result === TRUE) {
		   $presult = mysqli_query($mysqli, "DELETE FROM Part WHERE PartNo='$partno'");
		   
		   if($presult === TRUE) {
			   mysqli_close($mysqli);
				  
			   echo "{\"records\":[{\"Status\":\"SUCCESS\"}]}";
			   exit();
		   }
		   else {
			  mysqli_close($mysqli);
				  
			  echo "{\"records\":[{\"Status\":\"FAIL: Couldn't delete Part.\"}]}";
			  exit();
		   }
	   }
	   else {
		   mysqli_close($mysqli);
				  
			  echo "{\"records\":[{\"Status\":\"FAIL: Couldn't delete from CarInfo.\"}]}";
			  exit();
	   }
   }
   
   mysqli_close($mysqli);
   echo "{\"records\":[{\"Status\":\"FAIL\"}]}";
?>