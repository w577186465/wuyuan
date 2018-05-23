<?php
class webGrabhandle{
	private $content, $title;
	function __construct($content, $title){
		$this->content = $content;
		$this->title = $title;
	}
	public function init(){
		if(!$this->titlenograb($this->title))
			_error("标题含有过滤关键词！", 11);
		
		if($this->nograb($content) == false){
			_error('该文章可能为被过滤文章！', 11);
		}
		//过滤html
		$content = strip_tags($this->content);
		
		//过滤替换内容
		$content = $this->filter($content);
		
		//股票信息
		$sharedata = $this->sharehandle($content);
		
		//返回信息
		$result = array();
		$result['content'] = $content;
		$result['share'] = $sharedata;
		
		return $result;
	}
	
	//判断是否为不需要的文章
	public function nograb($content){
		$nokey = array(
			'捉妖股必备神器'
		);
		
		foreach($nokey as $v){
			if(strpos($content, $v)){
				return false;
				exit();
			}
		}
		
		return true;
	}
	
	public function titlenograb($title){
		$nokey = array(
			'云财经'
		);
		
		foreach($nokey as $v){
			if(strpos($title, $v)){
				return false;
				exit();
			}
		}
		
		return true;
	}
	
	//过滤和替换
	public function filter($content){
		$filters = array(
			array('云财经', '时光学堂'),
			array('摘于[\s\S]*', '摘于 时光学堂）'),
			array('WWW.YUNCAIJING.COM', 'www.kleyqq.com'),
			array('财联社，','时光学堂')
		);
		
		foreach($filters as $v){
			$key2 = isset($v[1]) ? $v[1] : '';
			$replaces['key1'][] = '/'. $v[0]. '/';
			$replaces['key2'][] = $key2;
		}
		return preg_replace($replaces['key1'], $replaces['key2'], $content);
	}
	
	//生成股票信息
	public function sharehandle($content){
		$gpdata = get_gpdata();
		$gpindexs = "";
		foreach($gpdata as $key=>$v){
			if(strstr($content,$v['name']) || strstr($content,$v['code'])){
				//股票信息
				$index[] = array(
					'allname' => $v['allname'],
					'name' => $v['name'],
					'code' => $v['code'],
					'id' => $key
				);
				//股票索引
				$gpindexs .= empty($gpindexs) ? $v['code'] : ",". $v['code'];
				//生成文章股票代码
				$pattern = '/'. $v["name"]. '.{0,1}' . $v["code"] .'.{0,1}/';
				$sharehtml = '<span share-code="'. $v["code"] .'">'. $v["allname"] .'</span>';
				if(preg_match($pattern, $content))
					$content = preg_replace($pattern, $sharehtml, $content);
				elseif(strstr($content,$v['name']))
					$content = str_replace($v['name'], $sharehtml, $content);
				elseif(strstr($content,$v['code']))
					$content = str_replace($v['code'], $sharehtml, $content);
				
			}
		}
		
		$data = array();
		$data['index'] = $index;
		$data['gpindexs'] = $gpindexs;
		$data['content'] = $content;
		return $data;
	}
}