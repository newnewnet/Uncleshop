<?php 
	class Customers extends Eloquent
	{
		protected $table = 'customers';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'customers_id';

		public function getCustomers($key)
		{
			$result = '';
			if($key != '')
			{
				$customers  = new Customers;
				$result = $customers->orWhere('customers_id', 'LIKE', "%".$key."%")
								->orWhere('customers_name', 'LIKE', "%".$key."%")
								->orWhere('customers_last_name', 'LIKE', "%".$key."%")
								->orWhere('customers_tel', 'LIKE', "%".$key."%")
								->get();
				
			}
			return $result;
		}
		
	}