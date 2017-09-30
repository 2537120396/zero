<?php
namespace app\admin\validate;
use think\Validate;

class Comment extends Validate
{
	protected $rule = [
		'art_id' => 'number'
	];
	protected $message = [
		'art_id.number' => '文章id不合法',
	];	
}