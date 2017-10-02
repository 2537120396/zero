<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"E:\history\www\wblog/./application/admin\view\arts\artlist.html";i:1506596259;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="renderer" content="webkit" />
	<title>零之书后台管理系统</title>
	<meta name="aplus-xplug" content="NONE">
<link rel="stylesheet" href="__PUBLIC__/static/css/bootstrap.min.css">
<link rel="stylesheet" href="__PUBLIC__/static/css/fa.css">
</head>
<body>
<header class="page-header">
	<h1>零之书<small>没有人会嘲笑竭尽全力的人</small></h1>
</header>
<nav id="adminav" class="navbar navbar-inverse">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">Zero</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">分类管理<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo url('index/index'); ?>">分类列表</a></li>
					<li><a href="<?php echo url('cats/catadd'); ?>">分类添加</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">文章管理<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo url('artlist'); ?>">文章列表</a></li>
					<li><a href="<?php echo url('artadd'); ?>">文章发布</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">用户<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo url('comment/user'); ?>">用户列表</a></li>
					<li><a href="<?php echo url('commet/comment'); ?>">评论列表</a></li>
					<li><a href="<?php echo url('comment/reply'); ?>">回复列表</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">其他<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo url('index/pass'); ?>">修改密码</a></li>
					<li><a href="<?php echo url('index/index/index'); ?>">博客首页</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-3 col-lg-3 hidden-xs" id="aside">
			<aside class="panel panel-info">
				<div class="panel-heading">分类管理</div>
				<ul class="list-group">
					<li class="list-group-item"><a href="<?php echo url('index/index'); ?>">分类列表</a></li>
					<li class="list-group-item"><a href="<?php echo url('cats/catadd'); ?>">分类添加</a></li>
				</ul>
			</aside>
			<aside class="panel panel-info">
				<div class="panel-heading">文章管理</div>
				<ul class="list-group">
					<li class="list-group-item"><a href="<?php echo url('artlist'); ?>">文章列表</a></li>
					<li class="list-group-item"><a href="<?php echo url('artadd'); ?>">文章发布</a></li>
				</ul>
			</aside>
			<aside class="panel panel-info">
				<div class="panel-heading">用户</div>
				<ul class="list-group">
					<li class="list-group-item"><a href="<?php echo url('comment/user'); ?>">用户列表</a></li>
					<li class="list-group-item"><a href="<?php echo url('comment/comment'); ?>">评论列表</a></li>
					<li class="list-group-item"><a href="<?php echo url('comment/reply'); ?>">回复列表</a></li>
				</ul>
			</aside>
			<aside class="panel panel-info">
				<div class="panel-heading">其他</div>
				<ul class="list-group">
					<li class="list-group-item"><a href="<?php echo url('index/pass'); ?>">修改密码</a></li>
					<li class="list-group-item"><a href="<?php echo url('index/index/index'); ?>">博客首页</a></li>
				</ul>
			</aside>
		</div>
		<div class="col-sm-9 col-md-9 col-lg-9">
			<form class="form-inline" style="text-align: right">
				<div class="form-group">
					<input list="keys" type="text" class="form-control" placeholder="Search.." name="search"/>
					<datalist id="keys">
					<?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					  <option value="<?php echo $vo['cat_name']; ?>">
					<?php endforeach; endif; else: echo "" ;endif; ?>
					</datalist>
				</div>
			    <button type="submit" class="btn btn-info glyphicon glyphicon-search"></button>
			</form>
			<div class="table-responsive">
				<table class="table table-hover top">
					<thead>
						<tr class="info">
							<th>标题</th>
							<th>点击数</th>
							<th>评论数</th>
							<th>最后修改时间</th>
							<th>分类序号</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($arts) || $arts instanceof \think\Collection || $arts instanceof \think\Paginator): $i = 0; $__LIST__ = $arts;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
						<tr>
							<td scope="row"><?php echo $v['title']; ?></td>
							<td><?php echo $v['clicknum']; ?></td>
							<td><a href="<?php echo url('comment/comment',['art_id'=>$v['art_id']]); ?>"><?php echo $v['comnum']; ?></a></td>
							<td><?php echo date("Y/m/d H:i",$v['update_time']); ?></td>
							<td><?php echo $v['cat_id']; ?></td>
							<td><a href="<?php echo url('artedit',['art_id'=>$v['art_id']]); ?>">编辑</a>|<a href="<?php echo url('artdel',['art_id'=>$v['art_id']]); ?>" class="delete">删除</a></td>
						</tr>
					<?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
					</tbody>
				</table>
			</div>
			<nav aria-label="Page navigation" id="page">
				<ul class="pagination">
					<?php echo $arts->render(); ?>
				</ul>
			</nav>
		</div>
	</div>
</div>
<footer>Dsign By Wyb</footer>
</body>
<script src="__PUBLIC__/static/js/jquery.min.js"></script>
<script src="__PUBLIC__/static/js/bootstrap.min.js"></script>
<script src="__PUBLIC__/static/js/fa.js"></script>
<script>
$(window).scroll(function(){var bot=$("header").outerHeight();if($(window).scrollTop()>=bot){$("#adminav").addClass("navbar-fixed-top")}else{$("#adminav").removeClass("navbar-fixed-top")}});
</script>
</html>