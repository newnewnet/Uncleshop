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
		<script src="js/index.js"></script>
		<script src="js/directive.js"></script>
		<script src="js/constant/angular-local-storage.js"></script>
		<script src="js/login.js"></script>
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

	<body ng-controller="indexController">
		<header>
			<div class="wrapper">
			  <div class="separate">
			    <div id="logo">
			    	<div class="text"><i class="fa fa-bars logo" ng-click="switchMenu()"></i>{{loginText}}</div>
			    </div>
			  </div>
			  <div class="user" ng-show="pageFlug">
			  	<span>{{admin.admin_name}}</span>
			  	<i class="fa fa-cog icon" ng-click="popupLogout()"></i>
			  	<div class="logout" ng-show="popupLogoutFlug" ng-click="logout()" >Logout</div>
			  </div>
			</div>
	  </header>
  
		<div class="container">
			<!-- ///////////////////////////login///////////////////////////////////// -->
			<div class="box-login"  ng-hide="pageFlug" ng-controller="loginController">
				<input type="text" placeholder="username" ng-model="userName"  focus-me="test=true">
				<input type="password" placeholder="password" ng-model="passWord" focus-me="test=fasle">
				<!-- <input type="text" ng-model="test" format="number" /> -->
				<button type="button" class="btn btn-default" ng-click="login()">Login</button>
			</div>

			<div ng-show="pageFlug" ng-controller="uncleshopController">
				<div class="col-md-3 con-tabmenu" ng-init="changTab(1)" data-ng-class="{'con-tabmenu-slide':menu_slide==true}">
				    <div class="tabmenu">
				    	<div class="titile-menu"><img src="img/icon-title.png"/>
				    		<span style="line-height: 1em;">เมนูการทำบิล</span>
				    	</div>	


				    	<div class="box"  data-ng-click="changTab(1); switchMenu();"  data-ng-class="{'save-bill':tabColor==1}">


				    		<span class="icon icon1" >
				    			<img src="img/icon-bill.png"/>
				    		</span>
				    		<div class="text">เพิ่มบิล</div>
				    	</div>


				    	<div class="box"  data-ng-click="changTab(2); switchMenu()" data-ng-class="{'amount-bill ':tabColor==2}">

				    		<span class="icon icon2" >
				    			<img src="img/icon-taxes.png"/>
				    		</span>
				    		<div class="text">ตรวจสอบบิล</div>
				    	</div>

				    	<div class="box"  data-ng-click="changTab(3); switchMenu()" data-ng-class="{'pays-who':tabColor==3}">


				    		<span class="icon icon3" >
				    			<img src="img/user-icon.png"/>
				    		</span>
				    		<div class="text">ข้อมูลการจ่ายบิล</div>
				    	</div>
				  	</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-9">
					<div class="box-save-bill" ng-show="tabColor==1">
						<div class="titile">ข้อมูลลูกค้า</div>	
						<div class="box-bill">
							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4 col-md-4 control-label">เลขบัตรประชาชน</label>
								    <div class="col-sm-5 col-md-5">
								    	<input type="textbox" class="form-control" format="number" ng-model="id">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ชื่อ</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" class="form-control">
									</div>
									<label class="col-sm-1 col-md-1 control-label">สกุล</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">เบอร์โทร</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" class="form-control" format="number" ng-model="tel">
									</div>
									<label class="col-sm-1 col-md-1 control-label">เพศ</label>
									<div class="col-sm-2 col-md-2">
										<select class="form-control" ng-model="sex">
								            <option value="male">ชาย</option>
								        	<option value="female">หญิง</option>          
								        </select>
							        </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ที่อยู่</label>
								    <div class="col-sm-9 col-md-9">
								    	<textarea class="form-control" rows="3"></textarea>
									</div>
								</div>
								<div class="col-sm-offset-10 col-sm-2 col-md-offset-10 col-md-2">
									<button type="button" class="btn btn-primary">Test Submit</button>
								</div>
							</div>
						</div>
					</div>

					<div class="box-amount-bill" ng-show="tabColor==2">
						<div class="titile">ตรวจสอบบิล</div>	
						<div class="box-bill"></div>
					</div>

					<div class="box-pays-bill" ng-show="tabColor==3">
						<div class="titile">ข้อมูลการจ่ายบิล</div>	
						<div class="box-bill"></div>
					</div>
				</div>
			</div>

		</div>


		<!-- <div class="warp_tab_hide" ng-class="WarpTab">
			asddf
		</div> -->

	</body>
</html>