<?php

	class UncleshopApiController extends Controller
	{
		public function getCutomers()
		{	
			$customers = new Customers;
			$result = $customers->getCustomers();
			return $result;
		}
		public function saveCutomers()
		{
			$array = Input::all();
			$customers = new Customers;
			$result = $customers->saveCutomers($array);
			return $result;
		}
	}