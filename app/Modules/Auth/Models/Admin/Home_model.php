<?php

namespace App\Modules\Auth\Models\Admin;

class Home_model
{

	private $table = "admin";
	public function __construct()
	{
		$this->db = db_connect();
	}
	public function profile($id = null)
	{
		$builder = $this->db->table('admin');
		return $builder->select("
				admin.*, 
				CONCAT_WS(' ', firstname, lastname) AS fullname, 
				IF (admin.is_admin=1, 'Admin', 'User') as user_level")
			->where('id', $id)
			->get()
			->getRow();
	}

	public function update_profile($data = array())
	{
		$builder = $this->db->table('admin');
		return $builder->where('id', $data['id'])
			->update($data);
	}
}