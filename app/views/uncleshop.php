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

		<!-- Sweet Alert -->
		<script src="lib-sweet-alert/sweet-alert.js"></script>
		<link rel="stylesheet" href="lib-sweet-alert/sweet-alert.css">

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
			  	<span>{{admin.admin_name | limitTo: 8}}</span>
			  	<i class="fa fa-cog icon" ng-click="popupLogout()"></i>
			  	<div class="logout" ng-show="popupLogoutFlug" ng-click="logout()" >Logout</div>
			  </div>
			</div>
	  </header>


		<div class="container" style="margin-bottom: 50px;" >
			<!-- ///////////////////////////login///////////////////////////////////// -->
			<div class="box-login"  ng-hide="pageFlug" ng-controller="loginController">
				<div class="row-fluid TEXT-CENTER">
		          <g class="font-logo">Uncleshop</g>
		        </div>
				<input style="margin-top: 5%; margin-bottom: 5px;" class="form-control" type="text" placeholder="Username" ng-model="userName" focus-me="userName_focus">
				<input style="margin-bottom: 15px;" class="form-control" type="Password" placeholder="Password" ng-model="passWord" ng-enter="login()">
				<div class="row-fluid TEXT-CENTER">
					<button type="button" class="btn btn-success" style="width: 100px;" ng-click="login()">LOGIN</button>
				</div>
				<div class="row-fluid TEXT-CENTER" style="position: relative; bottom: -10px; color: #3498db;">
					© Champangam Electronic.
				</div>
			</div>

			<div ng-show="pageFlug" ng-controller="uncleshopController" ng-init="init()">
				<div class="col-sm-4 col-md-3 con-tabmenu" data-ng-class="{'con-tabmenu-slide':menu_slide==true}">
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
				    		<div class="text">ต้นหาบิล</div>
				    	</div>

				    	<div class="box"  data-ng-click="changTab(3); switchMenu()" data-ng-class="{'pays-who':tabColor==3}">
				    		<span class="icon icon3" >
				    			<img src="img/icon-33.png"/>
				    		</span>
				    		<div class="text">ประวัติบิล</div>
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
						<div class="TEXT-LEFT sub-title-left CURSOR" ng-click="backToBill()">
							ข้อมูลบิล
						</div>
						<div class="TEXT-RIGHT sub-title-right" ng-click="switchDataCustomer()" ng-hide="DataCustomer_toggle">
							<div class="plus-user CURSOR">
								<i class="fa fa-plus-circle CURSOR" style="font-size: 18px"></i>
								<img src="img/icon-user.png"/>
							</div>
						</div>
						<!-- ********************************** -->
						<div ng-show="DataCustomer_toggle">
							<div class="TEXT-RIGHT sub-title-right" ng-click="switchDataCustomer()" ng-show="DataCustomer_search_toggle">
								<div class="plus-user CURSOR">
									<i class="fa fa-plus-circle CURSOR" style="font-size: 18px"></i>
									<img src="img/icon-user.png"/>
								</div>
							</div>
							<div class="TEXT-RIGHT sub-title-right" ng-click="switchDataCustomer()" ng-hide="DataCustomer_search_toggle">
								<i class="fa fa-search CURSOR" style="margin-top: -10px; color: #3498db"></i>
							</div>
						</div>
					</div>	
					<div class="box-bill"> 
						<div class="form-horizontal" ng-show="DataCustomer_toggle">
							<div class="form-group" ng-show="DataCustomer_search_toggle">						
							    <div class="col-xs-offset-3 col-xs-6 col-sm-6 col-md-6 input-group">
								  <input placeholder="ค้นหาลูกค้า" type="text" ng-model="search.data" class="form-control" ng-keyup="seachCustomers()" focus-me="search_focus" style="font-size: 20px;">
								  <span class="input-group-addon CURSOR" ng-click="seachCustomers()"><i class="fa fa-search" style="color: #3498db"></i></span>
								</div>
							</div>

							<div class="conResult">
								<div ng-repeat="(key, data) in DataCustomers" ng-click="addCustomerToBill($index)">
									<div class="resultUser">
										<div class="wrap">
											<div class="icon">
												<img src="img/icon-44.png" ng-show="data.customers_sex == 'male'">
												<img src="img/icon-user.png" ng-show="data.customers_sex == 'female'">
											</div>
											<div class="text">
												<div class="name">{{data.customers_name}}</div>
												<div class="tel">เบอร์โทร</div><div class="tel-data">{{data.customers_tel}}</div>
												<div class="tel" style="color: #45B39C;">รหัสบัตร</div><div class="tel-data">{{data.customers_id_card}}</div>																	
											</div>
										</div>
									</div>
								</div>
							</div>
							<div ng-hide="DataCustomer_search_toggle">
								<div class="form-group">
									<label class="col-sm-4 col-md-4 control-label">เลขบัตรประชาชน</label>
								    <div class="col-sm-5 col-md-5">
								    	<input type="text" ng-model="customersIdCard" maxlength="13" class="form-control" numbers-only="numbers-only" focus-me="customers_id_focus" ng-keyup="checkCustomersIdCard()" ng-class="customersError[0]">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ชื่อ - สกุล</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="text" ng-model="customersName" class="form-control" ng-class="customersError[1]">
									</div>
									<label class="col-sm-2 col-md-2 control-label">เบอร์โทร</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="text" ng-model="customersTel" class="form-control" numbers-only="numbers-only" ng-model="customersTel" maxlength="10" ng-class="customersError[3]">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ที่อยู่</label>
								    <div class="col-sm-10 col-md-10">
								    	<textarea class="form-control" ng-model="customersAddress" rows="3"  ng-class="customersError[4]"></textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">เพศ</label>
									<div class="col-sm-2 col-md-2">
										<select class="form-control" ng-model="customersSex">
								          	<option value="male">ชาย</option>
								        	<option value="female">หญิง</option>          
								        </select>
							        </div>
								</div>

								<div class="row">
									<div class="col-xs-2 col-xs-offset-5 col-sm-offset-10 col-sm-2 col-md-offset-10 col-md-2">
										<button type="button" class="btn btn-primary button-primary" style="margin-left: -10px;" ng-click="addCustomers()">เพิ่ม</button>
									</div>
								</div>
							</div>
						</div>
						<div class="form-horizontal" ng-show="addProduct_toggle">
							<div class="row" ng-show="DataCustomersOfBill != null" style="margin-bottom: 25px; background-color: white; border-radius: 3px; border-width: 1px; border-color: #1196d1; border-style: solid;">
								<label class="col-xs-4 col-sm-2 control-label" style="color: #e67e22;">เลขบัตร</label>
								<label class="col-xs-8 col-sm-10 control-label" style="text-align: left;">{{DataCustomersOfBill.customers_id_card}}</label>

								<label class="col-xs-4 col-sm-2 control-label" style="color: #45B39C;">ชื่อ - สกุล</label>
								<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{DataCustomersOfBill.customers_name}}</label>								
								<label class="col-xs-4 col-sm-2 control-label" style="color: #1196d1;">เบอร์โทร</label>
								<label class="col-xs-8 col-sm-5 control-label" style="text-align: left;">{{DataCustomersOfBill.customers_tel}}</label>

								<label class="col-xs-3 col-sm-2 control-label" style="color: #8e44ad;">ที่อยู่</label>
								<label class="col-xs-9 col-sm-10 control-label" style="text-align: left;">{{DataCustomersOfBill.customers_address}}</label>
							</div>

							<div class="form-group" ng-repeat="product in productData">
								<div class="row">
									<label class="col-sm-2 col-md-2 control-label" >ชื่อสินค้า</label>
								    <div class="col-sm-3 col-md-3">
								   	 	<input type="text" ng-model="product.productName" class="form-control" ng-class="product.productNameError" ng-keyup="checkProductError($index,'productNameError')" >
									</div>

									<label class="col-sm-1 col-md-1 control-label">ราคา</label>
								    <div class="col-sm-2 col-md-2">
								    	<input type="text" ng-model="product.productPrice" class="form-control TEXT-RIGHT" numbers-only="numbers-only" ng-class="product.productPriceError"  ng-keyup="checkProductError($index,'productPriceError')">
									</div>

									<label class="col-sm-1 col-md-1 control-label" ng-init="product.productAmount = 1">จำนวน</label>
								    <div class="col-sm-2">
								    	<input type="text" ng-model="product.productAmount" class="form-control TEXT-RIGHT"  numbers-only="numbers-only" ng-class="product.productAmountError"  ng-keyup="checkProductError($index,'productAmountError')">
									</div>

									<div class="col-xs-offset-5 col-xs-2 col-sm-offset-0 col-sm-1 col-md-1 CURSOR" ng-show="$index==countProduct-1">
										<i class="fa fa-plus-circle" style="font-size: 26px; color: #45B39C; padding:5px;" ng-click="positiveProduct()"></i>
									</div>
									<div class="col-xs-offset-5 col-xs-2 col-sm-offset-0 col-sm-1 col-md-1 CURSOR" ng-show="$index!=countProduct-1" ng-click="minusProduct($index)">
										<i class="fa fa-times-circle" style="font-size: 26px;color: #e05b49; padding:5px;"></i>
									</div>
								</div>									
							</div>
							<div class="form-group" style="margin-top: 25px; padding-top: 10px;">
								<div class="row">
									<label class="col-sm-2 control-label">เงินดาวน์</label>
								    <div class="col-sm-3">
								    	<input type="text" numbers-only="numbers-only" ng-model="priceDow" class="form-control TEXT-RIGHT" ng-keyup="calBill('priceDow')" ng-class="priceDowError">
									</div>

									<label class="col-xs-12 col-sm-1 control-label" ng-init="timeOfPayment = 1">เวลา</label>
								    <div class="col-xs-6 col-sm-2">
								    	<input type="text" numbers-only="numbers-only" ng-model="timeOfPayment" class="form-control TEXT-CENTER" ng-keyup="calBill('timeOfPayment')" ng-class="timeOfPaymentError">
									</div>

									<div class="col-xs-6 col-sm-2">
										<select class="form-control" ng-model="type_dow" ng-click="calBill()">
								          	<option value="month">เดือน</option>
								        	<option value="week">วิก</option>          
								        </select>
							        </div>
								</div>
								
								<div class="col-xs-12">
									<div class="row" style="margin-top: 25px; box-sizing: border-box; border-top: 1px solid #45B39C; padding: 12px 0px 0px 15px;">
										<div class="row">
											<label class="col-xs-5 col-sm-2 control-label" style="color: #e05b49;">ราคาสินค้า</label>
											<label class="col-xs-5 col-sm-3 control-label TEXT-RIGHT">{{(billData.priceOfAllProduct < 0 ? 0 : billData.priceOfAllProduct | number:0) + '    บาท'}}</label>
											<label class="col-xs-5 col-sm-2 control-label" style="color: #e67e22;">ดอกเบี้ย</label>
											<label class="col-xs-5 col-sm-3 control-label TEXT-RIGHT">{{(billData.interestValue < 0 ? 0 : billData.interestValue | number:0) + '    บาท'}}</label>
										</div>
										<div class="row">
											<label class="col-xs-5 col-sm-2 control-label" style="color: #45B39C;">ราคารวม</label>
											<label class="col-xs-5 col-sm-3 control-label TEXT-RIGHT">{{(billData.priceOfAllProduct < 0 ? 0 : billData.priceOfAllProduct+billData.interestValue | number:0) + '    บาท'}}</label>
											<label class="col-xs-5 col-sm-2 control-label" style="color: #1196d1;">เงินดาวน์</label>
											<label class="col-xs-5 col-sm-3 control-label TEXT-RIGHT">{{(billData.priceDow < 0 ? 0 : billData.priceDow | number:0) + '    บาท'}}</label>
										</div>
										<div class="row">
											<label class="col-xs-5 col-sm-2 control-label" style="color: #8e44ad; text-decoration: underline;">ราคาผ่อนส่ง</label>
											<label class="col-xs-5 col-sm-3 control-label TEXT-RIGHT">{{(billData.priceWithoutDow < 0 ? 0 : billData.priceWithoutDow | number:0) + '    บาท'}}</label>
											<label class="col-xs-5 col-sm-2 control-label" style="color: #45B39C; text-decoration: underline;">ผ่อนชำระ</label>
											<label class="col-xs-5 col-sm-3 control-label" style="text-decoration: underline;">{{billData.priceTermOfPayment | number:0}} {{'   ' + (type_dow == "month" ? "บาท/เดือน" : "บาท/วิก")}}</label>
										</div>								
										<div class="row" style="padding-top: 20px;">
											<div class="col-xs-2 col-xs-offset-3 col-sm-2 col-sm-offset-4">
												<button type="button" class="btn btn-success TEXT-CENTER" ng-click="createBill()">เพิ่ม</button>
											</div>
											<div class="col-xs-3 col-xs-offset-1 col-sm-2 col-sm-offset-0">
												<button type="button" class="btn btn-warning TEXT-CENTER" ng-click="setBillDefault()">ล้าง</button>
											</div>
											<div ng-show="billCode!=null">
												<form action="/send/print_uncleshop" method="post" target="_blank"  >
													<input type="hidden" name="billCode"  value="{{billCode}}"> 
													<input type="submit" class="btn btn-danger TEXT-CENTER" value="ปริ้น">
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="box-save-bill col-xs-12 col-sm-12 col-md-9" ng-show="tabColor==2">
					<div class="title CURSOR" ng-click="backToPayBill()">
						ชำระเงิน
					</div>	
					<div class="box-bill">
						<div class="form-horizontal" ng-show="findPayBill_toggle">
							<div class="form-group">						
							  <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 col-md-6 input-group">
								  <!-- <input placeholder="ค้นหาบิล" type="text" ng-model="searchBill.data" class="form-control" ng-keyup="searchBillForPay()" style="font-size: 20px;">
								  <span class="input-group-addon CURSOR" ng-click="searchBillForPay()"><i class="fa fa-search" style="color: #3498db"></i></span> -->
								  <div class="input-group">
							      <input placeholder="ค้นหาบิล" type="text" ng-model="searchBill.data" class="form-control" ng-init="optionSearchPayBill = 0" ng-keyup="searchBillForPay()" style="font-size: 20px;">
							      <div class="input-group-btn">
							        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="height: 34px; padding-top: 4px;">
								        <!-- ค้างชำระ -->
								        <i class="fa fa-search" style="color: #3498db;"></i>
								        <i class="fa fa-caret-down" style="font-size: 15px;"></i>
								      </button>
							        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="font-size: 20px;">
							          <li ng-click="optionSearchPayBill = 0; searchBillForPay();"><a>ค้นหา <j style="text-decoration: underline;">ค้างชำระ</j></a></li>
							          <li ng-click="optionSearchPayBill = 1; searchBillForPay();"><a>ค้นหา <j style="text-decoration: underline;">ชำระแล้ว</j></a></li>
							          <li ng-click="optionSearchPayBill = 2; searchBillForPay();"><a>ค้นหา <j style="text-decoration: underline;">ทั้งหมด</j></a></li>
							        </ul>
							      </div><!-- /btn-group -->
							    </div><!-- /input-group -->

								</div>
							</div>
							<div class="conResult">
								<div ng-repeat="(key, data) in DataBill" ng-click="payBill($index)">
									<div class="resultUserBill">
										<div class="wrap">
											<div class="icon">
												<img src="img/icon-44.png" ng-show="data.customers_sex == 'male'">
												<img src="img/icon-user.png" ng-show="data.customers_sex == 'female'">
											</div>
											<div class="text">
												<span class="name">{{data.customers_name}}</span>
												<span class="tel">เบอร์โทร</span><span class="tel-data">{{data.customers_tel}}</span>
												<span class="tel" style="color: #45B39C;">รหัสบัตร</span><span class="tel-data">{{data.customers_id_card}}</span>	
												<span class="tel" style="color: #1196d1;">รหัสบิล</span><span class="tel-data">{{data.bill_code}}</span>	
												<span class="tel" style="color: #8e44ad;">สินค้า:</span><span class="tel-data">{{data.product.product_name | limitTo:20}}</span>																										
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-horizontal" ng-hide="findPayBill_toggle" ng-init="customersDes_toggle = false">
							<div class="row" ng-hide="customersDes_toggle" style="background-color: white; border-radius: 3px; border-width: 1px; border-style: dashed; border-color: #e67e22;" ng-click="customersDes_toggle = true">
								<label class="col-xs-4 col-sm-2 control-label" style="color: #e05b49;">รหัสบิล</label>
								<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{DataPayBill.bill.bill_code}}</label>
								<label class="col-xs-4 col-sm-2 control-label" style="color: #e67e22;">สถานะ</label>
								<label class="col-xs-8 col-sm-5 control-label" style="text-align: left;">{{(DataPayBill.bill.bill_status) ? "ชำระครบแล้ว" : "ค้างชำระ"}}</label>	

								<label class="col-xs-4 col-sm-2 control-label" style="color: #e05b49;">ผู้ขาย</label>
								<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{DataPayBill.admin.admin_name}}</label>
								<label class="col-xs-4 col-sm-2 control-label" style="color: #e67e22;">ลูกค้า</label>
								<label class="col-xs-8 col-sm-5 control-label" style="text-align: left;">{{DataPayBill.customer.customers_name}}</label>								
							</div>
								
							<div class="row" ng-show="customersDes_toggle" ng-click="customersDes_toggle = false" style="background-color: white; border-radius: 3px; border-width: 2px; border-color: #e67e22; border-style: solid;">
								<label class="col-xs-4 col-sm-2 control-label" style="color: #e05b49;">รหัสบิล</label>
								<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{DataPayBill.bill.bill_code}}</label>
								<label class="col-xs-4 col-sm-2 control-label" style="color: #e67e22;">สถานะ</label>
								<label class="col-xs-8 col-sm-5 control-label" style="text-align: left;">{{(DataPayBill.bill.bill_status) ? "ชำระครบแล้ว" : "ค้างชำระ"}}</label>	

								<label class="col-xs-4 col-sm-2 control-label" style="color: #e05b49;">ผู้ขาย</label>
								<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{DataPayBill.admin.admin_name}}</label>
								<label class="col-xs-4 col-sm-2 control-label" style="color: #e67e22;">เลขบัตร</label>
								<label class="col-xs-8 col-sm-5 control-label" style="text-align: left;">{{DataPayBill.customer.customers_id_card}}</label>

								<label class="col-xs-4 col-sm-2 control-label" style="color: #45B39C;">ชื่อ - สกุล</label>
								<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{DataPayBill.customer.customers_name}}</label>
								<label class="col-xs-4 col-sm-2 control-label" style="color: #1196d1;">เบอร์โทร</label>
								<label class="col-xs-8 col-sm-5 control-label" style="text-align: left;">{{DataPayBill.customer.customers_tel}}</label>

								<label class="col-xs-4 col-sm-2 control-label" style="color: #8e44ad;">ที่อยู่</label>
								<label class="col-xs-8 col-sm-10 control-label" style="text-align: left;">{{DataPayBill.customer.customers_address}}</label>
							</div>

							<div class="col-xs-12" ng-init="productDes_toggle = false" ng-hide="productDes_toggle" ng-click="productDes_toggle = true">
								<div class="form-group" style="margin-bottom: 0px;">
									<div class="row" style="background-color: white; padding: 0px 0px 0px 15px; box-sizing: border-box; border: 1px dashed #45B39C; margin-top: 5px;">
										<div class="row">
											<label class="col-xs-4 col-sm-2 control-label" style="color: #45B39C;">สินค้า</label>
											<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{DataPayBill.product.length + '    รายการ'}}</label>
											<label class="col-xs-4 col-sm-2 control-label" style="color: #1196d1;">ราคารวม</label>
											<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{(DataPayBill.bill.bill_total_price-DataPayBill.bill.bill_interest)|number:0}} {{'    บาท'}}</label>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-12" ng-show="productDes_toggle" ng-click="productDes_toggle = false">
								<div class="form-group" style="margin-bottom: 0px;" ng-repeat="(key,product) in DataPayBill.product">
									<div class="row" style="background-color: white; padding: 0px 0px 0px 15px; box-sizing: border-box; border: 2px solid #45B39C; margin-top: 5px;">
										<div class="row">
											<label class="col-xs-4 col-sm-2 control-label" style="color: #e67e22;">สินค้า</label>
											<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{product.product_name}}</label>
											<label class="col-xs-4 col-sm-2 control-label" style="color: #45B39C;">จำนวน</label>
											<label class="col-xs-8 col-sm-5 control-label" style="text-align: left;">{{product.product_amount}}</label>
										</div>
										<div class="row">
											<label class="col-xs-4 col-sm-2 control-label" style="color: #1196d1;">ราคา</label>
											<label class="col-xs-8 col-sm-3 control-label" style="text-align: left;">{{product.product_price|number:0}} {{'    บาท'}}</label>
											<label class="col-xs-4 col-sm-2 control-label" style="color: #8e44ad;">ราคารวม</label>
											<label class="col-xs-8 col-sm-5 control-label" style="text-align: left;">{{(product.product_price * product.product_amount)|number:0}} {{'    บาท'}}</label>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-12" ng-init="priceDes_toggle = false" ng-hide="priceDes_toggle" ng-click="priceDes_toggle = true">
								<div class="form-group" style="margin-top: 5px; margin-bottom: 5px;">								
									<div class="row" style="padding: 0px 0px 0px 15px; background-color: white; border-radius: 3px; border-width: 1px; border-style: dashed; border-color: #1196d1; margin-bottom: 0px;">
										<div class="row">
											<label class="col-xs-5 col-sm-2 control-label" style="color: #8e44ad; text-decoration: underline;">ราคาผ่อนส่ง</label>
											<label class="col-xs-7 col-sm-3 control-label" style="text-align: left;">{{DataPayBill.bill.bill_pay_price | number:0}} {{'    บาท'}}</label>
											<label class="col-xs-5 col-sm-2 control-label" style="color: #45B39C; text-decoration: underline;">ผ่อนชำระ</label>
											<label class="col-xs-7 col-sm-5 control-label" style="text-decoration: underline; text-align: left;">{{DataPayBill.bill.bill_installments_price | number:0}} {{'   '}} {{(DataPayBill.bill.bill_type == "0" ? "บาท/เดือน" : "บาท/วิก")}}</label>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-12" ng-show="priceDes_toggle" ng-click="priceDes_toggle = false">
								<div class="form-group" style="margin-top: 5px; margin-bottom: 5px;">								
									<div class="row" style="padding: 0px 15px 0px 15px; background-color: white; border-radius: 3px; border-width: 2px; border-style: solid; border-color: #1196d1;">
										<div class="row">
											<label class="col-xs-4 col-sm-2 control-label" style="color: #e05b49;">ราคาสินค้า</label>
											<label class="col-xs-8 col-sm-3 control-label" style="text-align: right;">{{DataPayBill.bill.bill_price|number:0}} {{'    บาท'}}</label>
											<label class="col-xs-4 col-sm-2 control-label" style="color: #e67e22;">ดอกเบี้ย</label>
											<label class="col-xs-8 col-sm-5 control-label" style="text-align: right;">{{DataPayBill.bill.bill_interest|number:0}} {{'    บาท'}}</label>
										</div>
										<div class="row">
											<label class="col-xs-4 col-sm-2 control-label" style="color: #45B39C;">ราคารวม</label>
											<label class="col-xs-8 col-sm-3 control-label" style="text-align: right;">{{DataPayBill.bill.bill_total_price|number:0}} {{'    บาท'}}</label>
											<label class="col-xs-4 col-sm-2 control-label" style="color: #1196d1;">เงินดาวน์</label>
											<label class="col-xs-8 col-sm-5 control-label" style="text-align: right;">{{DataPayBill.bill.bill_price_dow|number:0}} {{'    บาท'}}</label>
										</div>
										<div class="row">
											<label class="col-xs-5 col-sm-2 control-label" style="color: #8e44ad; text-decoration: underline;">ราคาผ่อนส่ง</label>
											<label class="col-xs-7 col-sm-3 control-label" style="text-align: right;">{{DataPayBill.bill.bill_pay_price | number:0}} {{'    บาท'}}</label>
											<label class="col-xs-5 col-sm-2 control-label" style="color: #45B39C; text-decoration: underline;">ผ่อนชำระ</label>
											<label class="col-xs-7 col-sm-5 control-label" style="text-decoration: underline; text-align: right;">{{DataPayBill.bill.bill_installments_price | number:0}} {{'   '}} {{(DataPayBill.bill.bill_type == "0" ? "บาท/เดือน" : "บาท/วิก")}}</label>
										</div>
									</div>
								</div>
							</div>

							
							<div class="col-xs-12" ng-show="DataPayBill.bill.bill_status == 0">
								<div ng-click="payTermOfBill($index)" ng-class="{disabled: data.bill_detail_status == 0, allow: data.bill_detail_status != 0}" ng-repeat="(key, data) in DataPayBill.dateBill" style="position: relative; left: 50%; margin-left: -125px; width: 250px; height: 44px; margin-bottom: 5px; margin-right: 5px;">
									<div style="color: #efefef; border-top-left-radius: 3px; border-bottom-left-radius: 3px; padding-left: 5px; padding-top: 8px; float:left; height: 44px; background-color: #34495e; width: 180px;">
								    <div style="margin-top: 3px; float: left; margin-right: 8px; margin-left: 5px;">
								    	<i ng-show="data.bill_detail_status == 1" class="fa fa-check" style="color: #1abc9c; font-size: 20px;"></i>
								    	<i ng-hide="data.bill_detail_status == 1" class="fa fa-clock-o" style="color: #1abc9c; font-size: 20px;"></i>
								    </div>
								    <div style="color: #1abc9c; font-size: 20px;">{{data.bill_detail_date}}</div>
									</div>
									<button ng-class="{'btn1':data.bill_detail_status == 1, 'btn2':data.bill_detail_status == 0, 'btn3':data.bill_detail_status == 99}" style="border: 0; color: #efefef; border-top-right-radius: 3px; border-bottom-right-radius: 3px; padding-left: 5px; padding-top: 3px; float:left; height: 44px; width: 70px; font-size: 20px;">
										{{((data.bill_detail_status == "1") ? "ชำระแล้ว" : (data.bill_detail_status == "99" ? "ชำระเงิน" : "รอ"))}}
									</button>							
								</div>
								<button ng-click="cutBill()" ng-show="cutBill_toggle" style="position: relative; left: 50%; margin-left: -68.5px; background-color: #d9534f; color: #efefef; border: 0; border-radius: 3px; padding-left: 5px; padding-top: 3px; float:left; height: 44px; font-size: 20px;">
									ชำระเงินที่เหลือทั้งหมด
								</button>							
							</div>

							<div class="col-xs-12" ng-hide="DataPayBill.bill.bill_status == 0">
								<div ng-click="payTermOfBill($index)" ng-class="{disabled: data.admin_id == null, allow: data.admin_id != null}" ng-repeat="(key, data) in DataPayBill.dateBill" style="position: relative; left: 50%; margin-left: -125px; width: 250px; height: 44px; margin-bottom: 5px; margin-right: 5px;">
									<div style="color: #efefef; border-top-left-radius: 3px; border-bottom-left-radius: 3px; padding-left: 5px; padding-top: 8px; float:left; height: 44px; background-color: #34495e; width: 180px;">
								    <div style="margin-top: 3px; float: left; margin-right: 8px; margin-left: 5px;">
								    	<i class="fa fa-check" style="color: #1abc9c; font-size: 20px;"></i>
								    </div>
								    <div style="color: #1abc9c; font-size: 20px;">{{data.bill_detail_date}}</div>
									</div>
									<!-- {{data.admin_id == null ? "null" : "nonull"}} -->
									<button ng-hide="data.admin_id == null" ng-class="{'btn4':data.bill_detail_status == 2, 'btn1':data.bill_detail_status == 1}" style="border: 0; color: #efefef; border-top-right-radius: 3px; border-bottom-right-radius: 3px; padding-left: 5px; padding-top: 3px; float:left; height: 44px; width: 70px; font-size: 20px;">
										{{data.bill_detail_status == "1" ? "ชำระแล้ว" : "ตัดบิลแล้ว"}}
									</button>	
									<button ng-show="data.admin_id == null" ng-class="{'btn2':data.admin_id == null, 'btn1':data.admin_id != null}" style="border: 0; color: #efefef; border-top-right-radius: 3px; border-bottom-right-radius: 3px; padding-left: 5px; padding-top: 3px; float:left; height: 44px; width: 70px; font-size: 20px;">
										ตัดบิลแล้ว
										<!-- {{data.bill_detail_status == "1" ? "ชำระแล้ว" : "ตัดบิล"}} -->
									</button>							
								</div>						
							</div>

						</div>
					</div>
				</div>

				<div class="box-save-bill col-xs-12 col-sm-12 col-md-9" ng-show="tabColor==3">
					<div class="title">ประวัติบชำระเงิน</div>	
					<div class="box-bill"></div>
				</div>

				<div class="box-save-bill col-xs-12 col-sm-12 col-md-9" ng-show="tabColor==4">
					<div class="title">ข้อมูลลูกค้า</div>	
					<div class="box-bill">
					</div>
				</div>

				<div class="box-save-bill col-xs-12 col-sm-12 col-md-9" ng-show="tabColor==5">
					<div class="title">
						<div class="TEXT-LEFT sub-title-left CURSOR" ng-click="backToAdmin()">
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
							<div  class="conResult">
								<div ng-hide="adminToggle" ng-repeat="admin in admins" ng-click="editAdmin($index)">
									<div class="resultUser">
										<div class="wrap">
											<div class="icon">
												<img src="img/icon-44.png" ng-show="admin.admin_sex == 'male'"> <!-- male -->
												<img src="img/icon-user.png" ng-show="admin.admin_sex == 'female'"> <!-- female -->
											</div>
											<div class="text">
												<span class="name">{{admin.admin_name + ' ' + admin.admin_last_name}}</span>
												<span class="tel" style="color: #45B39C;">เบอร์โทร</span><span class="tel-data">{{admin.admin_tel}}</span>
												<span class="tel">รหัสบัตร</span><span class="tel-data">{{admin.admin_id_card}}</span>																	
											</div>
										</div>
									</div>
								</div>
							</div>
							<div ng-show="adminToggle">
								<div class="form-group">
									<label class="col-sm-4 col-md-4 control-label">เลขบัตรประชาชน</label>
								    <div class="col-sm-5 col-md-5">
									   	<input type="text" ng-model="adminIdCard" maxlength="13" class="form-control" ng-class="adminError[0]" numbers-only="numbers-only" focus-me="admin_id_focus" ng-keyup="checkAdminId()" ng-disabled="adminIdDisabled">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">Username</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="text" ng-model="adminUserName" class="form-control " ng-keyup="checkAdminUserName()" ng-class="adminError[1]">
									</div>
									<label class="col-sm-2 col-md-2 control-label">Password</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="password" ng-model="adminPassword" class="form-control" ng-keyup="checkAdminPassword()" ng-class="adminError[2]">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ชื่อ - สกุล</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="text" ng-model="adminName" class="form-control">
									</div>
									<label class="col-sm-2 col-md-2 control-label">เบอร์โทร</label>
								    <div class="col-sm-4 col-md-4">
								    	<input type="text" ng-model="adminTel" class="form-control" numbers-only="numbers-only" ng-model="tel" maxlength="10">
									</div>
								</div>								
								<div class="form-group">
									<label class="col-sm-2 col-md-2 control-label">ที่อยู่</label>
								    <div class="col-sm-10 col-md-10">
								    	<textarea class="form-control" ng-model="adminAddress" rows="3"></textarea>
									</div>
								</div>
								<div class="form-group">									
									<label class="col-sm-2 col-md-2 control-label">เพศ</label>
									<div class="col-sm-2 col-md-2">
										<select class="form-control" ng-model="adminSex">
							   	            <option value="male">ชาย</option>
								        	<option value="female">หญิง</option>          
								        </select>
							        </div>
								</div>

								<div class="row"> <!-- col-xs-col-6 col-sm-offset-9 col-sm-col-2 -->
									<div class="col-xs-6 col-xs-offset-3 col-sm-offset-8 col-sm-4 col-md-offset-10 col-md-2">
										<button type="button" class="btn btn-danger " ng-click="removeAdmin()" ng-hide="editFlug">ลบ</button>
										<button type="button" class="btn btn-success" ng-click="register(2)" ng-hide="editFlug">แก้ไข</button>
										<button type="button" style="margin-left: 53px;" class="btn btn-primary" ng-click="register(1)" ng-show="editFlug">เพิ่ม</button>
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