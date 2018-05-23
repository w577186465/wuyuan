function gpids($field, $value) {
	if(isset($_POST[$field]))
		$data = array2string($_POST[$field]);
	elseif(!empty($value))
		$data = array2string($value);
	else
		$data = null;
	return $data;
}