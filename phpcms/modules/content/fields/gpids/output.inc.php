function chexing($field, $value) {
	$pp = pc_base::load_model('qcbrand_model');
	$cx = pc_base::load_model('qcmodel_model');
	
	$values = string2array(new_html_entity_decode($value));
	$ids = '';
	$n = 0;
	foreach($values as $v){
		$n++;
		$ids .= $n==1 ? $v : '\',\'' .$v;
	}
	
	//获取车型
	$where = "`id` IN ('".$ids."')";
	$cx = $cx->select($where);
	$pids = '';
	$n = 0;
	foreach($cx as $v){
		$n++;
		$pids[] = $v['parentid'];
	}
	array_unique($pids);
	$pids = implode('\',\'',$pids);
	foreach($cx as $v){
		$cxdata[$v['parentid']][] = array('name'=>$v['name']);
	}
	
	//获取品牌
	$where = "`id` IN ('".$pids."')";
	$pp = $pp->select($where);
	
	$n = 0;
	/*foreach($pp as $v){
		$n++;
		$data[$n] = array('name'=>$v['name'], 'headword'=>$v['headword']);
		foreach($cxdata[$v['id']] as $c){
			$data[$n]['cx'][] = array('name'=>$c['name']);
		}
	}*/
	
	$data = '';
	foreach($pp as $v){
		$n++;
		$data .= '<div class="item">';
		$data .= '<h3>'. $v['name'] .'</h3>';
		foreach($cxdata[$v['id']] as $c){
			$data .= '<span>'. $c['name'] .'</span>';
		}
		$data .= '<div class="clear"></div></div>';
	}

	return $data;
}