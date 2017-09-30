<?php
namespace app\index\controller;

class Index
{
	public $index;

	public function __construct(){
		$this->index = model('Index');
	}

    public function index()
    {
    	$cats = $this->index->getCats();
    	if(empty(input('param.cat_id'))){
    		$id = false;
    	} else {
    		$id = input('param.cat_id');
    	}
    	$arts = $this->index->getArts($id);
    	$harts = $this->index->hot();
        if(!empty(cookie('ss')) && !empty(cookie('name')) && !empty(cookie('id'))){
            $user = $this->index->getUser(cookie('id'));
            $num = $this->index->msg(cookie('id'));
            $num = $num['count(*)'];
            if(md5(md5($user['user_name']).$user['password'].$user['user_id'].config('salt')) !== cookie('ss')){
                $user = [];
                $num = 0;
            }    
        } else {
            $user = [];
            $num = 0;
        }
        $time = date('Y/m/d',cookie('time'));
        return view('index',['arts'=>$arts,'cats'=>$cats,'harts'=>$harts,'user'=>$user,'num'=>$num,'time'=>$time]);
    }

    public function rindex()
    {
    	$cats = $this->index->getCats(2);
    	if(empty(input('param.cat_id'))){
    		$id = false;
    	} else {
    		$id = input('param.cat_id');
    	}
    	$arts = $this->index->getArts($id,2);
    	$harts = $this->index->hot();
                if(!empty(cookie('ss')) && !empty(cookie('name')) && !empty(cookie('id'))){
            $user = $this->index->getUser(cookie('id'));
            $num = $this->index->msg(cookie('id'));
            $num = $num['count(*)'];
            if(md5(md5($user['user_name']).$user['password'].$user['user_id'].config('salt')) !== cookie('ss')){
                $user = [];
                $num = 0;
            }    
        } else {
            $user = [];
            $num = 0;
        }
        $time = date('Y/m/d',cookie('time'));
        return view('index',['arts'=>$arts,'cats'=>$cats,'harts'=>$harts,'user'=>$user,'num'=>$num,'time'=>$time]);
    }

    public function qindex()
    {
    	$cats = $this->index->getCats(3);
    	if(empty(input('param.cat_id'))){
    		$id = false;
    	} else {
    		$id = input('param.cat_id');
    	}
    	$arts = $this->index->getArts($id,3);
    	$harts = $this->index->hot();
        if(!empty(cookie('ss')) && !empty(cookie('name')) && !empty(cookie('id'))){
            $user = $this->index->getUser(cookie('id'));
            $num = $this->index->msg(cookie('id'));
            $num = $num['count(*)'];
            if(md5(md5($user['user_name']).$user['password'].$user['user_id'].config('salt')) !== cookie('ss')){
                $user = [];
                $num = 0;
            }    
        } else {
            $user = [];
            $num = 0;
        }
        $time = date('Y/m/d',cookie('time'));
        return view('index',['arts'=>$arts,'cats'=>$cats,'harts'=>$harts,'user'=>$user,'num'=>$num,'time'=>$time]);
    }

    public function search()
    {
    	if(empty(input('get.search'))){
    		return redirect('index');
    	} else {
    		$key = input('get.search');
	    	$arts = $this->index->searchArts($key,1);
            $key = input('get.search');
	        return view('search',['arts'=>$arts,'key'=>$key]);
    	}
    }

}
