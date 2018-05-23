<?php

defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin', 'admin', 0);

class admind extends admin {

	private $db;

	public function __construct() {

		$this->db = pc_base::load_model('openaccount_model');

		parent::__construct();

	}

	public function qihuo() {
		echo "sdfds";
		$page = 1;
		if (isset($_GET["page"]) && intval($_GET["page"])  > 0) {
			$page = $_GET["page"];
		} else {
			$page = 1;
		}
		$pagesize = 1;
		$data = $this->db->listinfo('', '', $page, $pagesize);
		$pages = $this->db->pages;
		echo $this->admin_tpl("list");
		include $this->admin_tpl("list");
	}
	
}