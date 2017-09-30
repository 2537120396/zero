<?php
namespace app\index\validate;
use think\Validate;

class Email extends Validate
{
	protected $rule = [
		'email'=>'email|unique:user'
	];
	protected $message = [
		'email.email' => '请输入正确的邮箱地址',
		'email.unique' => '该邮箱已注册'
	];	
}