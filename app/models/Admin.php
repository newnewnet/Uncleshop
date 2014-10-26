<?php 
	class Admin extends Eloquent
	{
		protected $table = 'admin';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'admin_id';


		public function insertAdmin($array)
		{
			$this->insert([
					'admin_id' => $array['admin_id'],
					'admin_name' => $array['admin_name'],
					'admin_last_name' => $array['admin_last_name'],
					'admin_user' => $array['admin_user'],
					'admin_password' =>$array['admin_password'],
					'admin_sex' =>$array['admin_sex'],
					'admin_tel' =>$array['admin_tel'],
					'admin_address' =>$array['admin_address'],
					'admin_status' => 0,
			]);
		}
		public function loginAmin($array)
		{	
			$result = $this->where('admin_user','=',$array['username'])
											->where('admin_password','=',$array['password'])
											->select('admin_id','admin_name','admin_status')
											->first();
			if($result == '')
			{
				$result = null;
			}
			
			return $result;

		}
		public function getAdmin($array)
		{	
			if(isset($array['username']))
			{	
				$result = $this->where('admin_user','=',$array['username'])->count();
				return $result;
			}
		}

		public function updateAdmin($array)
		{
			if(count($array)!=0)
			{
					$result = $this->where('admin_id','=',$array['admin_id'])
											->update(array(
												'admin_password' =>$array['admin_password'],
											));			
				return $result;
			}
		}
		public function deleteAdmin($array)
		{
			if(isset($array['admin_id']))
			{
				$result = $this->where('admin_id', '=', $array['admin_id'])->delete();
				return $result;
			}
		}
	}