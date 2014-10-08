<?php 
	class Customers extends Eloquent
	{
		protected $table = 'customers';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'customers_id';

		public function getCustomers()
		{
			$customers  = new Customers;
			$result = $customers->get();
			return $result;
		}
		public function saveCutomers($array)
		{
			
		}
	}