<?php
namespace app\admin\validate;
use think\Validate;

class Cats extends Validate
{
	protected $rule = [
		'cat_name' => 'require|max:10|unique:cats|token',
		'cat_id' => 'number',
	];
	protected $message = [
		'cat_name.require' => '名称不能为空',
		'cat_name.max' => '名称最多不能超过10个字符',
		'cat_name.unique'=>'该名称已存在',
		'cat_name.token' => '不能重复提交',
		'cat_id.number' => '分类id不合法',
	];	

	protected $scene = [
		'add' => ['cat_name'],
		'edit' => ['cat_id']
	];
}