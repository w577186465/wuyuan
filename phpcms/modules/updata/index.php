<?php

defined('IN_PHPCMS') or exit('No permission resources.');

class index {
	
	public function __construct() {
		$this->db = pc_base::load_model('content_model');
		$this->categorys = getcache('category_content_1','commons');
	}
	
	function init(){
		//设置不采集关键词
		$nokey = [
			'捉妖股必备神器'
		];
		
		//过滤文章
		foreach($nokey as $v){
			if(strpos($_POST['content'], $v))
				exit('error 该文章含过滤关键词');
		}
		
		$catid = 41;
		$username = 'admin';
		$pwd = '159263asdf++,,';
		if($_POST['username']!=$username || $_POST['pwd']!=$pwd) exit('error');
		$categorys = getcache('category_content_1','commons');
		$db = pc_base::load_model('content_model');
		$category = $categorys[$catid];
		$modelid = $category['modelid'];
		$db->set_model($modelid);
		//如果该栏目设置了工作流，那么必须走工作流设定
		$setting = string2array($category['setting']);
		$workflowid = $setting['workflowid'];
		
		$data['title'] = $_POST['title'];
		$data['inputtime'] = $_POST['time'];
		$data['updatetime'] = $_POST['time'];
		$data['content'] = $_POST['content'];
		$data['description'] = str_cut(strip_tags($_POST['content']),280);
		$data['catid'] = $catid;
		$data['status'] = 99;
		
		//股票相关信息
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
				$gpindexs .= empty($gpindexs) ? $v['code'] : ",". $v['code'];
			}
		}
		
		$data['gpindex'] = $gpindexs;
		$data['relevantgp'] = $index;
		if($db->add_content($data))
			exit('success');
		else
			exit('error');
	}
	
	function chackgp(){
		if(!$_POST['content']){
			exit('error');
		}
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
	
	function upgprel(){
		$db = pc_base::load_model('content_model');
		$modelid = 1;
		$id = $_GET['id'];
		
		$db->set_model($modelid);
		$w['id'] = $id;
		$data = $db->get_one($w);
		$table_name = $db->table_name;
		$db->table_name = $db->table_name . "_data";
		$more = $db->get_one($w);
		$db->table_name = $table_name;
		//股票相关信息
		$info = $more['content'];
		$gpdata = get_gpdata();
		foreach($gpdata as $key=>$v){
			if(strstr($info,$v['name']) || strstr($info,$v['code'])){
				$index[] = [
					'allname' => $v['allname'],
					'name' => $v['name'],
					'code' => $v['code'],
					'id' => $key
				];
				$gpindexs .= empty($gpindexs) ? $v['code'] : ",". $v['code'];
			}
		}
		if(isset($gpindexs) && !empty($gpindexs)) $data['gpindex'] = $gpindexs;
		if(isset($index) && !empty($index)) $data['relevantgp'] = $index;
		$db->edit_content($data,$id);
	}
	
	function datalist(){
		$modelid = 1;
		$db = pc_base::load_model('content_model');
		$db->set_model($modelid);
		$data = $db->select();
		header('Content-type:text/json');
		echo json_encode($data);
	}
	
	function test(){
		header('Content-type:text/json');
		$data = [
			'code' => 'success'
		];
		echo json_encode($data);
	}
}