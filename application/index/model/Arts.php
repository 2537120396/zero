<?php
namespace app\index\model;
use think\Db;
use think\Model;

class Arts extends Model
{

	public function art($id){
		return Db::view('arts','title,pic,comnum,update_time,clicknum')->view('cats','pid,cat_name',"arts.cat_id=cats.cat_id")->where('art_id',$id)->select();
	}

	public function content($id){
		return Db::field('content')->table('contents')->where('art_id',$id)->find();
	}

	public function cats($id){
		return Db::field(['cat_id','cat_id,cat_name,num'])->table('cats')->where('pid',$id)->select();
	}

	public function comments($id,$num=5){
		return Db::view('comment','num,com_id,comment,user_id,create_time')->view('user','head_portrait,user_name','comment.user_id=user.user_id')->order('com_id desc')->where('art_id',$id)->paginate($num);
	}

	public function replys($id){
		return Db::view('msg','mid,msg,uid,update_time')->view('user','user_name','msg.uid=user.user_id')->order('mid desc')->where('msg.com_id',$id)->select();
	}

	public function addHistory($data){
		$h = Db::table('history')->where('user_id',$data['user_id'])->where('art_id',$data['art_id'])->find();
		if(!empty($h)){
			Db::table('history')->where('user_id',$data['user_id'])->where('art_id',$data['art_id'])->delete();
		}
		Db::table('history')->insert($data);
	}

	public function record($data,$status=1){
		if($status==1){
			$r = Db::table('record')->where('user_id',$data['user_id'])->where('art_id',$data['art_id'])->find();
			if(!empty($r)){
				Db::table('record')->where('user_id',$data['user_id'])->where('art_id',$data['art_id'])->delete();
			}
		}
		Db::table('record')->insert($data);
		return Db::field('count(*)')->where('art_id',$data['art_id'])->table('record')->find();
	}

	public function updateNum($data,$id){
		$this->allowField('clicknum')->save($data,['art_id'=>$id]);
	}

	public function seo($id){
		return Db::view('arts','title,info')->view('keywords','keyword','arts.art_id=keywords.art_id','LEFT')->where('arts.art_id',$id)->select();
	}
}