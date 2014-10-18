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
				$result = $customers->where('customers_id', 'LIKE', "%".$key."%")->get();
				
			}
			return $result;
		}
		
	}