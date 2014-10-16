<?php

	class UncleshopApiController extends Controller
	{
		public function getCustomers()
		{	
			$customers = new Customers;
			$result = $customers->getCustomers();
			return "$result";
		}
		public function saveCustomers()
		{
			$array = Input::all();
			$customers = new Customers;
			$customers->insertCustomers($array);

		}
		public function saveAdmin()
		{
			$array = Input::all();
			$admin = new Admin;
			$admin->insertAdmin($array);
		}
		public function loginAdmin()
		{
			$array = Input::all();
			if(count($array)==0)
			{
				return null;
			}
			$admin = new Admin;

			$result = $admin->loginAmin($array);
			
			return $result;

		}
	}