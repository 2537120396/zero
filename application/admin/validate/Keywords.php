<?php
namespace app\admin\validate;
use think\Validate;

class Keywords extends Validate
{
	protected $rule = [
		'keyword'=>'max:10'
	];
	protected $message = [
		'keyword.max' => '关键词最多不能超过10个字符'
	];	
}