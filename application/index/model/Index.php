<?php
namespace app\index\model;
use think\Db;
use think\Model;

class Index extends Model
{
	public function getArts($id,$n=1,$num=5){
		if(!$id){
			$arts = Db::view('arts','art_id,title,thumb,info,comnum,update_time')->view('cats','cat_name','arts.cat_id = cats.cat_id')->where('pid',$n)->paginate($num);
		} else {
			$arts = Db::view('arts','art_id,title,thumb,info,comnum,update_time')->view('cats','cat_name',"arts.cat_id=cats.cat_id")->where('arts.cat_id',$id)->paginate($num);
		}
		return $arts;
	}

	public function getCats($id=1){
		return  Db::table('cats')->where('pid',$id)->select();
	}

	public function hot(){
		return Db::field(['title','art_id','clicknum'])->table('arts')->where('clicknum','>',0)->order('clicknum desc')->limit(5)->select();
	}

	public function searchArts($key,$num=5){
		$ids = Db::field('art_id')->table('keywords')->where('keyword','like',"%$key%")->select();
		$id = '';
		foreach($ids as $v){
			$id .= $v['art_id'].',';
		}
		$id = rtrim($id,',');
		return Db::view('arts','art_id,title,thumb,info,comnum,update_time')->view('cats','cat_name','arts.cat_id=cats.cat_id')->where('art_id','in',$id)->paginate($num,false,['query'=>request()->get()]);
	}

	public function getUser($id){
		return Db::field('user_id,user_name,password,salt')->table('user')->where('user_id',$id)->find();
	}

	public function msg($id){
		return Db::field('count(*)')->table('msg')->where('user_id',$id)->where('tag',1)->where('uid','<>',$id)->find();
	}

}