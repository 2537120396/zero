<?php
namespace app\admin\model;
use think\Model;

class Admin extends Model
{
	public function login($pass){
		return $this->where('adminpassword',$pass)->find();
	}

	public function validation($where){
		return $this->where('adminname',$where)->find();
	}

	public function pass($data,$where){
		$result = $this->allowField(true)->save($data,['adminname'=>$where]);
		return $result;
	}
}