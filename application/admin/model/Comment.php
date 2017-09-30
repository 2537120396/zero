<?php
namespace app\admin\model;
use think\Model;
use think\Db;

class Comment extends Model
{
	public function getCom($id,$num=10)
	{
		return $this->where('art_id',$id)->order('com_id desc')->paginate($num);
	}

	public function user($num=10){
		return Db::field(['user_name','tel','email','last_login_time','ip'])->table('user')-
		->order('user_id desc')->paginate($num);
	}

	public function reply($num=10){
		return Db::field(['mid','msg','uid','user_id','update_time'])->table('msg')order('mid desc')->paginate($num);
	}
}