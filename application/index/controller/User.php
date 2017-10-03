<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use first\Smtp;

class User extends controller
{
	public $userModel;

	public function __construct()
	{
		$this->userModel = model('User');
	}

    public function regist()
    {
    	if(!empty(input('post.'))){
    		$data = input('post.');
        $data['email'] = stripslashes(trim(input('post.email')));
    		$str = str_shuffle('023456789qwertyuopasdfghjkzxcvbnm,./l;\[]!@#$%^&*()_+~`{}:|?');
    		$data['salt'] = substr($str, 0 , 8);
    		$data['password'] = md5(input('post.password').$data['salt']);
    		$data['repassword'] = md5(input('post.repassword').$data['salt']);
    		$data['last_login_time'] = time();
    		$request = Request::instance();
        $data['ip'] = $request->ip();
    		$result = $this->userModel->regist($data);
    		if($result === true){
    			return redirect('login');
    		}
    	} 
    	return view();	
  	}

   public function test(){
   		$name = ucfirst(input('post.name'));
      if($name == 'UserName'){
        $_POST = ['user_name'=>input('post.value')];
      } else if($name == 'Tel'){
        $_POST = ['tel'=>input('post.value')];
      } else if($name == 'Email'){
        $_POST = ['email'=>input('post.value')];
      }
   		$validate = validate($name);
   		$result = $validate->check($_POST);
   		if(false === $result){
   			$msg = [0,$validate->getError()];
   		} else {
   			$msg = [1];
   		}
   		return $msg;
   }

   public function login()
    {
    	if(!empty(input('post.'))){
    		if(empty(input('post.name')) || empty(input('post.password'))){
    			alert('请填写完整的登录信息！');
    		} else {
    			$va = $this->validate(input('post.'),[
					'captcha|验证码'=>'require|captcha'
				]);
        $va = true;
				if(true !== $va){
					alert($va);
				} else {
		    		$user = $this->userModel->login(input('post.name'));
		    		if(empty($user)){
		    			alert('用户名|手机号|email或密码错误！');
		    		} else {
		    			if(md5(input('post.password').$user['salt']) === $user['password']){
  							cookie('time', $user['last_login_time']);
  							cookie('id', $user['user_id']);
  							cookie('name', md5($user['user_name']));
  							cookie('ss', md5(cookie('name').$user['password'].$user['user_id'].config('salt')));
  							$this->userModel->allowField('last_login_time')->save(['last_login_time'=>time()],['user_id'=>$user['user_id']]);
  							$this->userModel->save(['ip'=>Request::instance()->ip()],['user_id'=>$user['user_id']]);
		    				  return redirect('index/index'); 
						  } else {
							 alert('用户名|手机号|email或密码错误！');
						  }
		    		}
				  } 
    		}
    	} 
    	return view();	
  	}

  	public function validation(){
  		if(!empty(cookie('ss')) && !empty(cookie('name')) && !empty(cookie('id'))){
            $user = $this->userModel->validation(cookie('id'));
            if(md5(md5($user['user_name']).$user['password'].$user['user_id'].config('salt')) !== cookie('ss')){
                return false;
            } else {
            	return true;
            }  
        } else {
            return false;
        }
  	}

  	public function history(){
  		if(!$this->validation()){
  			return redirect('login');
  		}

  		$history = $this->userModel->history(cookie('id'));
  		return view('history',['history'=>$history]);
  	}

  	public function comment(){
  		if(!$this->validation()){
  			return redirect('login');
  		}

  		$comment = $this->userModel->comment(cookie('id'));
  		return view('comment',['comment'=>$comment]);
  	}

  	public function msg(){
  		if(!$this->validation()){
  			return redirect('login');
  		}
      model('Msg')->save(['tag'=>0],['user_id'=>cookie('id')]);
  		$msg = $this->userModel->msg(cookie('id'));
    	return view('msg',['msg'=>$msg]);
  	}

    public function info(){
      if(!$this->validation()){
        return redirect('login');
      }
      if(empty(input('param.user_id'))){
        $id = cookie('id');
      } else {
        $id = input('param.user_id');
      }
      $info = $this->userModel->getInfo($id);
      $info['time'] = date('Y/m/d',$info['last_login_time']);
      return view('info',['info'=>$info]);
    }

    public function modify(){
      if(!$this->validation()){
        return redirect('login');
      }
      $id = cookie('id');
      $info = $this->userModel->getInfo($id);
      if(!empty(input('post.'))){
        $data = input('post.');
        $request = Request::instance();
        $data['ip'] = $request->ip();
        if(!empty(request()->file())){
          $data['head_portrait'] = $this->upload();
        } else {
          $data['head_portrait'] = $info['head_portrait'];
        }
        $this->userModel->allowField(['user_name','tel','email'])->save(['user_name'=>'','tel'=>0,'email'=>''],['user_id'=>cookie('id')]);
        if(empty($data['password']) && empty($data['repassword']) && empty($data['old_password'])){
            $result = $this->userModel->modify($data,$id,1);
        } else{
            if(md5(input('post.old_password').$info['salt']) !== $info['password']){
              $result = 0;
              alert('密码错误!');
            } else {
              $str = str_shuffle('023456789qwertyuopasdfghjkzxcvbnm,./l;\[]!@#$%^&*()_+~`{}:|?');
              $data['salt'] = substr($str, 0 , 8);
              $data['password'] = md5(input('post.password').$data['salt']);
              $data['repassword'] = md5(input('post.repassword').$data['salt']);   
              $result = $this->userModel->modify($data,$id);
            } 
        }
        if($result === true){
          return redirect('info');
        } else {
          $this->userModel->allowField(['user_name','tel','email'])->save(['user_name'=>$indo['user_name'],'tel'=>$indo['tel'],'email'=>$indo['email']],['user_id'=>$id]);
        }
      }
      return view('modify',['info'=>$info]);  
    }

    public function upload(){
      // 获取表单上传文件 例如上传了001.jpg
      $file = request()->file('head_portrait');
      // 移动到框架应用根目录/public/uploads/ 目录下
      $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
      if($info){
        return $info->getSaveName();
      }else{
        // 上传失败获取错误信息
        alert($file->getError());
      }
    }

    public function find(){
      if(!empty(input('post.mail'))){
        $email = stripslashes(trim(input('post.mail'))); 
        $row = $this->userModel->efind($email); 
        if(empty($row)){//该邮箱尚未注册！ 
          return 'noreg'; 
        }else{ 
          $getpasstime = time(); 
          $uid = $row['user_id']; 
          $token = md5($uid.$row['user_name'].$row['password']);//组合验证码 
          $url = 'http://'.$_SERVER['SERVER_NAME'].url('reset',['email'=>$email,'token'=>$token]);//构造URL 
          $time = date('Y-m-d H:i'); 
          $result = $this-> sendmail($time,$email,$url); 
          if($result==1){//邮件发送成功 
            $msg = '系统已向您的邮箱发送了一封邮件,请登录到您的邮箱及时重置您的密码！'; 
            //更新数据发送时间
            $this->userModel->allowField('getpasstime')->save(['getpasstime'=>$getpasstime],['user_id'=>$uid]);
          }else{ 
            $msg = $result; 
          } 
          return $msg; 
        }
      }
      return view();
    }

    //发送邮件 
    public function sendmail($time,$email,$url){ 
      $smtpserver = "smtp.163.com"; //SMTP服务器，如smtp.163.com 
      $smtpserverport = 25; //SMTP服务器端口 
      $smtpusermail = "13541062430@163.com"; //SMTP服务器的用户邮箱 
      $smtpuser = "13541062430@163.com"; //SMTP服务器的用户帐号 
      $smtppass = "wyb960426"; //SMTP服务器的用户密码 
      $smtp = new Smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); 
      //这里面的一个true是表示使用身份验证,否则不使用身份验证. 
      $emailtype = "HTML"; //信件类型，文本:text；网页：HTML 
      $smtpemailto = $email;
      $smtpemailfrom = $smtpusermail; 
      $emailsubject = /*"www.jb51.net*/ "- 密码找回"; 
      $emailbody = "亲爱的".$email."：<br/>您在".$time."提交了找回密码请求。请点击下面的链接重置密码 
      （按钮24小时内有效）。<br/><a href='".$url."'target='_blank'>".$url."</a>"; 
      $rs = $smtp->sendmail($smtpemailto, $smtpemailfrom, $emailsubject, $emailbody, $emailtype); 
       
      return $rs; 
    }

    public function reset(){
      $token = stripslashes(trim(input('param.token'))); 
      $email = stripslashes(trim(input('param.email'))); 
      if(!empty(input('post.'))){
        $va = $this->validate(input('post.'),[
          'captcha|验证码'=>'require|captcha'
        ]);
        $va = true;
        if(true !== $va){
          alert($va);
        } else {
          $data = input('post.');
          $str = str_shuffle('023456789qwertyuopasdfghjkzxcvbnm,./l;\[]!@#$%^&*()_+~`{}:|?');
          $data['salt'] = substr($str, 0 , 8);
          $data['password'] = md5(input('post.password').$data['salt']);
          $result = $this->userModel->reset($data,$email);
          if(true === $result){
            alert($result);
          } else {
            return redirect('login');
          }
        }
      } else {
        $row = $this->userModel->where('email',$email)->find(); 
        if(!empty($row)){ 
          $mt = md5($row['user_id'].$row['user_name'].$row['password']);
          if($mt==$token){ 
            if(time()-$row['getpasstime']>24*60*60){ 
              $msg = '该链接已过期！'; 
            }else{ 
              //重置密码... 
              $msg = '<form action="'.url('reset').'" method="post" class="form-horizontal"><div class="form-group"><div class="col-sm-12"><input type="password" name="password" placeholder="密码" class="form-control" required></div></div><div class="form-group"><div class="col-sm-12"><input type="password" name="repassword" placeholder="确认密码" class="form-control" required></div></div><div class="form-group"><div class="col-sm-12"><input type="text" name="captcha" placeholder="验证码" class="form-control" required></div></div><div class="form-group"><div class="col-sm-12"><div><img id="verify_img" src="'.captcha_src().'" alt="验证码" class="img-responsive" style="margin-bottom: 20px;"></div></div></div><div class="form-group"><div class="col-sm-12" style="text-align: center;"><input type="submit" value="修改密码" class="btn btn-default" style="min-width: 50%;"></div></div></form>'; 
            } 
          }else{ 
            $msg = '无效的链接'; 
          } 
        }else{ 
          $msg = '错误的链接！'; 
        } 
      }
      return view('reset',['msg'=>$msg]);
    }
}
