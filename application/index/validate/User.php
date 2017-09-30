<?php
namespace app\index\validate;
use think\Validate;

class User extends Validate
{
	protected $rule = [
		'user_name'=>'length:1,6|unique:user',
		'tel'=>'regex:^1[34578]\d{9}$|min:1|unique:user',
		'password'=>'min:6:require',
		'repassword'=>'confirm:password|min:1',
		'email'=>'email|require|unique:user'
	];
	protected $message = [
		'user_name.max' => '用户名应在1-6个字符之间',
		'user_name.unique'=>'用户名已存在',
		'tel.regex' => '请输入正确的手机号',
		'tel.min'=>'手机号不能为空',
		'tel.unique'=>'该手机号已注册',
		'repassword.confirm' => '两次密码输入不一致',
		'repassword.min'=>'请确认密码',
		'password.min' => '密码长度不能低于6位',
		'password.require'=>'密码不能为空',
		'email.email' => '请输入正确的邮箱地址',
		'email.require'=>'邮箱不能为空',
		'email.unique'=>'该邮箱已注册'
	];	

	protected $sence = [
		'reset'=>['password','repassword'],
		'nopass'=>['user_name','tel','email'],
	];
}