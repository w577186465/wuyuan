<?php
	defined('IN_PHPCMS') or exit('No permission resources.');
	class news {
		function lists(){
			$catid = 41;
			$categorys = getcache('category_content_1','commons');
			$db = pc_base::load_model('content_model');
			$category = $categorys[$catid];
			$modelid = $category['modelid'];
			$db->set_model($modelid);
			$page = isset($_GET["page"]) ? $_GET["page"] : 1;
			$start = ($page - 1) * 30;
			$data = $db->select("id > 0", "*", $start . ",30", "id desc");
			foreach($data as $key=>$v){
				$time = strtotime(date('Y-m-d', time()));
				$v["inputtime"] = $v["inputtime"] > $time ? "今天 " . date("H:i",$v["inputtime"]) : date("m-d H:i", $v["inputtime"]);
				$v["relevantgp"] = json_decode($v["relevantgp"]);
				$data[$key] = $v;
			}
			header("Content-Type = 'application/json;charset=UTF-8'");
			echo json_encode($data);
		}
		
		function position(){
			$position = pc_base::load_model('position_data_model');
			$page = isset($_GET["page"]) ? $_GET["page"] : 1;
			$start = ($page - 1) * 30;
			$data = $position->select("", "id", $start . ",30", "id desc");
			$ids = "";
			foreach($data as $v){
				$ids[] = $v["id"];
			}
						
			$catid = 41;
			$categorys = getcache('category_content_1','commons');
			$db = pc_base::load_model('content_model');
			$category = $categorys[$catid];
			$modelid = $category['modelid'];
			$db->set_model($modelid);
			
			$ids = implode('\',\'', $ids);
			$data = $db->select("`id` IN ('$ids')", '*', '', 'id desc');
			foreach($data as $key=>$v){
				$time = strtotime(date('Y-m-d', time()));
				$v["inputtime"] = $v["inputtime"] > $time ? "今天 " . date("H:i",$v["inputtime"]) : date("m-d H:i", $v["inputtime"]);
				$v["relevantgp"] = json_decode($v["relevantgp"]);
				$res[$key] = $v;
			}
			
			header("Content-Type = 'application/json;charset=UTF-8'");
			echo json_encode($res);
		}
		
		function show(){
			if(!isset($_GET['id']) || !isset($_GET['catid'])) exit('error');
			$where['id'] = $_GET['id'];
			$categorys = getcache('category_content_1','commons');
			$category = $categorys[$_GET['catid']];
			$modelid = $category['modelid'];
			
			$db = pc_base::load_model('content_model');
			
			$db->set_model($modelid);

			$data = $db->get_one($where);
			
			//股票指数转数组
			$gpindex = explode(' ',trim($data['gpindex'],'|'));
			$gpindex = array_diff($gpindex, array(null));
			$data['gpindex'] = count($gpindex) > 0 ? $gpindex : null;
			$data['relevantgp'] = string2array($data['relevantgp']);
			$tablename = $db->table_name;
			$db->table_name = $db->table_name.'_data';
			$more = $db->get_one($where);
			$data['inputtime'] = date('Y-m-d') == date('Y-m-d',$data['inputtime']) ? date('今天 H:i',$data[inputtime]) : date('y-m-d H:i',$data[inputtime]);
			$data['content'] = $more['content'];
			
			//相关文章
			if($more['relation']){
				$relations = explode('|',trim($more['relation'],'|'));
				$relations = array_diff($relations, array(null));
				$relations = implode(',',$relations);
				
				$sql = " `id` IN ($relations)";
				$order = 'inputtime desc';
				$db->table_name = $tablename;
				$relarr = $db->select($sql, '*', '', '','','id');
				$data['relation'] = $relarr;
			}
			header('Content-type:text/json');
			echo json_encode($data);
		}
	}