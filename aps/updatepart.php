<?php
	include 'php/CheckSession.php';
	include 'php/CheckAdmin.php';
	
	if ($_SESSION['admin'] != 1){
		header('Location: unauthorized.php');
	}
?>
<html ng-app="uppart" lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-language" content="en" />
	<meta name="google" content="notranslate" />
	
	<title>Auto Parts Store - Update Part</title>

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

<body id='uppartCtrl' ng-controller="uppartCtrl">
	<?php
	session_start();
	if(!(isset($_SESSION['sess_username']))){
		header('Location: login.html');
	}
	?>
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
					<li><a href="addpart.php">Add Part</a></li>
					<li class="active"><a href="updatepart.php">Update Part</a></li>
					<!--<li><a href="deletepart.php">Delete Part</a></li>-->

					<?php endif; ?>
					
					<li><a href="about.php">About</a></li>
					<!--<li><a href="usercart.php">Cart</a></li>-->
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="usercart.php" class="navbar-brand">
							<span class="glyphicon glyphicon-shopping-cart"></span> <span id="count" class="ng-cloak"> {{ cartitems }} </span>
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
			<form class="form-inline">
				<div class="form-group">
					<label for="part">Select PartNo:</label>
					<select class="form-control" id="part" ng-model="string" ng-change="getCarModel()"> 
						<option value="">Select Part</option>
						<option class="ng-cloak" ng-repeat="a in names" value='{{a.PartNo}}'>{{a.PartNo}}</option>
					</select>
				</div>
				<div class="form-group">
					<button  class="btn btn-default" id="getPartsInfo" ng-model="button" ng-click="getAllPartInfo()">Get Part Info</button>
				</div>
			</form>
			
			<div class="ng-cloak" ng-repeat="part in parts" emit-last-repeater-element>
				<form class="form-horizontal" id="updateform" name="updateform" enctype="multipart/form-data">
					<div class="form-group">
						<label class="control-label col-sm-2" for="partno">Part Number:</label>
						<div class="col-sm-10">
							<input minlength="1" maxlength="10" type="text" class="form-control" id="partno" name="partno" placeholder="Part Number" value="{{part.PartNo}}" readonly required />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="cimage">Current Part Image:</label>
						<div class="col-sm-10">
							<img ng-src='img/{{part.PImage}}' alt='{{ part.Pname }}' height="100" width="100" id="cimage" name="cimage"></img>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="file">Part Image:</label>
						<div class="col-sm-10">
							<input accept="image/*" type="file" id="pimage" name="pimage" />
						</div>
					</div>
						
					<div class="form-group">
						<label class="control-label col-sm-2" for="pname">Part Name:</label>
						<div class="col-sm-10">
							<input minlength="1" maxlength="50" type="text" class="form-control" id="pname" name="pname" placeholder="Part Name" value={{part.Pname}} required />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="pcompany">Part Company:</label>
						<div class="col-sm-10">
							<input minlength="1" maxlength="50" type="text" class="form-control" id="pcompany" name="pcompany" placeholder="Part Company" value={{part.PCompany}} required />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="pprice">Part Price:</label>
						<div class="col-sm-10 hide-inputbtns">
							<div class="input-group"> 
								<span class="input-group-addon">$</span>
								<input type="number" ng-model='number' min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="pprice" name="pprice" placeholder="Part Price" ng-value="{{part.Price.toFixed(2) || 0.00}}" required />
	        				</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="psubcat">Current Subcategory:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="psubcat" name="psubcat" placeholder="Part Sub Category" value={{part.SubCatID}} readonly />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="psubcatid">Part Subcategory:</label>
						<div class="col-sm-10">
							<select class="form-control" id="psubcatid" name="psubcatid">
								<option value="">Part Subcategory</option>
								<option class="ng-cloak" ng-repeat="a in cats" value={{a.SubCat}}>{{a.SubCat}}</option>
							</select>
						</div>
					</div> 
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwarranty">Current Warranty:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="pwarranty" name="pwarranty" placeholder="Part Warranty" value={{part.WarrantyID}} readonly />
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="pwarrantyid">Part Warranty:</label>
						<div class="col-sm-10">
							<select class="form-control" id="pwarrantyid" name="pwarrantyid"> 
								<option value="">Part Warranty</option>
								<option class="ng-cloak" ng-repeat="a in warrn" value={{a.WarrantyID}}>{{a.Type}}</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="quantity">Quantity:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity" value='{{part.Quantity}}' required />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="delete">Delete:</label>
						<div class="col-sm-10 text-left">
							<input style="margin-top: 12px;" type="checkbox" class="" id="delete" name="delete" ng-checked="{{part.Deleted}} == 1" />
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input class="btn btn-primary" id="submit" name="submit" type="submit" value="Update"/>
						</div>
					</div>
				</form>
			</div>

			<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left">
				<span class="glyphicon glyphicon-chevron-up"></span>
			</a>
		</div>		
	</div>

	<div class="modal fade success-popup" id="succUpdate" tabindex="-1" role="dialog" aria-labelledby="succUpdateLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="succUpdateLabel">Update Part</h4>
          </div>
          <div class="modal-body text-center">
            <p class="lead"><img src='img/success.png'/><br/>Update Part Successfull!</p>
            <button ng-model='button' ng-click="updated()" class="rd_more btn btn-default">Close</a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade success-popup" id="failUpdate" tabindex="-1" role="dialog" aria-labelledby="failUpdateLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="failUpdateLabel">Update Part</h4>
          </div>
          <div class="modal-body text-center">
            <p class="lead"><img src='img/fail.png'/><br/>Update Part Failed! <br/> <span id="failUpdateStatus"></span></p>
            <a href="#" onclick="$('#failUpdate').modal('hide');" class="rd_more btn btn-default">Close</a>
          </div>
        </div>
      </div>
    </div>

	<div class="modal fade success-popup" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
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
			
      	});

		var app = angular.module('uppart', []);

		app.directive('emitLastRepeaterElement', function() {
			return function(scope) {
				if (scope.$last){
					scope.$emit('LastRepeaterElement');
				}
			};
		});
		
		app.controller('uppartCtrl', function($scope, $http) {
			$scope.updateCartCount = function() {
				$http.get("php/GetCartItemCount.php",{}).then(function (response) {
				    $scope.cartitems = response.data;
					//$('#count').html($scope.cartitems);
					//console.log($scope.cartitems);
				});
			}

			$scope.getAllParts = function() {
				$http.get("./php/GetAllParts.php").then(function (response) {
					$scope.names = response.data.records;

					setTimeout(function(){
						$scope.updateCartCount();
					}, 50);
				});
			};
			
			$scope.getAllPartInfo = function() {
				var part = $("#part").val();

				$http.get("./php/GetAllPartFromPartNo.php",{params:{"part": part}}).then(function (response) {
					$scope.parts = response.data.records;
					
					$scope.getPartSubCat();
					$scope.getPartWarranty();

					setTimeout(function(){
						$scope.updateCartCount();
					}, 50);
				});

				//$('#message').css("display", "none");
			};

			$scope.$on('LastRepeaterElement', function(){
				$("#updateform").submit(function(e) {
	        		e.preventDefault();
	    			e.stopPropagation();

	        		if(!$('#submit').hasClass('disabled')) {
	        			//console.log("Updating...");

						var img = $('#pimage').val();
						var forms = ($(this).serialize());

						$.ajax({
							type:"POST",          
							url: "php/UpdatePart.php",
							data: new FormData( this ),
							processData: false,
						    contentType: false,
							success: function(result){
								if(result['Status'] == "SUCCESS") {
									//$scope.parts = "";
									//$scope.getAllParts();
									$('#succUpdate').modal('show');
								}
								else {
									//console.log(result['Status']);
									$('#failUpdateStatus').text(result['Status']);
									$('#failUpdate').modal('show');
								}
							} 
						});
					}
				});
				setTimeout(function(){
					$scope.updateCartCount();
				}, 50);
			});

			$scope.getPartSubCat = function() {
				//console.log("Getting Sub Categories...");
				$http.get("./php/GetPartSubCat.php").then(function (response) {$scope.cats = response.data.records;});
			};
			
			$scope.getPartWarranty = function() {
				//console.log("Getting Warranty...");
				$http.get("./php/GetPartWarranty.php").then(function (response) {$scope.warrn = response.data.records;});
			};
			
			$scope.getAllParts();

			$scope.updated = function() {
				setTimeout(function(){
					//console.log("Reset form!");
					//$scope.getAllParts();
					angular.element('#getPartsInfo').triggerHandler('click');
			    }, 0);
				
				$('#succUpdate').modal('hide');
			}
		});
	</script>
</body>
</html>