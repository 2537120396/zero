<?php
namespace app\admin\controller;

class Comment
{
	public function comment(){
        if(!empty(cookie('adminname'))){
    	   $data = model('Admin')->validation(cookie('adminname'));      
        } else {
            return redirect('index/login');
        }
    	$data['salt'] = config('salt');
    	if(!validation($data)){
    		return redirect('index/login');
    	}
		if(empty($id = input('param.art_id'))){
			$comment = model('Comment')->paginate(10);
		} else {
	    	$result = validate('Comment')->check($id);
			if(true !== $result){
				return redirect('comment');
			}
			$comment = model('Comment')->getCom($id);
		}
		return view('comment',['comment'=>$comment]);
	}

	public function user(){
        if(!empty(cookie('adminname'))){
    	   $data = model('Admin')->validation(cookie('adminname'));      
        } else {
            return redirect('index/login');
        }
    	$data['salt'] = config('salt');
    	if(!validation($data)){
    		return redirect('index/login');
    	}
    	$user = model('Comment')->user();
    	return view('user',['user'=>$user]);	
	}

	public function reply(){
        if(!empty(cookie('adminname'))){
    	   $data = model('Admin')->validation(cookie('adminname'));      
        } else {
            return redirect('index/login');
        }
    	$data['salt'] = config('salt');
    	if(!validation($data)){
    		return redirect('index/login');
    	}
    	$reply = model('Comment')->reply();
    	return view('reply',['reply'=>$reply]);
	}
}