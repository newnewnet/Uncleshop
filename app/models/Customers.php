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
		public function insertCustomers($array)
		{
			$customers  = new Customers;
			$result = $customers->insert([
					'customers_name' => $array['cutomers_name'],
					'customers_address' => $array['cutomers_address'],
					'customers_tel' =>$array['cutomers_tel'],
				]);

		}
	}