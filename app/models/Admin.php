<?php 
	class Admin extends Eloquent
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
		public function loginAmin($array)
		{	
			$admin  = new Admin;
			$result = $admin->where('admin_user','=',$array['username'])
											->where('admin_password','=',$array['password'])
											->select('admin_id','admin_name')
											->first();
			if($result == '')
			{
				$result = null;
			}
			
			return $result;

		}
	}