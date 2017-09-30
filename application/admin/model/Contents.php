<?php
namespace app\admin\model;
use think\Model;

class Contents extends Model
{
	public function add($data)
	{
		if($this->allowField(true)->save($data)){
			return true;
		} else {
			return false;
		}
	}

	public function cup($data,$id)
	{
		if($this->allowField(true)->save($data,['art_id' => $id])){
			return true;
		} else {
			return false;
		}
	}

	public function del($id)
	{
		$this->where('art_id',$id)->delete();
	}
}