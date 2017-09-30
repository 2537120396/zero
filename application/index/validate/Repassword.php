<?php
namespace app\index\validate;
use think\Validate;

class Repassword extends Validate
{
	protected $rule = [
		'value'=>'confirm:pass'
	];
	protected $message = [
		'value.confirm' => '两次密码输入不一致'
	];	
}