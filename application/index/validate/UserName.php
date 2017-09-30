<?php
namespace app\index\validate;
use think\Validate;

class UserName extends Validate
{
	protected $rule = [
		'user_name'=>'max:6|unique:user'
	];
	protected $message = [
		'user_name.max' => '用户名最多不能超过6个字符',
		'user_name.unique'=>'用户名已存在'
	];	
}