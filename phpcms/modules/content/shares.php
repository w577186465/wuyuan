<?php
defined('IN_PHPCMS') or exit('No permission resources.');

define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

pc_base::load_app_func('util','content');

class shares {

	private $db, $gpdb, $share;

	function __construct() {

	}
	
	function init(){
		
	}
	
	function page(){
		if (!isset($_GET["code"])) {
			notfound();
		}

		// $this->video = pc_base::load_model('dgvideo_model');
		// $w = array();
		// $w["classid"] = 24;
		// $videos = $this->video->get_one($w);
		// print_r($videos);

		$this->share = pc_base::load_model('share_model');
		$code = $_GET["code"];
		$selshare = array();
		$selshare["code"] = $_GET["code"];
		$shareinfo = $this->share->get_one($selshare); // 股票基本信息
		// 判断涨跌
		if ($shareinfo["pricechange"] > 0) {
			$shareinfo["color"] = "red";
		} elseif ($shareinfo["pricechange"] < 0) {
			$shareinfo["color"] = "green";
		} else {
			$shareinfo["color"] = "gray";
		}
		$shareinfo["amo"] = $shareinfo["volume"]; // 交易量（手）

		$this->db = pc_base::load_model('content_model');
		$catid = 41;
		$acatid = '30,33';
		// 获取新闻
		$categorys = getcache('category_content_1','commons');
		$category = $categorys[$catid];
		$modelid = $category['modelid'];
		$this->db->set_model($modelid);
		$sql = '`catid` = '. $catid . ' and gpindex like "%'. $code .'%"';
		$plist = $this->db->listinfo($sql, $order = '', $page = 1, $pagesize = 20, $key='', $setpages = 10,$urlrule = '',$array = array());
		include template('content','gppage');
	}
	
	function dazong () {
		$db = pc_base::load_model('dazong_model');
		if(!isset($_GET["code"])) {
			exit();
		}
		$code = $_GET["code"];
		$data = $db->select("code = 000001",'*','','inputtime desc');
		echo "<pre>";
		print_r($data);
	}
}