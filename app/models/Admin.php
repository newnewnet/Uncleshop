<?php 
	class Customers extends Eloquent
	{
		protected $table = 'admin';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'admin_id';


		public function insertAdmin()
		{
			$admin  = new Admin;
			$admin->insert([
					'admin_name' => $array['admin_name'],
					'admin_user' => $array['admin_user'],
					'admin_password' =>$array['admin_password'],
				]);
		}
	}