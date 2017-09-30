<?php
namespace app\admin\controller;

class Arts
{

	public $artModel;
	public $keyModel;
	public $conModel;

	public function __construct()
	{
		$this->artModel = model('Arts');
		$this->keyModel = model('Keywords');
		$this->conModel = model('Contents');
	}

    public function artAdd()
    {	
        if(!empty(cookie('adminname'))){
    	   $data = model('Admin')->validation(cookie('adminname'));      
        } else {
            return redirect('index/login');
        }
    	$data['salt'] = config('salt');
    	if(!validation($data)){
    		return redirect('index/login');
    	}
    	$cats = model('Cats')->where('pid','>',0)->select();
    	if(!empty(input('post.'))){
	    	foreach(array_keys($_POST) as $v){
	    		if(strpos($v,'keyword') !== false){
	    			$keys[]['keyword'] = $_POST[$v];
	    		} else {
	    			$msg[$v] = $_POST[$v]; 
	    		}
	    	}
	    	if(!empty(input('post.content'))){
	    		$content['content'] = input('post.content');
	    		unset($msg['content']);
	    	}
	    	if(!empty(request()->file())){
	    		$pic = $this->upload();
	    		$msg['pic'] = $pic['saveName'];
	    		$msg['ext'] = $pic['ext'];
	    		if(!empty($msg['pic'])){
		    		$image = \think\Image::open(ROOT_PATH.'/public/uploads/'.$msg['pic']);
		    		$width = 450;
		    		$height = 450;
		    		$path = './public/uploads/'.date('Ymd').'/thumb'.$width.$height.time().'==.jpg';
					$image->thumb($width, $height)->save($path);
					$msg['thumb'] = date('Ymd').'/thumb'.$width.$height.time().'==.jpg';	
	    		}
	    	}
	    	$id = $this->artModel->add($msg);
	    	if(empty($id)){
	    		$id = false;
	    		return view('artadd',['cats'=>$cats]);
	    	}

	    	if(!empty($keys)){
	    		foreach($keys as $k=>$v){
	    			$keys[$k]['art_id'] = $id;
	    		}
	    		$result = $this->keyModel->add($keys);
	    		if(true !== $result){
					$this->artModel->del($id);
	    			return view('artadd',['cats'=>$cats]);
	    		}
	    	}
	    	if(!empty($content)){
	    		$content['art_id'] = $id;
	    		$re = $this->conModel->add($content);
	    		if(true !== $re){
					$this->artModel->del($id);
	    			return view('artadd',['cats'=>$cats]);
	    		}
	    	} else {
	    		$this->artModel->del($id);
	    		alert('内容不能为空');
	    		return view('artadd',['cats'=>$cats]);
	    	}
	    	$cat = model('Cats')->where('cat_id',$msg['cat_id'])->find();
	    	$num = $cat['num'] + 1;
	    	model('Cats')->allowField('num')->save(['num'=>$num],['cat_id'=>$msg['cat_id']]);
		}
		return view('artadd',['cats'=>$cats]);
    }

    public function upload(){
		// 获取表单上传文件 例如上传了001.jpg
		$file = request()->file('pic');
		// 移动到框架应用根目录/public/uploads/ 目录下
		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
		if($info){
			// 成功上传后 获取上传信息
			$pic['ext'] = $info->getExtension();
			$pic['saveName'] = $info->getSaveName();
			return $pic;
		}else{
			// 上传失败获取错误信息
			alert($file->getError());
		}
	}

	public function artList()
	{
        if(!empty(cookie('adminname'))){
    	   $data = model('Admin')->validation(cookie('adminname'));      
        } else {
            return redirect('index/login');
        }
    	$data['salt'] = config('salt');
    	if(!validation($data)){
    		return redirect('index/login');
    	}
		$cats = model('Cats')->field('cat_name')->select();
		if(!empty(input('get.search'))){
			$search = input('get.search');
		} else {
			$search = '';
		}
		$arts = $this->artModel->getArts($search);
		return view('artlist',['arts'=>$arts,'cats'=>$cats]);
	}

	public function artEdit()
	{
        if(!empty(cookie('adminname'))){
    	   $data = model('Admin')->validation(cookie('adminname'));      
        } else {
            return redirect('index/login');
        }
    	$data['salt'] = config('salt');
    	if(!validation($data)){
    		return redirect('index/login');
    	}
		$cats = model('Cats')->where('pid','>',0)->select();
		$id = input('param.art_id');
    	if(!empty(input('post.'))){
	    	foreach($_POST['keyword'] as $v){
	    		$keys[]['keyword'] = $v;
	    	}
	    	if(!empty($keys)){
	    		unset($_POST['keyword']);	
	    		$msg = $_POST;
	    	}

	    	if(!empty(input('post.content'))){
	    		$content['content'] = input('post.content');
	    		unset($msg['content']);
	    	}
	    	if(!empty(request()->file())){
	    		$pic = $this->upload();
	    		$msg['pic'] = $pic['saveName'];
	    		$msg['ext'] = $pic['ext'];
	    		if(!empty($msg['pic'])){
		    		$image = \think\Image::open(ROOT_PATH.'/public/uploads/'.$msg['pic']);
		    		$width = 450;
		    		$height = 450;
		    		$path = '/public/uploads/'.date('Ymd').'/thumb'.$width.$height.time().'==.jpg';
					$image->thumb($width, $height)->save($path);
					$msg['thumb'] = date('Ymd').'/thumb'.$width.$height.time().'==.jpg';	
	    		}
	    	}
	    	$jieguo = $this->artModel->aupdate($msg,$id);
	    	if(true !== $jieguo){
	    		return redirect('artlist');
	    	}
	    	$this->keyModel->kdel($id);
	    	if(!empty($keys)){
	    		foreach($keys as $k=>$v){
	    			$keys[$k]['art_id'] = $id;
	    		}
	    		$result = $this->keyModel->add($keys);
	    		if(true !== $result){
					$this->artModel->del($id);
	    			return view('artadd',['cats'=>$cats]);
	    		}
	    	}
	    	if(!empty($content)){
	    		$re = $this->conModel->cup($content,$id);
	    		if(true !== $re){
	    			return redirect('artlist');
	    		}
	    	} else {
	    		alert('内容不能为空');
	    	}
	    	return redirect('artlist');
		} else {
			$art = $this->artModel->where('art_id',$id)->select();
			$keywords = $this->keyModel->where('art_id',$id)->select();
			$con = $this->conModel->where('art_id',$id)->select();
			return view('artedit',['art'=>$art,'cats'=>$cats,'keys'=>$keywords,'content'=>$con]);
		}
	}

	public function artdel(){
        if(!empty(cookie('adminname'))){
    	   $data = model('Admin')->validation(cookie('adminname'));      
        } else {
            return redirect('index/login');
        }
    	$data['salt'] = config('salt');
    	if(!validation($data)){
    		return redirect('index/login');
    	}
		$id = input('param.art_id');
		if(!is_numeric($id)){
			alert('文章id不合法');
			return redirect('artlist');
		}
		$art = $this->artModel->where('art_id',$id)->select();
		if(count($art) == 0){
			alert('分类不存在');
			return redirect('index/index');
		}
		$cat_id = $this->artModel->where('art_id',$id)->find();
		$this->keyModel->kdel($id);
		$this->conModel->del($id);
		$this->artModel->del($id);
		$cat = model('Cats')->where('cat_id',$cat_id['cat_id'])->find();
    	$num = $cat['num'] - 1;
    	model('Cats')->allowField('num')->save(['num',$num],['cat_id'=>$cat_id]);
		return redirect('artlist');
	}
}
