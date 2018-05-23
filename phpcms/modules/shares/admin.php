<?php

defined('IN_PHPCMS') or exit('No permission resources.');
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

class admin {

	function init(){
		
	}
	
	function update_gpinfo(){
		$gpdata = $this->gpdata();
		$pagesize = 20;
		$pagenum = ceil (count($gpdata)/$pagesize);
		include template("shares","gpinfo_update");
	}
	
	function ajax_update(){
		$num = isset($_GET['num']) ? $_GET['num'] : 10;
		$page = $_GET['page'];
		$first = ($page-1)*$num+1;
		$data = $this->gpdata();
		$allnum = count($data);
		$last = $first + $num > $allnum ? $allnum :  $first + $num;
		$db = pc_base::load_model('gpdata_model');
		for($i=$first;$i<$last;$i++){
			if(empty($data[$i]))
				continue;
			$updata['name'] = $data[$i][1];
			$updata['code'] = $data[$i][0];
			$updata['zhangfu'] = $data[$i][2];
			$updata['price'] = $data[$i][3];
			$updata['zhangdie'] = $data[$i][4];
			$updata['buyprice'] = $data[$i][5];
			$updata['sellprice'] = $data[$i][6];
			$updata['zongliang'] = $data[$i][7];
			$updata['xianliang'] = $data[$i][8];
			$updata['zhangsu'] = $data[$i][9];
			$updata['huanshou'] = $data[$i][10];
			$updata['jinkai'] = $data[$i][11];
			$updata['top'] = $data[$i][12];
			$updata['bottom'] = $data[$i][13];
			$updata['zuoshou'] = $data[$i][14];
			$updata['shiying'] = $data[$i][15];
			$updata['zongjin'] = $data[$i][16];
			$updata['liangbi'] = $data[$i][17];
			$updata['hangye'] = $data[$i][18];
			$updata['city'] = $data[$i][19];
			$updata['zhenfu'] = $data[$i][20];
			$updata['junjia'] = $data[$i][21];
			$updata['neipan'] = $data[$i][22];
			$updata['waipan'] = $data[$i][23];
			$updata['nwbi'] = $data[$i][24];
			$updata['buynum'] = $data[$i][25];
			$updata['sellnum'] = $data[$i][26];
			$updata['ltgb'] = $data[$i][28];
			if($db->count('code = ' . $data[$i][0])){
				$db->update($updata,'code = ' . $data[$i][0]);
			}else{
				$db->insert($updata);
			}
		}
		echo 'success';
	}
	
	function gpdata(){
		$data = file(PHPCMS_PATH . '/data/gpdata.txt');
		foreach($data as $key=>$v){
			$line = str_replace(array(' '),'',preg_replace('|\s+|',',',$v));
			$line = explode(',',substr($line,0,strlen($str)-1)); 
			$line = $key==0 ? array() : $line;
			$newdata[] = $line;
		}
		return $newdata;
	}
}