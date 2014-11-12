
<html>
	<meta charset="utf-8">
 	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link href="/css/print_tag.css" rel="stylesheet"/>
	<title>Uncleshop</title>
	<body>
	
		<div class="frame">
			<div class="bill-code">
				<span >บิลส่งของ : </span>
				<span id="billCode"></span>
			</div>
			<div class="bill-customers">
				<div>
					<div class="text-customers" id="customerName">				
					</div>
					<div  class="text-customers" style="float:right" >
						<label>เลขบัตรประชาชน : </label>
						<span id="customerIdCard"></span>
					</div >
					
				</div>
				<div style="margin-top: 25px;">
					<div class="text-customers" >
						<label >เบอร์โทร : </label>
						<span id="customerTel"></span>
					</div>
					<div class="text-customers" style="float:right">
						<label>วันที่ : </label>
						<span id="customerDate"></span>			
					</div>
				</div>
				<div  style="margin-top: 51px;">
					<div >
						<label>ที่อยู๋ : </label>
						<span id="customerAddress"></span>
					</div>
				</div>
			</div>

			<!-- //////////////////////////////table*//////////////////////////////////////////  -->

			<div class="bill-title">
				<div class="title" >
					ลำดับ
				</div>
				<div class="title" style="width:483px;">
					รายการ
				</div>
				<div class="title" style="width:64px;">
				  จำนวน
				</div>
				<div class="title" style="width:85px; border:none">
				  เงิน
				</div>
			</div>
			<div id="product">
			</div>
			<div class="bill-product-total">
				<div class="text" style="padding-left: 87px">
			    รวม 
			  </div>
			  <div class="text" style="width:64px;" id="productTotalAmount">
			  </div>
			  <div class="text" style="width:85px; border:none" id="productTotalPrice">
			  </div>
			</div>
			<div class="note">
				*<span style="text-decoration: underline">หมายเหตุ</span>&nbsp
				<span>อัตราดอกเบี้ย</span>&nbsp
				<span id="billInterestToMount"></span>&nbsp
				<span>บาท/</span><span id="billType1"></span>
			</div>

			<!-- //////////////////////รายละเอียดบิล //////////////////// -->
			<div class="bill-detail">
			  <div>
			    <div class="left">
			      <div class="title">ราคาสินค้า</div>
			      <span class="value" id="billPrice"></span>
			 	 		<span class="currency">บาท</span>
				 	</div>
			    <div class="right">
			      <div  class="title">ดอกเบี้ย</div>
			      <span class="value" id="billInterest"></span>
			  	  <span class="currency">บาท</span>
			    </div>
			  </div>
			  <div style="margin-top: 6px">
			    <div class="left">
			      <div class="title">ราคารวม</div>
			      <span class="value" id="billTotalPrice"></span>
			 	 		<span class="currency">บาท</span>
				 	</div>
			    <div class="right">
			      <div  class="title">เงินดาวน์</div>
			      <span class="value" id="billPriceDow"></span>
			  	  <span class="currency">บาท</span>
			    </div>
			  </div>
			  <div style="margin-top: 6px">
			    <div class="left">
			      <div class="title" style="text-decoration: underline">ราคาผ่อนส่ง</div>
			      <span class="value" id="billPayPrice"></span>
			 	 		<span class="currency">บาท</span>
				 	</div>
			    <div class="right">
			      <div  class="title" style="text-decoration: underline">การผ่อนชำระ</div>
			      <span class="value" id="billInstallmentsPrice"></span>
			  	  <span class="currency">บาท/<span id="billType2"></span></span>
			    </div>
			  </div>
			</div>
			<div class="bill-date">
				<div style="text-decoration: underline">วันที่ต้องมาจ่าย</div>
				<div id="dateBill"></div>
			</div>
			<div class="bill-admin">
				<label>ผู้ขาย : </lable>
				<span id="adminName"></span>
			</div>


		</div>

		<script>
		function normal(data)
		{
			var customers = data.customer;
			var bill = data.bill;
			var dateBill = data.dateBill;
			var admin = data.admin;

			////////////customers//////////////
			var divCustomerName = "<label>ชือ-นามสกุล : </label><span >"+customers.customers_name+"</span>&nbsp;<span>"+customers.customers_last_name+"</span>";
	    $('#customerName').append(divCustomerName);
	    $('#customerIdCard').append(customers.customers_id_card);
	    $('#customerTel').append(customers.customers_tel);
	    $('#customerDate').append(data.bill.bill_start_date);
	    $('#customerAddress').append(customers.customers_address);

	    ///////////  product //////////////////
			var divProduct = "";
			var productAmount = 0;
	    $.each(data.product, function(i, products) 
	  	{
	  		divProduct = "<div class='bill-product'>";
				divProduct+="<div class='text'>"+(i+1)+"</div>";
				divProduct+="<div class='text' style='width:483px;'>"+products.product_name+"</div>";
				divProduct+="<div class='text' style='width:64px;'>"+products.product_amount+"</div>";
				var productPrice = parseFloat(products.product_price);
				productPrice = commaNumber(productPrice);
				divProduct+="<div class='text' style='width:85px; border:none'>"+productPrice+"</div></div>";
				$('#product').append(divProduct);
				productAmount+=products.product_amount;
	  	});

	    var billPrice = parseFloat(bill.bill_price);
	    billPrice = commaNumber(billPrice);
	  	$('#productTotalAmount').append(productAmount);
	  	$('#productTotalPrice').append(billPrice);


	  	//////////// bill //////////////

	  	var billInterest = parseFloat(bill.bill_interest);
	  	var billTotalPrice = parseFloat(bill.bill_total_price);
	  	var billPriceDow = parseFloat(bill.bill_price_dow);
	  	var billPayPrice = parseFloat(bill.bill_pay_price);
	  	var billInstallmentsPrice = parseFloat(bill.bill_installments_price);
	  	billInterest = commaNumber(billInterest);
	  	billTotalPrice = commaNumber(billTotalPrice);
	  	billPriceDow = commaNumber(billPriceDow);
	  	billPayPrice = commaNumber(billPayPrice);
	  	billInstallmentsPrice = commaNumber(billInstallmentsPrice);

	  	var billType = "เดือน";
	  	if(bill.bill_type == 1)
	  	{
	  		billType = "วิก";
	  	}
	  	$('#billInterestToMount').append(bill.bill_interest_to_mount);
	  	$('#billType1').append(billType);
	  	$('#billType2').append(billType);
	  	$('#billCode').append(bill.bill_code);
	  	$('#billPrice').append(billPrice);
	  	$('#billInterest').append(billInterest);
	  	$('#billTotalPrice').append(billTotalPrice);
	  	$('#billPriceDow').append(billPriceDow);
	  	$('#billPayPrice').append(billPayPrice);
	  	$('#billInstallmentsPrice').append(billInstallmentsPrice);


	  	var divDateBill = "";
	  	$.each(dateBill, function(i, dateBills) 
	  	{
	  		divDateBill = "<div style='margin-top: 6px'>"+dateBills.bill_detail_date+"</div>";
	  		$('#dateBill').append(divDateBill);
	  	});

	  	$('#adminName').append(admin.admin_name+" "+admin.admin_last_name);



		
		}
		function commaNumber(number)
		{
			 return number.toFixed(0).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}

		$(document).ready(function() 
		{		
			var billCode = "<?php echo $_POST['billCode'] ?>";
			$.ajax({
				type: "GET",
				url: "/getBill",
				data:{'bill_code':billCode}
				}).done(function(data) {
					normal(data);
				});
  
				setTimeout(function()
	    	{
	    		if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
	    		{ 
				    window.PPClose = false;                                   
				    window.onbeforeunload = function()
				    {                         
				        if(window.PPClose === false)
				        {
				            return 'กรุณากด "ยกเลิก" ก่อนออกจากหน้านี้\n';
				        	
				        }
				    }                   
				    window.print();                                           
				    window.PPClose = true;
				}
				else
	    			window.print()
	    	},1000); 
		
		});
		</script>
	</body>
</html>