<?php
namespace app\index\validate;
use think\Validate;

class Password extends Validate
{
	protected $rule = [
		'value'=>'min:6'
	];
	protected $message = [
		'value.min' => '密码长度不能低于6位'
	];	
}