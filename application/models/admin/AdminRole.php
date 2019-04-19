<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminRole extends MY_Model 
{

    protected $_table = 'admin_role';
    protected $_pk = 'role_id';
    protected $_cols = 'role_id,role_name,role,priv';
    protected $_orderby = array('role_id'=>'ASC');

    protected $_pre_cache_key = 'admin-role-list';


    public function role($role_id)
    {
        if($role_list = $this->fetch_all()){
        	return $role_list[$role_id];
        }
        return false;
    }

    public function fetch_all()
    {
        if(($role_list = $this->cache->get($this->_pre_cache_key)) === false){
    		$sql = "SELECT * FROM ".$this->table($this->_table);
    		$role_list = array();
    		if($rs = $this->Execute($sql)){
    			foreach($rs as $row){
                    if($priv = explode(',',$row['priv'])){
                        $row['priv'] = array_combine($priv, $priv);
                    }else{
                        $row['priv'] = array();
                    }
    				$role_list[$row['role_id']] = $row;
    			}
    		}
    		$this->cache->set($this->_pre_cache_key, $role_list);
        }
        return $role_list;
    }

    public function create($data)
    {
        if(!$data = $this->_check($data)){
            return false;
        }
        if($role_id = $this->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $role_id;
    }

    public function update($ID,$data, $checked=false)
    {
        $ID = intval($ID);
        if(!$checked && !($data = $this->_check($data, $ID))){
            return false;
        }
        if($this->update($this->_table, $data, "role_id='$ID'")){
            $this->flush();
            return true;
        }
        return false;
    }

    public function remove($IDS)
    {
        if(!K::M('verify/check')->ids($IDS)){
            return false;
        }
        $sql = "DELETE FROM ".$this->table($this->_table)." WHERE role_id IN($IDS)";
        if($this->Execute($sql)){
            $this->flush();
            return true;
        }
        return false;
    }

    protected function _check($data, $ID=null)
    {
        unset($data['role_id']);
        if(isset($data['role_name']) || !$ID){
            if(!$data['role_name']){
                K::M('helper/error')->add('角色名称不能为空',401);
                return false;
            }
            $data['role_name'] = K::M('content/html')->text($data['role_name']);
        }
        if(isset($data['role']) || !$ID){
            if(!in_array($data['role'],array('editor','admin'/*,'system'*/,'developer'))){
                K::M('helper/error')->add('角色类型不正确',402);
                return false;
            }
        }
        return parent::_check($data);
    }

}