<?php

defined('IN_PHPCMS') or exit('No permission resources.');

class caiji {
	
	public function __construct() {
		$this->db = pc_base::load_model('content_model');
		$this->categorys = getcache('category_content_1','commons');
	}
	
	private function get_catid($url){
		$caturl = [
			'gushi' => 30,
			'qihuo' => 31,
			'qiquan' => 32,
			'zhangting' => 33,
			'waihui' => 34,
			'zatan' => 35,
			'jiaoyi' => 39,
			'xuexi' => 40,
			'shizhan' => 36,
			'jiishu' => 37,
			'fenxiang' => 38,
			'rumen' => 15,
			'xinde' => 11,
			'jiaoyi' => 39,
			'xinde' => 40,
			'shizhan' => 36,
			'jishu' => 37,
			'fenxiang' => 38
		];
		$url = preg_replace('|http://[^/]+/|','',$url);
		$data = explode('/',$url);
		$count = count($data);
		if($count == 3)
			$key = 1;
		elseif($count == 4)
			$key = 2;
		elseif($count == 5)
			$key = 3;
		$cs = $data[$key];
		$catid = $caturl[$cs];
		return $catid;
	}
	
	private function get_id($url){
		$id = preg_replace('|.*?/(\d+)\.html|','$1',$url);
		return $id;
	}
	
	public function input(){
		$url = $_POST['url'];
		$id = $this->get_id($url);
		
		$modelid = 1;
		$catid = $this->get_catid($url);
		echo 'url:'.$url.';';
		$time = str_replace(' ','',$_POST['time']);
		
		$categorys = getcache('category_content_1','commons');
		$db = pc_base::load_model('content_model');
		$category = $categorys[$catid];
		$modelid = $category['modelid'];
		$db->set_model($modelid);
		
		//如果该栏目设置了工作流，那么必须走工作流设定
		$setting = string2array($category['setting']);
		$workflowid = $setting['workflowid'];
		
		$thumb = strstr($_POST['thumb'],"http");
		
		$data['id'] = $id;
		$data['thumb'] = $_POST['thumb'] ? $_POST['thumb'] : '';
		$data['title'] = $_POST['title'];
		$data['content'] = $_POST['content'];
		$data['description'] = str_cut(strip_tags($_POST['content']),250);
		$data['catid'] = $catid;
		$data['status'] = 99;
		$data['updatetime'] = $time;
		$data['inputtime'] = $time;
		
		
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
		
		$ishave = $this->ishave($id);
		if($db->add_content($data))
			exit('success');
		else{
			
			exit;
		}
			
	}
	
	function ishave($id){
		$db = pc_base::load_model('content_model');
		$db->set_model(1);
		$get = $db->get_one('id = '. $id);
		if($get)
			exit('数据已存在');
	}
	
}