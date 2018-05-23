<?php

defined('IN_PHPCMS') or exit('No permission resources.');

class input {
	
	public function init() {
		$username = 'admin';
		$pwd = '159263asdf++,,';
		if($_POST['username']!=$username || $_POST['pwd']!=$pwd) exit('error');
		if(!isset($_POST["catid"]) || is_null($_POST["catid"])) {
			exit('error');
		}
		$catid = $_POST["catid"];
		$categorys = getcache('category_content_1','commons');
		$db = pc_base::load_model('content_model');
		$category = $categorys[$catid];
		$modelid = $category['modelid'];
		$db->set_model($modelid);
		
		$data = $_POST;
		
		if($db->add_content($data))
			exit('success');
		else
			exit('error');
	}
	
}	