<?php
namespace app\admin\controller;

class Cats 
{
	public $catModel;

	public function __construct(){
		$this->catModel = model('Cats');
	}

    public function catAdd()
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
    	if(!empty($_POST)){
    		$this->catModel->catAdd($_POST);
    	}
        return view();
    }
    
    public function catEdit()
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
    	$id = input('param.cat_id');
    	if(empty($_POST)){
	    	$validate = validate('Cats');
	    	$result = $validate->scene('edit')->check($id);
			if(false === $result){
				return redirect('index/index');
			}
			$cat = $this->catModel->where('cat_id',$id)->select();
			if(count($cat) == 0){
				return redirect('index/index');
			}
    		return view('catedit',['cat'=>$cat]);
    	} else {
    		$this->catModel->catUpdate($_POST,$id);
    		return redirect('index/index');
    	}
    }

    public function catDel()
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
    	$id = input('param.cat_id');
    	$validate = validate('Cats');
    	$result = $validate->scene('edit')->check($id);
		if(true !== $result){
			alert($validate->getError());
			return redirect('index/index');
		}
		$cat = $this->catModel->where('cat_id',$id)->select();
		if(count($cat) == 0){
			alert('分类不存在');
			return redirect('index/index');
		}
		$this->catModel->catDel($id);
		return redirect('index/index');
    }
}