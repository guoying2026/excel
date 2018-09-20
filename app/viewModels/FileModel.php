<?php
use Illuminate\Database\Capsule\Manager as DB;

class FileModel extends Controller
{
	/**
	 * 向file表中存取文件基本信息
     */
	// public function c_or_u_file($condition){
	// 	$result = $this->model('File')::updateOrCreate([
	// 		'version' => $condition['version'],
	// 		'filepath' => $condition['filepath']
	// 	],[
	// 		'field_row' => $condition['field_row'],
	// 		'field_num' => $condition['field_num'],
	// 		'measures_column' => $condition['measures_column'],
	// 		'value_row_start' => $condition['value_row_start']
	// 	]);
	// 	return $result;
	// }
	public function c_or_u_file($condition){
		$result = $this->model('File')::create($condition);
		return $result;
	}
}