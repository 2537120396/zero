<?php
namespace app\index\controller;

class Arts
{

	public $artModel;
	public $index;

	public function __construct(){
		$this->artModel = model('Arts');
		$this->index = model('Index');
	}

    public function art()
    {
    	if(empty(input('param.art_id'))){
    		return redirect('index/index');
    	}
    	$id = input('param.art_id');
    	$content = $this->artModel->content($id);
      $comments = $this->artModel->comments($id);
      $pic = [];
      foreach($comments as $v){
        $pic[$v['com_id']][] = model('Comment')->getPic($v['com_id']);
      }
      $replys = [];
      foreach($comments as $v){
        $replys[$v['com_id']][] = $this->artModel->replys($v['com_id']);
      }
    	$harts = $this->index->hot();
    	if($this->validation()){
	    	$user = $this->index->getUser(cookie('id'));
	        $num = $this->index->msg(cookie('id'));
          $num = $num['count(*)'];
	        $data = ['user_id'=>cookie('id'),'art_id'=>$id,'update_time'=>time()];
	        $this->artModel->addHistory($data);
	        $number = $this->artModel->record($data);
    	} else {
    		$num = 0;
    		$user = [];
    		$data = ['user_id'=>0,'art_id'=>$id,'update_time'=>time()];
    		$number = $this->artModel->record($data,0);
    	}
    	$arr = ['clicknum'=> $number['count(*)']];
    	$this->artModel->updateNum($arr,$id);
    	$art = $this->artModel->art($id);
  	  $cats = $this->artModel->cats($art[0]['pid']);
    	if($art[0]['pid'] == 1){
    		$str = 'index';
    	} else if($art[0]['pid'] == 2) {
    		$str = 'rindex';
    	} else {
    		$str = 'qindex';
    	}
      $time = date('Y/m/d',cookie('time'));
      $s  = $this->artModel->seo($id);
      foreach($s as $v){
        $seo['title'] = $v['title'];
        $seo['info'] = $v['info'];
        $seo['keywords'][] = $v['keyword'];
      }
    	return view('art',['art'=>$art,'content'=>$content,'cats'=>$cats,'harts'=>$harts,'user'=>$user,'num'=>$num,'comments'=>$comments,'replys'=>$replys,'str'=>$str,'pic'=>$pic,'time'=>$time,'id'=>cookie('id'),'seo'=>$seo]);
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

   public function comment(){
   		if(!$this->validation()){
   			return redirect('user/login');
   		}
   		if(!empty(input('post.content'))){
        if(count(input('post.content'))>100){
          alert('评论不能超过100个字符！');
        } else {
   			  $data['comment'] = input('post.content');
        }
   		}
      $urlcan = pathinfo($_SERVER['HTTP_REFERER'])['filename'];
  		$data['art_id'] = $urlcan;
  		$data['user_id'] = cookie('id');
  		$id = model('Comment')->add($data);
      dump($id);
	    if(!empty($id)){
        if(!empty(input('file.pho'))){
      		$pic = $this->upload();
      		if($pic === false){
      			model('Comment')->where('com_id',$id)->delete();
      		}
      		foreach ($pic as $v) {
      			$image[]['pic'] = $v;
      		}
          foreach($image as $k=>$v){
            $image[$k]['com_id'] = $id;
          }
      		$result = model('Comment')->pic($image);
      		if(true !== $result){
      			model('Comment')->where('com_id',$id)->delete();
      		}
        }
      }
    return redirect('art',['art_id'=>$urlcan]);
  }

   public function upload(){
		// 获取表单上传文件
		$files = request()->file('pho');
		foreach($files as $file){
			// 移动到框架应用根目录/public/uploads/ 目录下
			$info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
			if($info){
				// 成功上传后 获取上传信息
				$images[] = $info->getSaveName();
			}else{
				// 上传失败获取错误信息
				$images[] = $file->getError();
			}
		}
		return $images;
	}

	public function reply(){
		if(!$this->validation()){
   			return redirect('user/login');
   		}
   		if(!empty(input('post.content'))){
        if(count(input('post.content'))>100){
          alert('评论不能超过100个字符！');
        } else {
     			$data['msg'] = input('post.content');
     			$data['com_id'] = input('post.com_id');
          $data['user_id'] = model('Comment')->uid($data['com_id'])['user_id'];
          $urlcan = pathinfo($_SERVER['HTTP_REFERER'])['filename'];
          $data['art_id'] = $urlcan;
     			$data['uid'] = cookie('id');
     			model('Msg')->add($data);
          $comment = model('Comment')->where('com_id',$data['com_id'])->find();
          $num = $comment['num'] + 1;
          model('Comment')->allowField('num')->save(['num'=>$num],['com_id'=>$data['com_id']]);
        }
   		}
   		return redirect('art',['art_id'=>$urlcan]);
	}

	public function creply(){
		if(!$this->validation()){
   			return redirect('user/login');
   		}
 		if(!empty(input('post.content'))){
      if(count(input('post.content'))>100){
        alert('评论不能超过100个字符！');
      } else {
        $urlcan = pathinfo($_SERVER['HTTP_REFERER'])['filename'];
        $data['art_id'] = $urlcan;
   			$data['com_id'] = input('post.uid2');
        $data['user_id'] = model('Msg')->uid(input('post.mid'))['uid'];
        $name = model('User')->getName($data['user_id'])['user_name'];
        $data['msg'] = '@'.$name.' '.input('post.content');
   			$data['uid'] = cookie('id');
   			model('Msg')->add($data);
        $comment = model('Comment')->where('com_id',$data['com_id'])->find();
        $num = $comment['num'] + 1;
        model('Comment')->allowField('num')->save(['num'=>$num],['com_id'=>$data['com_id']]);
      }
 		}
 		return redirect('art',['art_id'=>$urlcan]);
	}

  public function del(){
    if(!$this->validation()){
        return redirect('user/login');
    }
    if(!empty(input('param.com_id'))){
      $id = input('param.com_id');
      model('Comment')->where('com_id',$id)->delete(); 
    } else if(!empty(input('param.mid'))){
      $id = input('param.mid');
      model('Msg')->where('mid',$id)->delete(); 
    }
    $urlcan = pathinfo($_SERVER['HTTP_REFERER'])['filename'];
    return redirect('art',['art_id'=>$urlcan]);
  }
}
