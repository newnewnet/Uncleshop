<!doctype html>
<html lang="en" ng-app="uncleshopApp">
	<head>
		<meta charset="UTF-8">
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Uncleshop</title>

		<!-- Angularjs -->
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
		<!-- <script src="https://code.angularjs.org/1.2.8/angular-animate.min.js"></script> -->

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="js/bootstrap.min.js"></script>

	    <!-- Google Font -->
	    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>

		<!-- Javascript File -->
		<script src="js/ng.js"></script>

		<!-- Font Awesome -->
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

		<link rel="stylesheet/less" type="text/css" href="css/styles.less" />
		<!-- set options before less.js script -->
		<script>
		  less = {
		    env: "development",
		    async: false,
		    fileAsync: false,
		    poll: 1000,
		    functions: {},
		    dumpLineNumbers: "comments",
		    relativeUrls: false,
		    rootpath: ":/a.com/"
		  };
		</script>
		<script src="js/less.js" type="text/javascript"></script>
		<!--script src="less.js"></script-->
	
	</head>

	<body ng-controller="uncleshopController">

		<header >
	      <div class="wrapper">
	        <div class="separate">
	          <div id="logo">
	          	<img src="img/icon-bill.png"/>
	          	<div class="text">Uncleshop</div>
	          </div>
	        </div> 
	    </header>
	    
		<div class="container">
			<!-- <div class="container-top-label FLOAT-LEFT TEXT-LEFT">
				<i class="fa fa-bars" ng-click="WarpTabSlide()"></i>
			</div>
			<div class="container-top-label FLOAT-LEFT TEXT-RIGHT">
				Nuttapon
			</div> -->
			<div class="col-xs-12 col-sm-12 col-md-3" ng-init="tabColor=1">
			    <div class="tabmenu">
			    	<div class="titile-menu"><img src="img/icon-title.png"/>
			    		<span style="line-height: 1em;">เมนูการทำบิล</span>
			    	</div>	
			    	<div class="box"  data-ng-click="tabColor=1"  data-ng-class="{'save-bill':tabColor==1}">
			    		<span class="icon icon1" >
			    			<img src="img/icon-bill.png"/>
			    		</span>
			    		<div class="text">เพิ่มบิล</div>
			    	</div>
			    	<div class="box"  data-ng-click="tabColor=2" data-ng-class="{'amount-bill ':tabColor==2}">
			    		<span class="icon icon2" >
			    			<img src="img/icon-taxes.png"/>
			    		</span>
			    		<div class="text">จำนวนบิลของวันนี้</div>
			    	</div>
			    	<div class="box"  data-ng-click="tabColor=3" data-ng-class="{'pays-who':tabColor==3}">
			    		<span class="icon icon3" >
			    			<img src="img/user-icon.png"/>
			    		</span>
			    		<div class="text">ใครมาจ่ายงวดบ้าง</div>
			    	</div>
			  	</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="box-save-bill" ng-show="tabColor==1">
					<div class="titile">เพิ่มบิล</div>	
					<div class="box-bill"></div>
				</div>

				<div class="box-amount-bill" ng-show="tabColor==2">
					<div class="titile">จำนวนบิลของวันนี้</div>	
					<div class="box-bill"></div>
				</div>

				<div class="box-pays-bill" ng-show="tabColor==3">
					<div class="titile">ใครมาจ่ายงวดบ้าง</div>	
					<div class="box-bill"></div>
				</div>

			</div>
		</div>

		

		<!-- <div class="warp_tab_hide" ng-class="WarpTab">
			asddf
		</div> -->

	</body>
</html>