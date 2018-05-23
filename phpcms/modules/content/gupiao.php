<?php

set_time_limit(300);

defined('IN_PHPCMS') or exit('No permission resources.');

//模型缓存路径

//定义在单独操作内容的时候，同时更新相关栏目页面

define('RELATION_HTML',true);



pc_base::load_app_class('admin','admin',0);

class gupiao {
	
	function init(){

	}
	
	function checkgp(){
		/*if(!$_POST['content']){
			exit('error');
		}*/
		$info = $_POST['content'];
		$gpdata = get_gpdata();
		foreach($gpdata as $key=>$v){
			if(strstr($info,$v['name']) || strstr($info,$v['code'])){
				$index[] = [
					'allname' => $v['allname'],
					'name' => $v['name'],
					'code' => $v['code'],
					'id' => $key
				];
			}
		}
		$res = [
			'result'=>$index
		];
		header('Content-type:text/json');
		echo json_encode($res);
	}
}

?>