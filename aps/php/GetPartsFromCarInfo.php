<?php
	include 'dbconfig.php';

	$mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
   
  // query for just year
  // query for just make
  // query for just make and model
  // query for just make and year
  // query for just make, model, and year - DONE

   $argument1 = $_GET['make'];
   $argument2 = $_GET['model'];
   $argument3 = $_GET['year'];
   
   //$result = mysqli_query($mysqli, "SELECT PartNo, Pname, PCompany, Price, SubCatID, WarrantyID FROM Part where PartNo in (SELECT PartNo from CarInfo where Make='$argument1' AND Model='$argument2' AND MinYear <= '".(int)$argument3."' AND MaxYear >= '".(int)$argument3."' GROUP BY PartNo) ORDER BY PartNo");
   
   $result = mysqli_query($mysqli, "SELECT r.PartNo, r.Pname, r.PCompany, r.Price, r.SubCatID, coalesce(w.Type, 'No Warranty') as WarrantyID FROM (SELECT PartNo, Pname, PCompany, Price, SubCatID, WarrantyID FROM Part where PartNo in (SELECT PartNo from CarInfo where Make='$argument1' AND Model='$argument2' AND MinYear <= '".(int)$argument3."' AND MaxYear >= '".(int)$argument3."' GROUP BY PartNo)) as r LEFT OUTER JOIN Warranty w  ON coalesce(r.WarrantyID, 'No Warranty') = coalesce(w.WarrantyID, 'No Warranty') ORDER BY PartNo");
   
   $outp = "";
   while($rs = mysqli_fetch_array($result)) {
     if ($outp != "") {$outp .= ",";}
     $outp .= '{"PartNo":"'  . $rs["PartNo"]    . '",';
     $outp .= '"Pname":"'   . $rs["Pname"]    . '",';
     $outp .= '"PCompany":"'  . $rs["PCompany"]   . '",';
     $outp .= '"Price":"'    . $rs["Price"]     . '",';
     $outp .= '"SubCatID":"'   . $rs["SubCatID"]    . '",';
     $outp .= '"WarrantyID":"' . $rs["WarrantyID"]  . '"}';
   }
   
   $outp ='{"records":['.$outp.']}';
   
   mysqli_free_result($result);
   mysqli_close($mysqli);
   
   echo($outp);
?>