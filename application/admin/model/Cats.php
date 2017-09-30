<?php
namespace app\admin\model;
use think\Model;

class Cats extends Model
{

	public function catAdd($data)
	{
		$Cats = new Cats;
		$result = $Cats->validate('Cats.add')->allowField(true)->save($data);
		if(false === $result){
			alert($Cats->getError());
		}
	}

	public function getCats($num=10,$id=0)
	{
		if($id != 0){
			$cats = $this->where('cat_id',$id)->order('cat_id desc')->select();
		} else {
			$cats = $this->order('cat_id desc')->paginate($num);
		}
		return $cats;
	}

	public function catUpdate($data,$id){
		$Cats = new Cats;
		$result = $Cats->validate('Cats.edit')->allowField(true)->save($data,['cat_id' => $id]);
		if(false === $result){
			alert($Cats->getError());
		}
	}

	public function catDel($id){
		$this->where('cat_id',$id)->delete();
	}
}