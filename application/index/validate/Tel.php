<?php
namespace app\index\validate;
use think\Validate;

class Tel extends Validate
{
	protected $rule = [
		'tel'=>'regex:^1[34578]\d{9}$|unique:user'
	];
	protected $message = [
		'tel.regex' => '请输入正确的手机号',
		'tel.unique' => '该手机号已注册'
	];	
}