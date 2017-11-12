<html ng-app="delpart" lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-language" content="en" />
	<meta name="google" content="notranslate" />
	
	<title>Auto Part Store</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	
	<link rel="icon" type="image/png" href="img/favicon.ico" />
</head>

<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">
					<span style="padding-right: 10px">
						<img alt="Brand" src="./img/favicon.ico">
						Auto Part Store  
					</span>
				</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Get Parts</a></li>
					<li><a href="addpart.php">Add Part</a></li>
					<li><a href="updatepart.php">Update Part</a></li>
					<li class="active"><a href="deletepart.php">Delete Part</a></li>
					<li><a href="about.php">About</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>
	<div class="container">
		<div ng-controller="delpartCtrl">
			<form class="form-inline">
				<div class="form-group">
					<label for="part">Select PartNo:</label>
					<select class="form-control" id="part" ng-model="string" ng-change="getCarModel()"> 
						<option value="">Select Part</option>
						<option ng-repeat="a in names" value={{a.PartNo}}>{{a.PartNo}}</option>
					</select>
				</div>
				<div class="form-group">
					<button  class="btn btn-primary" id="getPartsInfo" ng-model="button" ng-click="getAllPartInfo()">Submit</button>
				</div>
			</form>
			
			<div ng-repeat="part in parts">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="control-label col-sm-2" for="partno">Part Number:</label>
						<div class="col-sm-10">
							<input minlength="1" maxlength="10" type="text" class="form-control" id="partno" placeholder="Part Number" value={{part.PartNo}} disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="pname">Part Name:</label>
						<div class="col-sm-10">
							<input minlength="1" maxlength="50" type="text" class="form-control" id="pname" placeholder="Part Name" value={{part.Pname}} disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="pcompany">Part Company:</label>
						<div class="col-sm-10">
							<input minlength="1" maxlength="50" type="text" class="form-control" id="pcompany" placeholder="Part Company" value={{part.PCompany}} disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="pprice">Part Price:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="pprice" placeholder="Part Price" value={{part.Price}} disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="psubcatid">Part Sub Category:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="psubcatid" placeholder="Part Sub Category" value={{part.SubCatID}} disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwarrantyid">Part Warranty:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="pwarrantyid" placeholder="Part Warranty" value={{part.WarrantyID}} disabled>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button class="btn btn-primary" ng-model="button" ng-click="deletePart()">Delete</button>
						</div>
					</div>
				</form>
			</div>			
			
			<div class="form-group">
				<div ng-class="resultclass">
					<p ng-repeat="a in result"><strong>>{{a.Status}}</strong></p>
				</div>
			</div>
			
			<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left">
				<span class="glyphicon glyphicon-chevron-up"></span>
			</a>
		</div>		
	</div>
		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/angular.min.js"></script>
		<script type="text/javascript" src="js/totop.js"></script>
		
		<script>
		var app = angular.module('delpart', []);
		
		app.controller('delpartCtrl', function($scope, $http) {
			$scope.getAllParts = function() {
				$http.get("php/GetAllParts.php").then(function (response) {$scope.names = response.data.records;});
			};
			
			$scope.getAllPartInfo = function() {
				$scope.resultclass = "alert";
				$scope.result = "";
				
				var part = $("#part").val();
				$http.get("php/GetAllPartFromPartNo.php",{params:{"part": part}}).then(function (response) {$scope.parts = response.data.records;});
			};
			
			$scope.deletePart = function() {
				var partno = $('#partno').val();
									
			    var queryResult = "";
				
				$http.get("php/DeletePart.php",{params:{"partno": partno}}).then(function (response) {
				    queryResult = JSON.stringify(response.data.records);
					
					if(queryResult == "[{\"Status\":\"SUCCESS\"}]")
					{
						//console.log(queryResult);
						$scope.resultclass = "alert alert-success";
						
						$scope.parts = JSON.parse("{\"records\":[{\"PartNo\":\"\",\"Pname\":\"\",\"PCompany\":\"\",\"Price\":\"\",\"SubCatID\":\"\",\"WarrantyID\":\"\"}]}");
						$scope.getAllParts();
					}
					else 
					{
						//console.log("FAIL: " + queryResult);
						$scope.resultclass = "alert alert-danger";
					}
					
					$scope.result = response.data.records;
				});
			}
			
			$scope.getAllParts();
		});
		</script>
</body>
</html>