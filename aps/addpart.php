<?php
	include 'php/CheckSession.php';
	include 'php/CheckAdmin.php';

	if ($_SESSION['admin'] != 1){
		header('Location: unauthorized.php');
	}
?>
<html ng-app="addpart" lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-language" content="en" />
	<meta name="google" content="notranslate" />
	
	<title>Auto Parts Store - Add Part</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	
	<link rel="icon" type="image/png" href="img/favicon.ico" />

	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/angular.min.js"></script>
	<script type="text/javascript" src="js/totop.js"></script>
	<script type="text/javascript" src="js/validator.min.js"></script>
    <script type="text/javascript" src="js/jquery.mask.min.js"></script>
</head>

<body ng-controller="addpartCtrl">
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
						Auto Parts Store  
					</span>
				</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Buy Parts</a></li>

					<?php if($_SESSION['admin'] == 1) : ?>

					<li><a href="allparts.php">All Parts</a></li>
					<li class="active"><a href="addpart.php">Add Part</a></li>
					<li><a href="updatepart.php">Update Part</a></li>
					<!--<li><a href="deletepart.php">Delete Part</a></li>-->

					<?php endif; ?>

					<li><a href="about.php">About</a></li>
					<!--<li><a href="usercart.php">Cart</a></li>-->
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="usercart.php" class="navbar-brand">
							<span class="glyphicon glyphicon-shopping-cart"></span> <?php include 'php/GetCartItemCount.php' ?>
						</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hello, <?php echo $_SESSION['sess_username'] ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="history.php">Order History</a></li>
							<li class="divider"></li>
							<li><a href="#" onclick="$('#logoutModal').modal('show');"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		                </ul>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>
	
	<div class="container">	
		<div>
			<form class="form-horizontal" id="addform" name="addform" enctype="multipart/form-data" data-toggle="validator">
				<!--
				<div class="form-group">
					<label class="control-label col-sm-2" for="carMake">Select Make:</label>
					<div class="col-sm-10">
						<select class="form-control" id="carMake" name="carMake" ng-model="formData.carMake" ng-change="getCarModel()" required> 
							<option value="">Select Make</option>
							<option class="ng-cloak" ng-repeat="a in make" value={{a.Make}}>{{a.Make}}</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="carModel">Select Model:</label>
					<div class="col-sm-10">
						<select class="form-control" id="carModel" name="carModel" required> 
							<option value="">Select Model</option>
							<option class="ng-cloak" ng-repeat="a in model" value={{a.Model}}>{{a.Model}}</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="carMinYear">Enter Min Year:</label>
					<div class="col-sm-10">
						<input type="text" pattern="\d*" minlength="4" maxlength="4" class="form-control" id="carMinYear" name="carMinYear" placeholder="Car Model Minimum Year" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="carMaxYear">Enter Max Year:</label>
					<div class="col-sm-10">
						<input type="text" pattern="\d*" minlength="4" maxlength="4" class="form-control" id="carMaxYear" name="carMaxYear" placeholder="Car Model Maximum Year" required>
					</div>
				</div>
				-->
				<div class="form-group">
					<label class="control-label col-sm-2" for="partno">PartNo:</label>
					<div class="col-sm-10">
						<input minlength="1" maxlength="10" type="text" class="form-control" id="partno" name="partno" placeholder="Part Number" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-2" for="pimage">Part Image:</label>
					<div class="col-sm-10">
						<input accept="image/*" type="file" id="pimage" name="pimage" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="pname">Part Name:</label>
					<div class="col-sm-10">
						<input minlength="1" maxlength="50" type="text" class="form-control" id="pname" name="pname" placeholder="Part Name" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="pcompany">Part Company:</label>
					<div class="col-sm-10">
						<input minlength="1" maxlength="50" type="text" class="form-control" id="pcompany" name="pcompany" placeholder="Part Company" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="pprice">Part Price:</label>
					<div class="col-sm-10 hide-inputbtns">
						<div class="input-group"> 
							<span class="input-group-addon">$</span>
        					<input type="number" value="0.00" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="pprice" name="pprice" placeholder="Part Price" required/>
        				</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="psubcatid">Part Subcategory:</label>
					<div class="col-sm-10">
						<select class="form-control" id="psubcatid" name="psubcatid" required>
							<option value="">Part Subcategory</option>
							<option class="ng-cloak" ng-repeat="a in cats" value={{a.SubCat}}>{{a.SubCat}}</option>
						</select>
					</div>
				</div> 
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="pwarrantyid">Part Warranty:</label>
					<div class="col-sm-10">
						<select class="form-control" id="pwarrantyid" name="pwarrantyid" required> 
							<option value="">Part Warranty</option>
							<option class="ng-cloak" ng-repeat="a in warrn" value={{a.WarrantyID}}>{{a.Type}}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input class="btn btn-primary" id="submit" name="submit" type="submit" value="Add"/>
					</div>
				</div>
			</form>

			<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left">
				<span class="glyphicon glyphicon-chevron-up"></span>
			</a>
		</div>		
	</div>

	<div class="modal fade success-popup" id="succadd" tabindex="-1" role="dialog" aria-labelledby="succaddLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="succaddLabel">Add Part</h4>
          </div>
          <div class="modal-body text-center">
            <p class="lead"><img src='img/success.png'/><br/>Add Part Successfull!</p>
            <a href="#" onclick="$('#addform')[0].reset();$('#succadd').modal('hide');" class="rd_more btn btn-default">Close</a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade success-popup" id="failadd" tabindex="-1" role="dialog" aria-labelledby="failaddLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="failaddLabel">Add Part</h4>
          </div>
          <div class="modal-body text-center">
            <p class="lead"><img src='img/fail.png'/><br/>Add Part Unsuccessfull! <br/> <span id="failaddstatus"></span></p>
            <a href="#" onclick="$('#failadd').modal('hide');" class="rd_more btn btn-default">Close</a>
          </div>
        </div>
      </div>
    </div>

	<div class="modal fade success-popup" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="logoutModalLabel">Logout</h4>
          </div>
          <div class="modal-body text-center">
            <p class="lead">Are you sure you want to logout?</p>
            <a href="php/logout.php" onclick="$('#logoutModal').modal('hide');" class="rd_more btn btn-danger">Ok</a>
            <a href="#" onclick="$('#logoutModal').modal('hide');" class="rd_more btn btn-success">Cancel</a>
          </div>
        </div>
      </div>
    </div>
		
	<script>
		$(function(){
        	$("#carMinYear").mask("9999");
        	$("#carMaxYear").mask("9999");

        	$("#addform").submit(function(e) {
        		e.preventDefault();
    			e.stopPropagation();

        		if(!$('#submit').hasClass('disabled')) {
					var img = $('#pimage').val();
					var forms = ($(this).serialize());

					$.ajax({
						type:"POST",          
						url: "php/AddPart.php",
						data: new FormData( this ),
						processData: false,
					    contentType: false,
						success: function(result){
							if(result['Status'] == "SUCCESS") {
								$('#succadd').modal('show');
							}
							else {
								//console.log(result['Status']);
								$('#failaddstatus').text(result['Status']);
								$('#failadd').modal('show');
							}
						} 
					});
				}
			});
      	});

		var app = angular.module('addpart', []);
		
		app.controller('addpartCtrl', function($scope, $http) {
			$scope.getCarMake = function() {
				$http.get("php/GetCarMakeInfo.php").then(function (response) {$scope.make = response.data.records;});
			};
			
			$scope.getCarModel = function() {
				var make = $('#carMake').val();
				$http.get("php/GetCarModelInfo.php",{params:{"make": make}}).then(function (response) {$scope.model = response.data.records;});
			};
			
			$scope.getPartSubCat = function() {
				$http.get("php/GetPartSubCat.php").then(function (response) {$scope.cats = response.data.records;});
			};
			
			$scope.getPartWarranty = function() {
				$http.get("php/GetPartWarranty.php").then(function (response) {$scope.warrn = response.data.records;});
			};

			$scope.getCarMake();
			$scope.getPartSubCat();
			$scope.getPartWarranty();
		});
	</script>
</body>
</html>