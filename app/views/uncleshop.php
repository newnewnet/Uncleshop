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

		<div class="container-fluid COLOR-BG">
			<div class="container-top-label FLOAT-LEFT TEXT-LEFT">
				<i class="fa fa-bars" ng-click="WarpTabSlide()"></i>
			</div>
			<div class="container-top-label FLOAT-LEFT TEXT-RIGHT">
				Nuttapon
			</div>
		</div>

		<div class="warp_tab_hide" ng-class="{warp_tab_show: WarpTab}">
			asddf
		</div>

	</body>
</html>