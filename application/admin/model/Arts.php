<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Arts extends Model
{

	public function add($data)
	{
		$arts = new Arts;
		$result = $arts->validate(true)->allowField(true)->save($data);
		if(false === $result){
			alert($arts->getError());
		} else {
			return $this->getLastInsID();
		}
	}

	public function getArts($search,$num=10)
	{
		if('' !== $search){
			$keys = '';
			$catid = Db::table('Cats')->field(['cat_id'])->where('cat_name',$search)->find();
			if(!empty($catid)){
				if($catid['cat_id']>3){
					$arts = Db::table('Arts')->field(['art_id','title','clicknum','comnum','update_time','cat_id'])->where('cat_id',$catid['cat_id'])->order('art_id desc')->paginate($num);
				} else {
					$ids = Db::table('Cats')->field(['cat_id'])->where('pid',$catid['cat_id'])->select();
					foreach($ids as $v){
						$keys .= $v['cat_id'].',';
					}
					$keys = rtrim($keys, ",");
					$arts = Db::table('Arts')->field(['art_id','title','clicknum','comnum','update_time','cat_id'])->where('cat_id','in',$keys)->order('art_id desc')->paginate($num);
				} 
			} else {
				$artsid = Db::table('Keywords')->where('keyword','like',"%".$search."%")->select();
				foreach($artsid as $v){
					$keys .= $v['art_id'].',';
				}
				$keys = rtrim($keys, ",");
				$arts = Db::table('Arts')->field(['art_id','title','clicknum','comnum','update_time','cat_id'])->where('art_id','in',$keys)->order('art_id desc')->paginate($num);
			}	
		} else {
			$arts = Db::table('Arts')->field(['art_id','title','clicknum','comnum','update_time','cat_id'])->order('art_id desc')->paginate($num);
		}
		return $arts;
	}

	public function aupdate($data,$id)
	{
		$arts = new Arts;
		$result = $arts->validate(true)->allowField(true)->save($data,['art_id' => $id]);
		if(false === $result){
			alert($arts->getError());
		} else {
			return true;
		}
	}

	public function del($id)
	{
		$this->where('art_id',$id)->delete();
	}
}