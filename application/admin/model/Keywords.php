<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Keywords extends Model
{

	public function add($data)
	{
		$keys = new Keywords;
		$result = $keys->validate(true)->allowField(true)->saveAll($data);
		if(false === $result){
			alert($keys->getError());
		} else {
			return true;
		}
	}

	public function kdel($id)
	{
		$this->where('art_id',$id)->delete();
	}

	public function se($id){
		return Db::table('keywords')->field('key_id')->where('art_id',$id)->select();
	}
}