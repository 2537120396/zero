<?php
namespace app\admin\validate;
use think\Validate;

class Arts extends Validate
{
	protected $rule = [
		'title' => 'require|max:20|unique:arts|token',
		'cat_id' => 'number',
		'info' => 'require|max:50',
		'ext'=>'in:jpg,png,gif'
	];
	protected $message = [
		'title.require' => '标题不能为空',
		'title.max' => '标题最多不能超过20个字符',
		'title.unique'=>'该标题已存在',
		'title.token' => '不能重复提交',
		'info.require'=>'简介不能为空',
		'info.max'=>'简介最多不能超过50个字符',
		'cat_id.number'>'分类id不合法',
		'ext.in'=>'请上传jpg|png|gif'
	];	
}