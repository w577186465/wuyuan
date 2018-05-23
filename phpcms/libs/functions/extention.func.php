<?php
/**
 *  extention.func.php 用户自定义函数库
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-10-27
*/

define('PUBLIC_DIR', 'public');

function get_puburl($file, $type){
	return siteurl(1). '/' . PUBLIC_DIR . '/'. $type .'/' . $file;
}

function get_script($file, $type){
	if($type=='css')
		return '<link href="'. $file .'" rel="stylesheet" type="text/css" />';
	elseif($type=='js')
		return '<script type="text/javascript" src="'. $file .'"></script>';
}

function script_html($file, $type){
	if(strpos($file, ',')){
		$arr = explode(',', $file);
		$html = '';
		foreach($arr as $v){
			$url = get_puburl($v, $type);
			$html .= get_script($url, $type);
		}
		return $html;
	}else{
		$url = get_puburl($file, $type);
		return get_script($url, $type);
	}
}

function css($file){
	return script_html($file, 'css');
}

function js($file){
	return script_html($file, 'js');
}

function pubimg($file){
	return siteurl(1). '/' . PUBLIC_DIR . '/img/' . $file;
}

function tradingrb(){
	$sites = array('qq','163','126','hotmail','gmail');
	$time = time();
	for($i=0;$i<40;$i++){
		$index = rand(0, count($sites)-1);
		$site = $sites[$index];
		$len = rand(3,5);
		$xlen = rand(3,5);
		$time = $time - rand(100,1200);
		$randwn = rand(0, 1);
		$randyk = myrand(7);
		$tqrand = myrand(7);
		$first = '';
		if($randwn){
			for($w=0;$w<$len;$w++){
				$first .= chr(rand(97, 122));
			}
		}else{
			for($w=0;$w<$len;$w++){
				$first .= rand(1, 9);
			}
		}
		$xing = '';
		for($w=0;$w<$xlen;$w++){
			$xing .= '*';
		}
		$date = date('m-d h:i:s',$time) . '<br>';
		$name = $first . $xing . '@' . $site . '.com';
		$benjins = array(5,10,25,50,100,250,500,750,1000);
		$index2 = rand(0, count($benjins)-1);
		$benjin = $benjins[$index2];
		if($randyk)
			$yk = '盈利' . $benjins[$index2]*1.7;
		else
			$yk = '亏损' . $benjin;
		?>
			<li>
				<div class="indFutModTit3RListItem">
					<div class="line1">
						<span class="name"><?php echo $name; ?></span>
						<span class="time"><?php echo $date; ?></span>
					</div>
					<div class="des">买入<?php echo $benjin; ?>元60秒期权，<?php echo $yk; ?></div>
				</div>
			</li>
		<?php
	}
}

function myrand($n){
	$rands = rand(1,10);
	return $rands>$n ? 0 : 1;
}

function gpindextoarray($gpindex){
	$return = explode(' ',trim($gpindex,'|'));
	$return = array_diff($return, array(null));
	return $return;
}

function get_gpdata($id){
	include "caches/data/gpdata.php";
	return $id ? $gpdata[$id] : $gpdata;
}

function relgplist($data){
	$data = string2array($data);
	$data = array_diff($data, array(null));
	$return = '';
	foreach($data as $v){
		$url = '/index.php??m=content&c=shares&a=page&code=' . $v['code'];
		$return .= '<a href="'. $url .'" target="_blank">'. $v['allname'];
		$return .= '<em><img src="' . get_gpimage($v['code']) . '"/></em></a>';
	}
	return $return;
}

function notfound(){
	header('HTTP/1.1 404 Not Found');
	include template('content','404');
	exit;
}

function showtime($sort){
	if(date('Y-m-d') == date('Y-m-d',$sort))
		$date = '今天' . date('H:i',$sort);
	elseif(date('Y') == date('Y',$sort))
		$date = date('m-d H:i',$sort);
	else
		$date = date('y-m-d H:i',$sort);
	return $date;
}

function get_gpimage($code, $time='day', $size='small'){
	$codeFirst = floor(intval($code)/100000);
	$city = $codeFirst == 6 ? 'sh' : 'sz';
	
	if($size=='small'){
		$img = 'http://image.sinajs.cn/newchart/small/n'. $city . $code .'.gif';
	}else{
		//时分 min daily weekly monthly
		$img = 'http://image.sinajs.cn/newchart/'. $time .'/n/'. $city . $code .'.gif';
	}
	return $img;
}

function get_gpcity($code, $returncode=false){
	$codeFirst = floor(intval($code)/100000);
	$city = $codeFirst == 6 ? 'sh' : 'sz';
	return $returncode=='code' ? $city . $code : $city;
}

function json_tip($text, $code, $data){
	header("Content-Type = 'application/json;charset=UTF-8'");
	$data = array();
	$data['code'] = $code;
	$data['msg'] = $text;
	echo json_encode($data);
	exit;
}

function _error($text, $code = 0){
	json_tip($text, $code);
}

function _success($text, $code = 1){
	json_tip($text, $code);
}

function kxtime ($tsp) {
	if(date('Y-m-d') == date('Y-m-d',$tsp)) {
		$date = date('今天 H:i',$tsp);
	}
	else{
		$date = date('m-d H:i',$tsp);
	}
	return $date;
}

function bignum ($val, $decimal = 2) {
	if ($val > 100000000) {
		return round($val/100000000, $decimal) . "亿";
	} else {
		return round($val/10000, $decimal) . "万";
	}
}

function getindustry() {
	$ind_db = pc_base::load_model('industry_model');
	$industry = $ind_db->select("",'*','','');
	return $industry;
}