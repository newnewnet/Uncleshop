<!doctype html>
<html lang="en" ng-app="uncleshopApp">
	<head>
		<meta charset="UTF-8">
		<title>Upcleshop</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="js/bootstrap.min.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-rc.4/angular.min.js"></script>

		<link rel="stylesheet/less" type="text/css" href="css/styles.less" />

		<script src="js/ng.js"></script>
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

		<button type="button" class="btn btn-danger">
			Action <span class="caret"></span>
		</button>

	</body>
</html>
