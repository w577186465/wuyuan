<?php

defined('IN_PHPCMS') or exit('No permission resources.');

class index {
	
	public function __construct() {
		$this->db = pc_base::load_model('content_model');
	}
	
	function init(){
		
	}
	
	function next_page_ajax(){
		$num = isset($_GET['num']) && is_numeric($_GET['num']) ? $_GET['num'] : 20;
		$start = isset($_GET['start']) && is_numeric($_GET['start']) ? $_GET['start'] : 20;
		$limit = $start . ',' . $num;
		
		$where['catid'] = $_GET['catid'];
		
		$categorys = getcache('category_content_1','commons');
		$category = $categorys[$_GET['catid']];
		$modelid = $category['modelid'];
		$this->db->set_model($modelid);
		$data = $this->db->select($where, $data = '*', $limit, $order = 'inputtime desc', $group = '', $key='');
		foreach($data as $key=>$v){
			$res[$key] = $v;
			$res[$key]['relevantgp'] = string2array($v['relevantgp']);
		}
		header('Content-type:text/json');
		echo json_encode($res);
	}
	
	function kx_page_ajax(){
		if(!isset($_GET['id']) || !isset($_GET['catid'])) exit('error');
		$where['id'] = $_GET['id'];
		$categorys = getcache('category_content_1','commons');
		$category = $categorys[$_GET['catid']];
		$modelid = $category['modelid'];
		$this->db->set_model($modelid);

		$data = $this->db->get_one($where);
		
		//股票指数转数组
		$gpindex = explode(' ',trim($data['gpindex'],'|'));
		$gpindex = array_diff($gpindex, array(null));
		$data['gpindex'] = count($gpindex) > 0 ? $gpindex : null;
		$data['relevantgp'] = string2array($data['relevantgp']);
		$tablename = $this->db->table_name;
		$this->db->table_name = $this->db->table_name.'_data';
		$more = $this->db->get_one($where);
		$data['inputtime'] = date('Y-m-d') == date('Y-m-d',$data['inputtime']) ? date('今天 H:i',$data[inputtime]) : date('y-m-d H:i',$data[inputtime]);
		$data['content'] = $more['content'];
		
		//相关文章
		if($more['relation']){
			$relations = explode('|',trim($more['relation'],'|'));
			$relations = array_diff($relations, array(null));
			$relations = implode(',',$relations);
			
			$sql = " `id` IN ($relations)";
			$order = 'inputtime desc';
			$this->db->table_name = $tablename;
			$relarr = $this->db->select($sql, '*', '', '','','id');
			$data['relation'] = $relarr;
		}
		header('Content-type:text/json');
		echo json_encode($data);
	}
	
	function test(){
		if(!isset($_GET['id']) || !isset($_GET['catid']) || !isset($_GET['key'])) exit('error');
		$catid = $_GET['catid'];
		$categorys = getcache('category_content_1','commons');
		$category = $categorys[$_GET['catid']];
		$modelid = $category['modelid'];
		$this->db->set_model($modelid);
		$tablename = $this->db->table_name;
		$this->db->table_name = $this->db->table_name.'_data';
		$where = 'content like "%'. $_GET['key'] .'%"';
		$idsarr = $this->db->select($where, 'id');
		
		foreach($idsarr as $v){
			$ids[] = $v['id'];
		}
		$ids = implode(',',$ids);
		$sql = " `id` IN ($ids)";
		$this->db->table_name = $tablename;
		$list = $this->db->select($sql);
		include template('content','list_gpindex','wuyuan');
	}
}