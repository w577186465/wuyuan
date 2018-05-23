<?php

defined('IN_PHPCMS') or exit('No permission resources.');


pc_base::load_app_class('admin', 'admin', 0);

class industry extends admin {
	public function index() {
		if (isset($_GET["page"]) && intval($_GET["page"])  > 0) {
			$page = $_GET["page"];
		} else {
			$page = 1;
		}
		$pagesize = 20;
		$ind_db = pc_base::load_model('industry_model');
		$industry = $ind_db->listinfo('', '', $page, $pagesize);
		$pages = $ind_db->pages;
		include $this->admin_tpl("industry");
	}
	
	
}