<?php
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
defined('IN_PHPCMS') or exit('No permission resources.');
class index {

	function init(){
		require_once(dirname(__FILE__) . '/classes/php_python.php');
		$res = ppython("shares::go",'002648');
		$data = json_decode($res);
		
		echo '<pre>';
		print_r($data);
	}
	
	function get_k_data(){
		require_once(dirname(__FILE__) . '/classes/php_python.php');
		if(isset($_GET['code']) && !empty($_GET['code'])){
			$code = $_GET['code'];
		}else{
			echo json_encode(array('code'=>0,'msg'=>'参数错误！'));
			exit;
		}
		$ktype = isset($_GET['ktype']) && !empty($_GET['ktype']) ? $_GET['ktype'] : 'D';
		
		//天数
		$now = time();
		$day = 60*60*24;
		$day60 = date('Y-m-d',$now - $day * 60);
		$year1 = date('Y-m-d',$now - $day * 365);
		if($ktype == 'D')
			$start = isset($_GET['start']) && !empty($_GET['start']) ? $_GET['start'] : $day60;
		if($ktype == 'W')
			$start = isset($_GET['start']) && !empty($_GET['start']) ? $_GET['start'] : $year1;
		if($ktype == 'M')
			$start = isset($_GET['start']) && !empty($_GET['start']) ? '' : $year1;
		$end = date('Y-m-d',time());
		
		$res = ppython("k_line::get_k_data", $code , $ktype, $start, '');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: http://www.kleyqq.com');
		$data = json_decode($res);
		$n = 0;
		foreach($data->date as $key=>$v){
			$line[$n][] = $v;
			$line[$n][] = $data->open->$key;
			$line[$n][] = $data->close->$key;
			$line[$n][] = $data->low->$key;
			$line[$n][] = $data->high->$key;
			$n++;
		}
		echo json_encode($line);
	}
	
}