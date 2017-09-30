<?php
namespace app\index\model;
use think\Db;
use think\Model;

class User extends Model
{
	public function regist($data){
		$User = new User;
		$result = $User->validate('User')->allowField(true)->save($data);
		if(false === $result){
			alert($User->getError());
		} else {
			return true;
		}
	}

	public function login($data){
		return $result = $this->where('user_name',$data)->whereOr('tel',$data)->whereOr('email',$data)->find();
	}

	public function validation($id){
		return Db::field('user_id,user_name,password,salt')->table('user')->where('user_id',$id)->find();
	}

	public function history($id){
		return Db::view('history','art_id,update_time')->view('arts','title','arts.art_id=history.art_id')->where('user_id',$id)->order('hid desc')->limit(20)->select();
	}

	public function comment($id,$num=10){
		return Db::view('comment','art_id,create_time,comment')->view('arts','title','arts.art_id=comment.art_id')->order('com_id desc')->where('user_id',$id)->paginate($num);
	}

	public function msg($id,$num=10){
		return Db::view('msg','art_id,user_id,update_time,msg')->view('arts','title','arts.art_id=msg.art_id')->view('user','user_name','user.user_id=msg.user_id')->where('msg.user_id','<>',$id)->where('msg.uid',$id)->order('mid desc')->paginate($num);	
	}

	public function getName($id){
		return Db::field('user_name')->table('user')->where('user_id',$id)->find();
	}

	public function getInfo($id){
		return $this->where('user_id',$id)->find();
	}

	public function modify($data,$id,$status=0){
		$User = new User;
		if($status == 0){
			$result = $User->validate('User')->allowField(true)->save($data,['user_id'=>$id]);	
		} else {		
			$result = $User->validate('User.nopass')->allowField(['user_name','tel','email','head_portrait','ip'])->save($data,['user_id'=>$id]);
		}
		if(false === $result){
			alert($User->getError());
		} else {
			return true;
		}
	}

	public function efind($where){
		return Db::field('user_id,user_name,password')->table('user')->where('email',$where)->find();		
	}

	public function reset($data,$where){
		$User = new User;
		$result = $User->validate('User.reset')->allowField('password','update_time','salt')->save($data,['email'=>$where]);
		if(false === $result){
			return $User->getError();
		} else {
			return true;
		}
	}
}