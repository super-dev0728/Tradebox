<?php

namespace App\Modules\Auth\Models\customer;

class Auth_model
{

    public function __construct()
    {
        $this->db       = db_connect();
        $this->session  = \Config\Services::session();
    }
    public function getUsers()
    {
        $builder = $this->db->table('user');
        $builder->select('*');
        $query   = $builder->get();
        return $query->getResult();
    }

    public function checkUser($data = array())
    {

        $where = "(email ='" . $data['email'] . "' OR username = '" . $data['email'] . "')";
        $builder = $this->db->table('user_registration');
        return $builder->select("*")
            ->where('password', md5($data['password']))
            ->where('status', 1)
            ->where($where)
            ->get();
    }

    //role permission check
    public function userPermissionadmin($id = null)
    {

        return $this->db->table('role_permission')
            ->select("
                                sub_module.directory, 
                                role_permission.fk_module_id, 
                                role_permission.create, 
                                role_permission.read, 
                                role_permission.update, 
                                role_permission.delete
                                ")
            ->join('sub_module', 'sub_module.id = role_permission.fk_module_id', 'full')
            ->where('role_permission.role_id', $id)
            ->where('sub_module.status', 1)
            ->groupStart()
            ->where('create', 1)
            ->orWhere('read', 1)
            ->orWhere('update', 1)
            ->orWhere('delete', 1)
            ->groupEnd()
            ->get()
            ->getResult();
    }

    public function userPermission($id = null)
    {

        $userrole = $this->db->table('sec_userrole')
            ->select('sec_userrole.*,sec_role.*')
            ->join('sec_role', 'sec_userrole.roleid=sec_role.id')
            ->where('sec_userrole.user_id', $id)
            ->get()
            ->getResult();

        $roleid = array();
        foreach ($userrole as $role) {
            $roleid[] = $role->roleid;
        }

        if (!empty($roleid)) {
            return $result =  $this->db->table('role_permission')
                ->select("
                                role_permission.fk_module_id, 
                                sub_module.directory,
                                IF(SUM(role_permission.create) >= 1,1,0) AS 'create', 
                                IF(SUM(role_permission.read) >= 1,1,0) AS 'read', 
                                IF(SUM(role_permission.update) >= 1,1,0) AS 'update', 
                                IF(SUM(role_permission.delete) >= 1,1,0) AS 'delete'
                            ")
                ->join('sub_module', 'sub_module.id = role_permission.fk_module_id', 'full')
                ->whereIn('role_permission.role_id', $roleid)
                ->where('sub_module.status', 1)
                ->groupBy('role_permission.fk_module_id')
                ->groupStart()
                ->where('create', 1)
                ->orWhere('read', 1)
                ->orWhere('update', 1)
                ->orWhere('delete', 1)
                ->groupEnd()
                ->get()
                ->getResult();
        } else {
            return $this->db->table('role_permission')
                ->select("
                            sub_module.directory, 
                            role_permission.fk_module_id, 
                            role_permission.create, 
                            role_permission.read, 
                            role_permission.update, 
                            role_permission.delete
                            ")
                ->join('sub_module', 'sub_module.id = role_permission.fk_module_id', 0)
                ->where('role_permission.role_id', 0)
                ->where('sub_module.status', 1)
                ->groupStart()
                ->where('create', 1)
                ->orWhere('read', 1)
                ->orWhere('update', 1)
                ->orWhere('delete', 1)
                ->groupEnd()
                ->get()
                ->getResult();
        }
    }

    public function last_login($ipadd)
    {
        $builder = $this->db->table('admin');
        $builder->set('last_login', date('Y-m-d H:i:s'));
        $builder->set('ip_address', $ipadd);
        $builder->where('uid', $this->session->get('id'));
        $builder->update();
        return true;
    }

    public function last_logout($ipadd)
    {
        $builder = $this->db->table('user_registration');
        $builder->set('last_logout', date('Y-m-d H:i:s'));
        $builder->set('ip_address', $ipadd);
        $builder->where('uid', $this->session->get('id'));
        $builder->update();
        return true;
    }
}