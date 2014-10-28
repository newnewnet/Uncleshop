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
	    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>

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
		<div class="blur-container" ng-show="menu_slide" ng-click="switchMenu()">
		</div>
		<header ng-show="pageFlug">
			<div class="wrapper">
			  <div class="separate">
			    <div id="logo">
			    	<div class="text" ng-show="pageFlug">
			    		<div class="logo">
			    			<div>
			    				<i class="fa fa-bars" ng-click="switchMenu()" style="cursor: pointer; margin-right: 15px;"></i>
			    				{{loginText}}
			    			</div>
			    		</div>
			    	</div>
			    	<div class="text font-logo logo-2">
			    		Uncleshop
			    	</div>
			    </div>
			  </div>
			  <div class="user" ng-show="pageFlug">
			  	<span>{{admin.admin_name}}</span>
			  	<i class="fa fa-cog icon" ng-click="popupLogout()"></i>
			  	<div class="logout" ng-show="popupLogoutFlug" ng-click="logout()" >Logout</div>
			  </div>
			</div>
	  </header>


		<div class="container" style="margin-bottom: 50px;">
			<!-- ///////////////////////////login///////////////////////////////////// -->
			<div class="box-login"  ng-hide="pageFlug" ng-controller="loginController">
				<div class="row-fluid TEXT-CENTER">
		          <g class="font-logo">Uncleshop</g>
		        </div>
				<input style="margin-top: 5%; margin-bottom: 5px;" class="form-control" type="text" placeholder="Username" ng-model="userName" focus-me="userName_focus">
				<input style="margin-bottom: 15px;" class="form-control" type="Password" placeholder="Password" ng-model="passWord" ng-enter="login()">
				<div class="row-fluid TEXT-CENTER">
					<button type="button" class="btn btn-success" ng-click="login()">LOGIN</button>
				</div>
				<div class="row-fluid TEXT-CENTER" style="position: relative; bottom: -10px; color: #3498db;">
					© Champangam Electronic.
				</div>
			</div>


			<div ng-show="pageFlug" ng-controller="uncleshopController">
				<div class="col-sm-4 col-md-3 con-tabmenu" ng-init="changTab(1);getAdmins();adminDefault();customersDefault();" data-ng-class="{'con-tabmenu-slide':menu_slide==true}">
				    <div class="tabmenu">
				    	<div class="title-menu"><img src="img/icon-title.png"/>
				    		<span style="line-height: 1em;">เมนูการทำบิล</span>
				    	</div>	

				    	<div class="box"  data-ng-click="changTab(1); switchMenu();"  data-ng-class="{'save-bill':tabColor==1}">
				    		<span class="icon icon1" >
				    			<img src="img/icon-11.png"/>
				    		</span>
				    		<div class="text">เพิ่มบิล</div>
				    	</div>

				    	<div class="box"  data-ng-click="changTab(2); switchMenu()" data-ng-class="{'amount-bill':tabColor==2}">
				    		<span class="icon icon2" >
				    			<img src="img/icon-22.png"/>
				    		</span>
				    		<div class="text">ค้นหาบิล</div>
				    	</div>

				    	<div class="box"  data-ng-click="changTab(3); switchMenu()" data-ng-class="{'pays-who':tabColor==3}">
				    		<span class="icon icon3" >
				    			<img src="img/icon-33.png"/>
				    		</span>
				    		<div class="text">การจ่ายบิล</div>
				    	</div>

				    	<div class="box"  data-ng-click="changTab(4); switchMenu()" data-ng-class="{'customer':tabColor==4}">
				    		<span class="icon icon4" >
				    			<img src="img/icon-44.png"/>
				    		</span>
				    		<div class="text">ข้อมูลลูกค้า</div>
				    	</div>

				    	<div class="box"  data-ng-click="changTab(5); switchMenu()" ng-show="admin.admin_status==1" data-ng-class="{'admin':tabColor==5}">
				    		<span class="icon icon5" >
				    			<img src="img/icon-user.png"/>
				    		</span>
				    		<div class="text">ข้อมูลผู้ขาย</div>
				    	</div>
				  	</div>
				</div>

				<div class="box-save-bill col-xs-12 col-sm-12 col-md-9" ng-show="tabColor==1">
					<div class="title">
						<div class="TEXT-LEFT sub-title-left">
							ข้อมูลลูกค้า
						</div>
						<div class="TEXT-RIGHT sub-title-right" ng-click="switchDataCustomer()" ng-hide="DataCustomer_toggle">
							<div class="plus-user CURSOR">
								<i class="fa fa-plus-circle CURSOR" style="font-size: 18px"></i>
								<img src="img/icon-user.png"/>
							</div>
						</div>
						<div class="TEXT-RIGHT sub-title-right" ng-click="switchDataCustomer()" ng-show="DataCustomer_toggle">
							<i class="fa fa-search CURSOR" style="margin-top: -10px; color: #3498db"></i>
						</div>
					</div>	
					<div class="box-bill">
						<div class="form-horizontal">
							<div class="form-group" ng-hide="DataCustomer_toggle">
								<!-- <label class="col-sm-4 col-md-4 control-label">ค้นหาลูกค้า</label> -->
							    <div class="col-xs-offset-3 col-xs-6 col-sm-6 col-md-6 input-group">
								  <input placeholder="ค้นหาลูกค้า" type="text" ng-model="search.data" class="form-control" ng-keyup="seachCustomers()" focus-me="search_focus" style="font-size: 20px;">
								  <span class="input-group-addon CURSOR" ng-click="seachCustomers()"><i class="fa fa-search" style="color: #3498db"></i></span>
								</div>
							</div>

							<div ng-repeat="(key, data) in DataCustomers">
								<div class="resultUser"style="background-color: white;">
									<div class="icon">
										<img src="img/icon-44.png" ng-show="data.customers_sex == 'male'"> <!-- male -->
										<img src="img/icon-user.png" ng-show="data.customers_sex == 'female'"> <!-- female -->
									</div>
									<div class="text">
										<span class="name">{{data.customers_name + ' ' + data.customers_last_name}}</span>
										<span class="tel">TEL.</span><span class="tel-data">{{data.customers_tel}}</span>
										<span class="id">ID.</span><span class="id-data">{{data.customers_id}}</span>																	
									</div>
								</div>
							</div>

							<div ng-show="DataCustomer_toggle">
								<div class="form-group">
									<label class="col-sm-4 col-md-4 control-label">เลขบัตรประชาชน</label>
								    <div class="col-sm-5 col-md-5">
								    	<input type="textbox" ng-model="customersId" maxlength="13" class="form-control" numbers-only="numbers-only" focus-me="customers_id_focus" ng-keyup="checkCustomersId(customersId)" ng-class="customersError[0]">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ชื่อ</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" ng-model="customersName" class="form-control" ng-class="customersError[1]">
									</div>
									<label class="col-sm-1 col-md-1 control-label">สกุล</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" ng-model="customersLastName" class="form-control" ng-class="customersError[2]">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">เบอร์โทร</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" ng-model="customersTel" class="form-control" numbers-only="numbers-only" ng-model="customersTel" maxlength="10" ng-class="customersError[3]">
									</div>
									<label class="col-sm-1 col-md-1 control-label">เพศ</label>
									<div class="col-sm-2 col-md-2">
										<select class="form-control" ng-model="customersSex">
								          	<option value="male">ชาย</option>
								        	<option value="female">หญิง</option>          
								        </select>
							        </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ที่อยู่</label>
								    <div class="col-sm-9 col-md-9">
								    	<textarea class="form-control" ng-model="customersAddress" rows="3"  ng-class="customersError[4]"></textarea>
									</div>
								</div>
								<div class="col-sm-offset-10 col-sm-2 col-md-offset-10 col-md-2">
									<button type="button" class="btn btn-primary button-primary" ng-click="addCustomers()">เพิ่ม</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="box-amount-bill col-xs-12 col-sm-12 col-md-9" ng-show="tabColor==2">
					<div class="title">ค้นหาบิล</div>	
					<div class="box-bill"></div>
				</div>

				<div class="box-pays-bill col-xs-12 col-sm-12 col-md-9" ng-show="tabColor==3">
					<div class="title">ข้อมูลการจ่ายบิล</div>	
					<div class="box-bill"></div>
				</div>

				<div class="box-pays-bill col-xs-12 col-sm-12 col-md-9" ng-show="tabColor==4">
					<div class="title">ข้อมูลลูกค้า</div>	
					<div class="box-bill"></div>
				</div>

				<div class="box-super-admin col-xs-12 col-sm-12 col-md-9" ng-show="tabColor==5">
					<div class="title">
						<div class="TEXT-LEFT sub-title-left">
							ข้อมูลผู้ขาย
						</div>
						<div class="TEXT-RIGHT sub-title-right" ng-click="switchDataAdmin()" ng-hide="adminToggle">
							<div class="plus-user CURSOR">
								<i class="fa fa-plus-circle CURSOR" style="font-size: 18px"></i>
								<img src="img/icon-user.png"/>
							</div>
						</div>
						<div class="TEXT-RIGHT sub-title-right" ng-click="switchDataAdmin()" ng-show="adminToggle">
							<i class="fa fa-search CURSOR" style="margin-top: -10px; color: #3498db"></i>
						</div>
					</div>		
					<div class="box-bill" >
						<div class="form-horizontal">
							<div ng-hide="adminToggle" ng-repeat="admin in admins" class="resultUser" ng-click="editAdmin($index)">
								<div class="icon">
									<img src="img/icon-44.png" ng-show="admin.admin_sex == 'male'"> <!-- male -->
									<img src="img/icon-user.png" ng-show="admin.admin_sex == 'female'"> <!-- female -->
								</div>
								<div class="text">
									<span class="name">{{admin.admin_name + ' ' + admin.admin_last_name}}</span>
									<span class="tel">TEL.</span><span class="tel-data">{{admin.admin_tel}}</span>
									<span class="id">ID.</span><span class="id-data">{{admin.admin_id}}</span>																	
								</div>
							</div>
							<div ng-show="adminToggle">
								<div class="form-group">
									<label class="col-sm-4 col-md-4 control-label">เลขบัตรประชาชน</label>
								    <div class="col-sm-5 col-md-5">
									   	<input type="textbox" ng-model="adminId" maxlength="13" class="form-control" ng-class="adminError[0]" numbers-only="numbers-only" focus-me="admin_id_focus" ng-keyup="checkAdminId()" ng-disabled="adminIdDisabled">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">Username</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" ng-model="adminUserName" class="form-control " ng-keyup="checkAdminUserName()" ng-class="adminError[1]">
									</div>
									<label class="col-sm-2 col-md-2 control-label">Password</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="password" ng-model="adminPassword" class="form-control" ng-keyup="checkAdminPassword()" ng-class="adminError[2]">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ชื่อ</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" ng-model="adminName" class="form-control">
									</div>
									<label class="col-sm-2 col-md-2 control-label">สกุล</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" ng-model="adminLastName" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">เบอร์โทร</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="textbox" ng-model="adminTel" class="form-control" numbers-only="numbers-only" ng-model="tel" maxlength="10">
									</div>
									<label class="col-sm-2 col-md-2 control-label">เพศ</label>
									<div class="col-sm-2 col-md-2">
										<select class="form-control" ng-model="adminSex">
							   	            <option value="male">ชาย</option>
								        	<option value="female">หญิง</option>          
								        </select>
							        </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ที่อยู่</label>
								    <div class="col-sm-10 col-md-10">
								    	<textarea class="form-control" ng-model="adminAddress" rows="3"></textarea>
									</div>
								</div>

								<div class="row"> <!-- col-xs-col-6 col-sm-offset-9 col-sm-col-2 -->
									<div style="float: right;">
										<button type="button" class="btn btn-danger " ng-click="removeAdmin()" ng-hide="editFlug">ลบ</button>
										<button type="button" class="btn btn-success" ng-click="register(2)" ng-hide="editFlug">แก้ไข</button>
										<button type="button" class="btn btn-primary" ng-click="register(1)" ng-show="editFlug">เพิ่ม</button>
									</div>
								</div>		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>