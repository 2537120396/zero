<?php
namespace app\index\model;
use think\Db;
use think\Model;

class Msg extends Model
{
	public function add($data){
		$this->allowField(true)->save($data);
	}

	public function uid(){
		return Db::field('uid')->table('msg')->find();
	}
}