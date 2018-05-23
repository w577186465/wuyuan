<?php

defined('IN_PHPCMS') or exit('No permission resources.');


pc_base::load_app_class('admin', 'admin', 0);

class industry extends admin {
	public function index() {
		$ind_db = pc_base::load_model('industry_model');
		$industry = $ind_db->select();
		include $this->admin_tpl("industry");
	}
	
	
}