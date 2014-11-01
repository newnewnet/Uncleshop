<?php 
	class Admin extends Eloquent
	{
		protected $table = 'admin';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'admin_id';


		public function insertAdmin($array)
		{
			$count = $this->where('admin_id_card','=',$array['admin_id_card'])->count();
			if($count != 0)
			{
				return "error";
			}
			$this->insert([
					'admin_id_card' => $array['admin_id_card'],
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
							->first();
							
			if($result == '')
			{
				$result = null;
			}
			
			return $result;

		}
		public function getCountUser($array)
		{	
			$result = 'success';
			if(isset($array['username']))
			{	
				$count = $this->where('admin_user','=',$array['username'])->count();
				if($count != 0)
				{
					$result = 'userName-same';
				}

			}
			if(isset($array['admin_id_card']))
			{	
				$count = $this->where('admin_id_card','=',$array['admin_id_card'])->count();
				if($count != 0)
				{
					$result = 'adminId-same';
				}
				
			}
			return $result;
		}

		public function updateAdmin($array)
		{
			if(count($array)!=0)
			{
					$result = $this->where('admin_id','=',$array['admin_id'])
											->update(array(
												'admin_id_card' => $array['admin_id_card'],
												'admin_name' => $array['admin_name'],
												'admin_last_name' => $array['admin_last_name'],
												'admin_user' => $array['admin_user'],
												'admin_password' =>$array['admin_password'],
												'admin_sex' =>$array['admin_sex'],
												'admin_tel' =>$array['admin_tel'],
												'admin_address' =>$array['admin_address']
											));			
				return $result;
			}
		}
		public function deleteAdmin($array)
		{
			if(isset($array['admin_id']))
			{
				$result = $this->where('admin_id', '=', $array['admin_id'])
										->update(array(
												'admin_status' => 2
										));
				return $result;
			}
		}
		public function getAdmin()
		{
			$result = $this->where('admin_status','=',0)->get();
			return  $result;
		}
		public function getAdminInterest()
		{
			$result = $this->where('admin_status','=',1)->select('admin_interest')->first();
			return  $result->admin_interest;
		}
	}