<?php
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
defined('IN_PHPCMS') or exit('No permission resources.');

class webGrab {
	
	function init(){
		
		$username = 'admin';
		$pwd = '159263asdf++,,';
		if($_POST['username']!=$username || $_POST['pwd']!=$pwd)
			notfound();
		
		if(!isset($_POST['title']) || strlen($_POST['title']) < 1 || strlen($_POST['title']) > 254)
			_error("标题不存在或超过255个字符！");
		
		$title = $_POST['title'];

		if(!isset($_POST['content']) || strlen($_POST['content']) < 20)
			_error("内容不存在或过少！");
		
		$content = $_POST['content'];
		
		$time = isset($_POST['inputtime']) && strlen($_POST['inputtime']) == 10 ? $_POST['inputtime'] : time();
		
		//设置数据库
		$catid = 41;
		$categorys = getcache('category_content_1','commons');
		$db = pc_base::load_model('content_model');
		$category = $categorys[$catid];
		$modelid = $category['modelid'];
		$db->set_model($modelid);
		
		//工作流
		$setting = string2array($category['setting']);
		$workflowid = $setting['workflowid'];
		
		//处理信息
		pc_base::load_app_class('webGrabhandle', '', 0);
		$handle = new webGrabhandle($content, $title);
		$data = $handle->init();
		
		if($db->get_one("title like '%" . $title . "'"))
			_error("标题已存在！", 10);
		
		pc_base::load_app_class('xiangsidu', '', 0);
		$xiangsidu = new xiangsidu();
		
		$tablename = $db->table_name;
		$db->table_name = $tablename . "_data";
		$contents = $db->select("", "id,content", "0,10", "id desc");
		foreach($contents as $v){
			$tcontent = substr($handle->filter($v['content']),0,1000);
			$dcontent = substr($handle->filter($data['content']),0,1000);
			if($xiangsidu->getSimilar($dcontent,$tcontent) >= 0.6){
				_error("存在相似文章！". $xiangsidu->getSimilar($tcontent,$dcontent), 10);
			}
		}
		
		$input['title'] = $title;
		$input['content'] = $data['content'];
		$input['gpindex'] = $data['share']['gpindex'];
		$input['relevantgp'] = $data['share']['index'];
		$input['updatetime'] = $time;
		$input['inputtime'] = $time;
		$input['catid'] = $catid;
		$input['status'] = 99;
		if($_POST['description'])
			$input['description'] = substr($handle->filter($_POST['description']),0,300);
		else
			$input['description'] = substr($handle->filter($data['content']),0,300);
		if($db->add_content($input))
			_success('文章采集成功！');
		else
			_error('发布文章失败！', 3);
	}
	
}