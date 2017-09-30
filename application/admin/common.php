  	<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

//admin公共文件
function validation($data){
	if(!empty(cookie('adminss')) && !empty(cookie('adminname'))){
    if(md5($data['adminname'].$data['adminpassword'].$data['adminid'].$data['salt']) !== cookie('adminss')){
        return false;
        } else {
        	return true;
        }  
    } else {
        return false;
    }
}