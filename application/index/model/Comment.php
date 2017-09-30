<?php
namespace app\index\model;
use think\Db;
use think\Model;

class Comment extends Model
{
	public function add($data){
		$result = $this->allowField(true)->save($data);
		if(false === $result){
			alert($arts->getError());
		} else {
			return $this->getLastInsID();
		}
	}

	public function pic($data){
		$result = Db::table('compic')->insertAll($data);
		if(false === $result){
			alert($arts->getError());
		} else {
			return true;
		}
	}

	public function getPic($id){
		return Db::table('compic')->where('com_id',$id)->select();
	}

	public function uid(){
		return Db::field('user_id')->table('comment')->find();
	}
}