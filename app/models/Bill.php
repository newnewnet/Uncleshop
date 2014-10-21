<?php 
	class Bill extends Eloquent
	{
		protected $table = 'bill';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'bill_code';

		public function insertBill($array)
		{
			$customers  = new Customers;
			$product = new Product;
			$bill_detail = new Bill_detail;

			if(isset($array['cutomers_name']))
			{			
				$customers->insert([
					'customers_id' => $array['customers_id'],
					'customers_name' => $array['cutomers_name'],
					'customers_address' => $array['cutomers_address'],
					'customers_sex' => $array['customers_sex'],
					'customers_tel' =>$array['cutomers_tel'],
				]);
			}

			// $billCode = $this->randomBill();

			// $day = 0;
			// $month = date('m');
			// $year   = date('Y');

			// if($array['bill_type'] == 1)
			// {
			// 	$day = 15*$array['bill_date_amount'];
			// 	$endDate = time() + ($day *24*60 * 60);
			// 	$endDate  = date('Y-m-d',$endDate );
			// }
			// else 
			// {
			// 	for($i=0 ;$i<$array['bill_date_amount'];$i++)
			// 	{
			// 			if($month == 12)
			// 			{
			// 				$month = 1;
			// 			}
			// 			else if($i != 0)
			// 			{
			// 				$month+=1;
			// 			}
			
			// 			$day+=$this->daysInMonth($month,$year);
			// 			$expireDate = time() + ($day *24*60 * 60);
			// 			$year = date('Y',$expireDate);					
			// 	}
			// 	$endDate = time() + ($day *24*60 * 60);
			// 	$endDate  = date('Y-m-d',$endDate );
			// }

			// $this->insert([
			// 		'bill_id' => $billCode ,
			// 		'bill_start_date' => date('Y-m-d'),
			// 		'bill_end_date' => $endDate,
			// 		'bill_total_price' => $array['bill_total_price'],
			// 		'bill_date_amount' => $array['bill_date_amount'],
			// 		'bill_status' => 0,
			// 		'bill_price' => $array['bill_price'],
			// 		'bill_type' => $array['bill_type'],
			// 		'bill_price_dow' => $array['bill_price_dow'],
			// 		'customers_id' => $array['customers_id'],
			// 		'admin_id' => $array['admin_id'],
			// ]);

			// foreach ( $array['product'] as $product)
			// {
			// 	$product->insert([
			// 			'product_name' => $product->product_name,
			// 			'product_amount' => $product->product_amount,
			// 			'product_price' => $product->product_price,
			// 			'bill_id' => $billCode
			// 	]);
			// }


		}
		private function daysInMonth($month, $year)
		{
			return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
		}
		private function randomBill()
		{
			$month = date('m');
			$year = date('y');
			$billCode = '';
			$characters = '0123456789';
    	$randomString = '';
    	for ($i = 0; $i < 7; $i++) {
        	$randomString .= $characters[rand(0, strlen($characters) - 1)];
    	}

    	$billCode = "B".$month.$year.$randomString;

 			$duplicate=true;

			while($duplicate==true)
			{

				$result_random = $this->where('bill_code','=',$billCode)->get();

				if($result_random == '[]')
				{
					$duplicate=false;
				}
				else
				{
					$characters = '0123456789';
				  	$randomString = '';
				  	for ($i = 0; $i < 7; $i++) {
			        	$randomString .= $characters[rand(0, strlen($characters) - 1)];
			    	}
			    	$billCode = "B".$month.$year.$randomString;
				}
			}

			return $billCode;

		}

	}