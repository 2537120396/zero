<?php
namespace app\admin\controller;

class Index
{
    public function index()
    {	
        if(!empty(cookie('adminname'))){
    	   $data = model('Admin')->validation(cookie('adminname'));      
        } else {
            return redirect('login');
        }
    	$data['salt'] = config('salt');
    	if(!validation($data)){
    		return redirect('login');
    	}
    	$cats = model('Cats')->getCats();
    	return view('index',['cats'=>$cats]);
    }

    public function login(){
    	if(!empty(input('post.'))){
    		if(empty(input('post.adminname')) || empty(input('post.adminpassword'))){
    			alert('请填写完整的登录信息！');
    		} else {
                $salt = model('Admin')->where('adminname',input('post.adminname'))->find();
                $pass = md5(input('post.adminpassword').$salt['adminsalt']);
		    	$user = model('Admin')->login($pass);
		    	if(empty($user)){
		    		alert('用户名或密码错误！');
		    	} else {
		    		if(md5(input('post.adminpassword').$user['adminsalt']) === $user['adminpassword']){
  						cookie('adminname', $user['adminname']);
  						cookie('adminss', md5(cookie('adminname').$user['adminpassword'].$user['adminid'].config('salt')));
		    			return redirect('index'); 
					} else {
						alert('用户名或密码错误！');
					}
		    	}
			} 
    	} 
    	return view();	
    }

    public function pass(){
        if(!empty(cookie('adminname'))){
           $data = model('Admin')->validation(cookie('adminname'));      
        } else {
            return redirect('login');
        }
    	$data['salt'] = config('salt');
    	if(!validation($data)){
    		return redirect('login');
    	}
    	if(!empty(input('post.adminpassword'))){
    		$str = str_shuffle('023456789qwertyuopasdfghjkzxcvbnm,./l;\[]!@#$%^&*()_+~`{}:|?');
    		$admin['adminsalt'] = substr($str, 0 , 8);
    		$admin['adminpassword'] = md5(input('post.adminpassword').$admin['adminsalt']);
            dump(input('post.adminpassword'));
            $result = model('Admin')->pass($admin,cookie('adminname'));
    		if($result){
    			alert('密码修改成功！');
    		} else {
    			alert('密码修改失败！');
    		}
    	}
    	return view();
    }
}
