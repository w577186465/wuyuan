<?php
defined('IN_PHPCMS') or exit('No permission resources.');
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
class index {
	private $db;

	public function __construct() {

		$this->db = pc_base::load_model('openaccount_model');

	}

	public function submit() {
		header('Content-type: application/json');
		$session_storage = 'session_'.pc_base::load_config('system','session_storage');
        pc_base::load_sys_class($session_storage);
        //验证码
        if (($_SESSION['code'] != strtolower($_POST['code'])) || empty($_SESSION['code'])) {
			return $this->r(0, "验证码错误！");
        } else {
			$_SESSION['code'] = '';
        }
		if (!isset($_POST["username"]) || $_POST["username"] == "") {
			return $this->r(0, "请填写姓名！");
		}
 
		if (!isset($_POST["tel"]) || !preg_match("/^1[34578]{1}\d{9}$/",$_POST["tel"])) {
			return $this->r(0, "请填写正确的手机号！");
		}
		$getwh = array();
		$getwh["tel"] = $_POST["tel"];
		$get = $this->db->get_one($getwh);
		if (!empty($get)) {
			return $this->r(0, "该电话以提交过了，联系人为：" . $get["name"] . "，请不要重复提交");
		}
		$data = array();
		$data["name"] = $_POST["username"];
		$data["tel"] = $_POST["tel"];
		$res = $this->db->insert($data, $return_insert_id = true, $replace = false);
		if ($res) {
			return $this->r(1, "提交成功！");
		}
	}
	
	private function r($state = 1, $msg = "") {
		header('Content-type: application/json');
		$data = array();
		$data["status"] = $state;
		$data["msg"] = $msg;
		echo json_encode($data);
	}
	
}