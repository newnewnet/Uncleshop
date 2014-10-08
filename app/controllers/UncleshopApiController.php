<?php

	class UncleshopApiController extends Controller
	{
		public function getCustomers()
		{	
			$customers = new Customers;
			$result = $customers->getCustomers();
			return $result;
		}
		public function saveCustomers()
		{
			$array = Input::all();
			$customers = new Customers;
			$customers->saveCustomers($array);

		}
	}