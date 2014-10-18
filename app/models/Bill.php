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


			$billCode = $this->randomBill();

		// 	$this->insert([
		// 			'bill_id' => $billCode ,
		// 			'bill_start_date' => date('Y-m-d'),
		// 			'bill_end_date' => $array['customers_id'],
		// 			'bill_total_price' => $array['customers_id'],
		// 			'bill_date_amount' => $array['customers_id'],
		// 			'bill_status' => $array['customers_id'],
		// 			'bill_price' => $array['customers_id'],
		// 			'bill_type' => $array['customers_id'],
		// 			'customers_id' => $array['customers_id'],
		// 			'admin_id' => $array['customers_id'],
		// ]);
			// $expire_start = new DateTime();


			// if($array['bill_type'] == 1)
			// {

			// }
			// else
			// {
			// 	$array['bill_type']
			// 	$expireDate = time() + ( 3 *24*60 * 60);
			// 	$expireDate  = date('Y.m.d',$expireDate );
			// }
			
			// echo $expireDate ;

			$day = 0;
			$month = date('m');

			$year   = date('Y');

			for($i=0 ;$i<$array['bill_date_amount'];$i++)
			{
				$day+=$this->daysInMonth($month+$i,$year);

				$expireDate = time() + ($day *24*60 * 60);
				$year = date('Y',$expireDate );
				// echo $year;
			}
			$endDate = time() + ($day *24*60 * 60);
			$endDate  = date('Y.m.d',$endDate );
			echo $day;

			// echo date('Y-m-d');
    	// echo $billCode;


		}


		private function daysInMonth($month, $year)
		{
		// calculate number of days in a month
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