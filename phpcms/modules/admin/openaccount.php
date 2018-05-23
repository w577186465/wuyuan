<?php

defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin', 'admin', 0);

class openaccount extends admin {

	private $db;

	public function __construct() {

		$this->db = pc_base::load_model('openaccount_model');

		parent::__construct();

	}

	public function qihuo() {
		if (isset($_GET["page"]) && intval($_GET["page"])  > 0) {
			$page = $_GET["page"];
		} else {
			$page = 1;
		}
		$pagesize = 20;
		$data = $this->db->listinfo('', '', $page, $pagesize);
		$pages = $this->db->pages;
		$pc_hash = $_SESSION['pc_hash'];
		include $this->admin_tpl("openaccount_list");
	}
	
	public function delete () {
		if (!isset($_GET["id"])) {
			showmessage(L('参数错误'), HTTP_REFERER);
		}
		$where = array();
		$where["id"] = $_GET["id"];
		$this->db->delete($where);
		showmessage(L('删除成功'), HTTP_REFERER);
	}
}