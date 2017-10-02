<?php
namespace app\index\controller;

class Cv
{
	public function cv(){
   	if(!empty(input('post.comment'))){
   		if(!$this->validation()){
   			return redirect('user/login');
   		}
   		if(count(input('post.comment')) > 100){
				alert('评论不能超过100个字符！');
  		} else {
  	   	$data['comment'] = input('post.comment');
  		  $data['user_id'] = cookie('id');
  		  model('Cv')->add($data);
        return redirect('cv');
  		}
   	}
   	$arr = model('Cv')->cvComment();
   	$num = model('Cv')->num()['count(*)'];
		return view('cv',['arr'=>$arr,'num'=>$num]);
	}

	public function append(){
    $arr = model('Cv')->cvComment(input('post.num')*10);
    $num = model('Cv')->num()['count(*)'];
    if($num <= count($arr)){
      $arr[count($arr)] = 'n';
    }
		return json($arr);
	}

   public function validation(){
        if(!empty(cookie('ss')) && !empty(cookie('name')) && !empty(cookie('id'))){
          $user = model('User')->validation(cookie('id'));
          if(md5(md5($user['user_name']).$user['password'].$user['user_id'].config('salt')) !== cookie('ss')){
          	return false;
          } else {
          	return true;
          }    
        } else {
            return false;
        }
   }
}
