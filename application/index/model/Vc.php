<?php
namespace app\index\model;
use think\Db;
use think\Model;

class Vc extends Model
{
	public function add($data){	
		$result = $this->allowField(true)->save($data);
		if(false === $result){
			alert($arts->getError());
		}
	}

	public function vcComment($num=10){
		return Db::view('vc','comment,create_time')->view('user','user_name','vc.user_id=user.user_id')->limit($num)->select();
	}

	public function num(){
		return Db::field('count(*)')->table('vc')->find();
	}
}
